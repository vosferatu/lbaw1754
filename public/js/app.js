function addEventListeners() {
  let itemCheckers = document.querySelectorAll('article.card li.item input[type=checkbox]');
  [].forEach.call(itemCheckers, function (checker) {
    checker.addEventListener('change', sendItemUpdateRequest);
  });

  let itemCreators = document.querySelectorAll('article.card form.new_item');
  [].forEach.call(itemCreators, function (creator) {
    creator.addEventListener('submit', sendCreateItemRequest);
  });

  let itemDeleters = document.querySelectorAll('article.card li a.delete');
  [].forEach.call(itemDeleters, function (deleter) {
    deleter.addEventListener('click', sendDeleteItemRequest);
  });

  let cardDeleters = document.querySelectorAll('article.card header a.delete');
  [].forEach.call(cardDeleters, function (deleter) {
    deleter.addEventListener('click', sendDeleteCardRequest);
  });

  let cardCreator = document.querySelector('article.card form.new_card');
  if (cardCreator != null)
    cardCreator.addEventListener('submit', sendCreateCardRequest);

  let upvoteButtons = document.querySelectorAll('.upvote');
  [].forEach.call(upvoteButtons, function (upvote) {
    upvote.addEventListener('click', sendUpvoteRequest);
  });

  let downvoteButtons = document.querySelectorAll('.downvote');
  [].forEach.call(downvoteButtons, function (downvote) {
    downvote.addEventListener('click', sendDownvoteRequest);
  });

  let reportButtons = document.querySelectorAll('.report');
  [].forEach.call(reportButtons, function (report) {
    report.addEventListener('click', openReportModal);
  });

  let saveButtons = document.querySelectorAll('.save');
  [].forEach.call(saveButtons, function (save) {
    save.addEventListener('click', sendSaveRequest);
  });




}

