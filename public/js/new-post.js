    let warn_on_unload = "You have unsaved changes!"

    let authors = [];

    let ready = document.querySelector('input[type=checkbox]');


function addEventListeners() { 
   
    
    let tags = [];

  let tagsAnchor = document.querySelectorAll('#sidebar .list-group a');

  tagsAnchor.forEach(function(tag){
    tag.setAttribute("href",'#');
  });
  

  [].forEach.call(tagsAnchor, function (tagAction) {
    tagAction.addEventListener('click', function() {return selectTag(tags)});
  });



  if (ready != null)
  ready.addEventListener('change', readyCheck);

  let postCreator = document.querySelector('.publish');
  if (postCreator != null)
   postCreator.addEventListener('click', function() {return sendCreatePostRequest(tags)});


   let postDraft = document.querySelector('.save');
   if (postDraft != null)
    postDraft.addEventListener('click', function() {return sendDraftPostRequest(tags)});


   let addAuthorButton = document.querySelector('.addAuthorButton');
   if (addAuthorButton != null)
   addAuthorButton.addEventListener('click', sendAuthorAddRequest );


   window.onbeforeunload = function () {
    if (warn_on_unload != "") {
        return warn_on_unload;
    }
}

}


function sendDraftPostRequest(tags){
        alert('oi');

    warn_on_unload = "";   
    let form = document.querySelector('.card-body');

    let title = document.querySelector('input[type=text]').value;

    let card = document.querySelector(' #errors');

    if(title == ""){
        let divWarn = document.createElement("div");
        divWarn.innerHTML=`<div class="alert alert-danger my-2" role="alert">
        You must write a title.
      </div>`;
      card.appendChild(divWarn);
    }

  


    let text = CKEDITOR.instances["editor"].getData();


    if(text == ""){
        let divWarn = document.createElement("div");
        divWarn.innerHTML=`<div class="alert alert-danger my-2" role="alert">
        You must write the text.
      </div>`;
      card.appendChild(divWarn);
    }

    let readyValue = 0;

    if(ready.checked){
        readyValue = 1;
       
    sendAjaxRequest('post', '/api/post/saveDraft', { title: title, text: text, tags: tags, authors: authors, published: 0, ready: readyValue }, postSavedHandler);

}
}


function postSavedHandler(){
    let response = JSON.parse(this.responseText);
}

function  sendAuthorAddRequest(){

    let inputBox = document.querySelector('input[name=author]');
    let username  = inputBox.value;
    inputBox.value = "";

    sendAjaxRequest('post', '/api/user/search/' + username, null, authorAddHandler);
    
}

function authorAddHandler(){
    let inputBox = document.querySelector('input[name=author]');

    //if (this.status != 200) window.location = '/';
    let user = JSON.parse(this.responseText);
    
    console.log(user);

    switch(user['user']) {
        case 'dontExist':{
            inputBox.style.borderColor = "red";
            inputBox.placeholder = "Couldn't find that user.";
        break;
    }
        case 'owner':{
            inputBox.style.borderColor = "red";
            inputBox.placeholder = "You can't add yourself as an author twice.";
        break;
    }
        default:{
            inputBox.placeholder = "Author";
            inputBox.style.borderColor = null;

            if (authors.includes(user['user']['id'])){
                inputBox.style.borderColor = "red";
                inputBox.placeholder = "Author already added.";
                return;
            }

            let ul = document.querySelector('#authorsList');

            let li = document.createElement("li");
            li.setAttribute("class", "list-group-item d-flex justify-content-between align-items-center");
            li.innerHTML= user['user']['username']; 
                let close = document.createElement("span");
                close.innerHTML = `<button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>`;
                li.setAttribute("id",user['user']['id']);
                li.appendChild(close);

                close.addEventListener('click', removeAuthorFromList)

            ul.appendChild(li);


            authors.push(user['user']['id']);
            let button = document.querySelector('.publish');

            if(authors.length != 0 )
                button.disabled = true;
            else 
             button.disabled = false;
        }
    }
}

function removeAuthorFromList(){
   let liAuthor =  this.closest('li');
   let authorId = liAuthor.id;
   
   console.log(authorId);
   console.log(authors);

   let index = authors.indexOf(authorId);
   console.log("index - "+index);
   authors.splice(index, 1);

   liAuthor.parentNode.removeChild(liAuthor);
   let button = document.querySelector('.publish');

   if(authors.length != 0 )
        button.disabled = true;
    else 
        button.disabled = false;
}


function selectTag(tags){

    let tagSection = document.querySelector('.tagSection');

    console.log(event.target);
  
    if( !tags.includes(event.target.id)){ // nao existe

        if(tags.length > 2){
            return;
        }
        event.target.innerHTML += "  &#10004";


        let span = document.createElement("span");
        span.setAttribute("class", "badge badge-pill badge-success ml-1 " + event.target.id);
        span.innerHTML= event.target.id;   
        tagSection.appendChild(span);    
        tags.push(event.target.id);
 
    }
    else { // ja existe la
        var index = tags.indexOf(event.target.id);
        if (index > -1) {
          tags.splice(index, 1);
        }
        event.target.innerHTML =event.target.id;

        let node = document.querySelector('.'+event.target.id);
        node.parentNode.removeChild(node);
    }
  
}

function sendCreatePostRequest(tags){
    warn_on_unload = "";   
    let form = document.querySelector('.card-body');

    let title = document.querySelector('input[type=text]').value;

    let card = document.querySelector(' #errors');

    if(title == ""){
        let divWarn = document.createElement("div");
        divWarn.innerHTML=`<div class="alert alert-danger my-2" role="alert">
        You must write a title.
      </div>`;
      card.appendChild(divWarn);
    }

    if(tags.length == 0){
        let divWarn = document.createElement("div");
        divWarn.innerHTML=`<div class="alert alert-danger my-2" role="alert">
        You must select at least 1 tag.
      </div>`;
      card.appendChild(divWarn);
    }


    let text = CKEDITOR.instances["editor"].getData();


    if(text == ""){
        let divWarn = document.createElement("div");
        divWarn.innerHTML=`<div class="alert alert-danger my-2" role="alert">
        You must write the text.
      </div>`;
      card.appendChild(divWarn);
    }

    if(ready.checked){
        sendAjaxRequest('post', '/api/post/create', { title: title, text: text, tags: tags, published: 1 }, postCreatedHandler);
    }
    else{
        let divWarn = document.createElement("div");
       divWarn.innerHTML=`<div class="alert alert-danger my-2" role="alert">
       You must set <b>ready to publish</b> before publishing.
     </div>`;
     card.appendChild(divWarn);
    }

}

function sendCreateDraftRequest(tags){
    let form = document.querySelector('.card-body');

    let title = document.querySelector('input[type=text]').value;
    let text = CKEDITOR.instances["editor"].getData();

    sendAjaxRequest('post', '/api/post/create', { title: title, text: text, tags: tags, published: 0 }, postCreatedHandler);
}

function postCreatedHandler(){
    if (this.status != 200) window.location = '/';
    let response = JSON.parse(this.responseText);
    window.location = '/post/' + response['slug'];
}

function readyCheck(){
   
    let own = document.querySelector('#own');
   
    let span = document.createElement("span");
    span.setAttribute("class", "badge badge-primary badge-pill checkOwn");
    span.setAttribute("id", "checkOwn");

    span.innerHTML= "&#10004";   

    
    if(this.checked) {
        own.appendChild(span);

    } else {// Checkbox is not checked..
        let spaned = document.querySelector('#checkOwn');
       spaned.parentNode.removeChild(spaned);
    }
}


addEventListeners();


