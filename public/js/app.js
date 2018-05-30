function addEventListeners() {



var nav = document.querySelector('.navbar');
var navbarInput = document.querySelector('.nav');

nav.addEventListener("keyup", function(event) {
  console.log("cona");
  event.preventDefault();
  var htmlstring = navbarInput.innerHTML;
  htmlstring = (htmlstring.trim) ? htmlstring.trim() : htmlstring.replace(/^\s+/,'');

  if (event.keyCode === 13 && htmlstring != '') {
       console.log(htmlstring);
      document.getElementById('.nav').submit();
  }
});


 
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


function sendUpvoteRequest(event) {
  if (window.user == 0) {
    window.location.replace("/register");
    return;
  }

  let voting = this.closest('.voting');
  let id = this.closest('.card').getAttribute('data-id');

  sendAjaxRequest('get', '/api/content/up/' + id, null, function(){ return userUpvoteHandler(voting, id, this); });

  event.preventDefault();
}

function userUpvoteHandler(voting, id, obj) {

  let response = JSON.parse(obj.responseText);
  let voteCount = voting.querySelector('.votesCount');
  let votes = response.votes;


  switch(votes){
    case null: 
      return;
    default:{
      voteCount.innerHTML = votes;
    }
    break;
  }
}

function voteHandler() {
  if (this.status != 200) window.location = '/';
  let response = JSON.parse(this.responseText);
}

function sendDownvoteRequest(event) {

  if (window.user == 0) {
    window.location.replace("/register");
    return;
  }

  let voting = this.closest('.voting');
  let id = this.closest('.card').getAttribute('data-id');

  sendAjaxRequest('get', '/api/content/down/' + id, null, function(){ return userDownvoteHandler(voting, id, this); });

  event.preventDefault();
}


function userDownvoteHandler(voting, id, obj) {
  let response = JSON.parse(obj.responseText);
  let voteCount = voting.querySelector('.votesCount');
  let votes = response.votes;
  console.log(response);

  switch(votes){
    case null: 
      return;
    default:
      voteCount.innerHTML = votes;
    break;
  }
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


function toggleNavbar(){
  let nav = document.getElementById('navbarLinks');
  let liArray = nav.getElementsByTagName("li");

  let trending = liArray[0];
  let latest = liArray[1];
  let feed = liArray[2];

  let badges = document.querySelectorAll(".badge");

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

    else if(current.match('/user/*')){
      badges.forEach(function(badge){
        badge.classList.add('badge-success')
    });}
  
}

addEventListeners();
toggleNavbar();