function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function (k) {
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

function sendItemUpdateRequest() {
  let item = this.closest('li.item');
  let id = item.getAttribute('data-id');
  let checked = item.querySelector('input[type=checkbox]').checked;

  sendAjaxRequest('post', '/api/item/' + id, { done: checked }, itemUpdatedHandler);
}

function sendDeleteItemRequest() {
  let id = this.closest('li.item').getAttribute('data-id');

  sendAjaxRequest('delete', '/api/item/' + id, null, itemDeletedHandler);
}

function sendUpvoteRequest(event) {
  let voting = this.closest('.voting');
  let voteCount = voting.querySelector('.votesCount');

  if (window.user == 0) {
    window.location.replace("/register");
  }
  else {
    let id = this.closest('.card').getAttribute('data-id');
    sendAjaxRequest('put', '/api/content/up/' + id, null, voteHandler);
    voteCount.innerHTML = parseInt(voteCount.innerHTML)+1;
  }

  event.preventDefault();
}

function voteHandler() {
  if (this.status != 200) window.location = '/';
  let response = JSON.parse(this.responseText);
}

function sendDownvoteRequest(event) {
  let voting = this.closest('.voting');
  let voteCount = voting.querySelector('.votesCount');


  if (window.user == 0) {
    window.location.replace("/register");
  }
  else {
    let id = this.closest('.card').getAttribute('data-id');
    sendAjaxRequest('put', '/api/content/down/' + id, null, voteHandler);
    voteCount.innerHTML = parseInt(voteCount.innerHTML)-1;
  }

  event.preventDefault();
}

function voteHandler() {
  //if (this.status != 200) window.location = '/';
  let response = JSON.parse(this.responseText);
}

function openReportModal(event) {
  if (window.user == 0) {
    window.location.replace("/register");
  }
  else {
     $("#reportModal").modal();
     $("button#sendReportButton").click(function(){
      let id = this.closest('.card').getAttribute('data-id');
      let reason = document.querySelector('textarea[name=reason]').value;

      sendAjaxRequest('put', '/api/content/report/' + id, {reason: reason}, reportHandler);

     });
  }
}

function reportHandler() {
  if(this.status == 200) location.reload();
}


function sendSaveRequest(event) {

  if (window.user == 0) {
    window.location.replace("/register");
  }
  else {
    let id = this.closest('.card').getAttribute('data-id');
    sendAjaxRequest('put', '/api/content/save/' + id, null, voteHandler);
  }

  event.preventDefault();
}

function sendCreateItemRequest(event) {
  let id = this.closest('article').getAttribute('data-id');
  let description = this.querySelector('input[name=description]').value;

  if (description != '')
    sendAjaxRequest('put', '/api/cards/' + id, { description: description }, itemAddedHandler);

  event.preventDefault();
}

function sendDeleteCardRequest(event) {
  let id = this.closest('article').getAttribute('data-id');

  sendAjaxRequest('delete', '/api/cards/' + id, null, cardDeletedHandler);
}

function sendCreateCardRequest(event) {
  let name = this.querySelector('input[name=name]').value;

  if (name != '')
    sendAjaxRequest('put', '/api/cards/', { name: name }, cardAddedHandler);

  event.preventDefault();
}


function itemUpdatedHandler() {
  let item = JSON.parse(this.responseText);
  let element = document.querySelector('li.item[data-id="' + item.id + '"]');
  let input = element.querySelector('input[type=checkbox]');
  element.checked = item.done == "true";
}

function itemAddedHandler() {
  if (this.status != 200) window.location = '/';
  let item = JSON.parse(this.responseText);


  // Create the new item
  let new_item = createItem(item);

  // Insert the new item
  let card = document.querySelector('article.card[data-id="' + item.card_id + '"]');
  let form = card.querySelector('form.new_item');
  form.previousElementSibling.append(new_item);

  // Reset the new item form
  form.querySelector('[type=text]').value = "";
}

function itemDeletedHandler() {
  if (this.status != 200) window.location = '/';
  let item = JSON.parse(this.responseText);
  let element = document.querySelector('li.item[data-id="' + item.id + '"]');
  element.remove();
}

function cardDeletedHandler() {
  if (this.status != 200) window.location = '/';
  let card = JSON.parse(this.responseText);
  let article = document.querySelector('article.card[data-id="' + card.id + '"]');
  article.remove();
}

function cardAddedHandler() {
  if (this.status != 200) window.location = '/';
  let card = JSON.parse(this.responseText);

  // Create the new card
  let new_card = createCard(card);

  // Reset the new card input
  let form = document.querySelector('article.card form.new_card');
  form.querySelector('[type=text]').value = "";

  // Insert the new card
  let article = form.parentElement;
  let section = article.parentElement;
  section.insertBefore(new_card, article);

  // Focus on adding an item to the new card
  new_card.querySelector('[type=text]').focus();
}

function createCard(card) {
  let new_card = document.createElement('article');
  new_card.classList.add('card');
  new_card.setAttribute('data-id', card.id);
  new_card.innerHTML = `

  <header>
    <h2><a href="cards/${card.id}">${card.name}</a></h2>
    <a href="#" class="delete">&#10761;</a>
  </header>
  <ul></ul>
  <form class="new_item">
    <input name="description" type="text">
  </form>`;

  let creator = new_card.querySelector('form.new_item');
  creator.addEventListener('submit', sendCreateItemRequest);

  let deleter = new_card.querySelector('header a.delete');
  deleter.addEventListener('click', sendDeleteCardRequest);

  return new_card;
}

function createItem(item) {
  let new_item = document.createElement('li');
  new_item.classList.add('item');
  new_item.setAttribute('data-id', item.id);
  new_item.innerHTML = `
  <label>
    <input type="checkbox"> <span>${item.description}</span><a href="#" class="delete">&#10761;</a>
  </label>
  `;

  new_item.querySelector('input').addEventListener('change', sendItemUpdateRequest);
  new_item.querySelector('a.delete').addEventListener('click', sendDeleteItemRequest);

  return new_item;
}

function toggleNavbar(){
  let nav = document.getElementById('navbarLinks');
  let liArray = nav.getElementsByTagName("li");

  let trending = liArray[0];
  let latest = liArray[1];
  let feed = liArray[2];

  let badges = document.querySelectorAll(".badge");
  console.log(badges);  


  current = window.location.pathname;
  

  if(current == '/'){
    trending.classList.add('active');
    
    badges.forEach(function(badge){
        badge.classList.add('badge-warning')
    });
  }
  else if(current == '/latest'){
    latest.classList.add('active');
    badges.forEach(function(badge){
      badge.classList.add('badge-secondary')
  });
}
    else if(current == '/feed'){
      feed.classList.add('active');
      badges.forEach(function(badge){
        badge.classList.add('badge-success')
    });}

    else if(current.match("/tag/*")){
      let tag = current.split('/')[2];
      let tagSide = document.getElementById(tag);
      tagSide.classList.add('sidebarActive');

      badges.forEach(function(badge){
        badge.classList.add('badgeTag');
    });
      
    }
  
}

addEventListeners();
toggleNavbar();


