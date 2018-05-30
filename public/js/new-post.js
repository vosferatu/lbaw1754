let warn_on_unload = "You have unsaved changes!"


let ready = document.querySelector('input[type=checkbox]');


function addEventListeners() {
    let tags = [];

    let tagsAnchor = document.querySelectorAll('#sidebar .list-group a');

    tagsAnchor.forEach(function (tag) {
        tag.setAttribute("href", '#');
    });


    [].forEach.call(tagsAnchor, function (tagAction) {
        tagAction.addEventListener('click', function () { return selectTag(tags) });
    });



    if (ready != null)
        ready.addEventListener('change', readyCheck);

    let postCreator = document.querySelector('.publish');
    if (postCreator != null)
        postCreator.addEventListener('click', function () { return sendCreatePostRequest(tags) });


    let postDraft = document.querySelector('.saveDraft');
    if (postDraft != null)
        postDraft.addEventListener('click', function () { return sendCreatePostRequest(tags) });


    window.onbeforeunload = function () {
        if (warn_on_unload != "") {
            return warn_on_unload;
        }
    }

}


function selectTag(tags) {

    let tagSection = document.querySelector('.tagSection');

    console.log(event.target);

    if (!tags.includes(event.target.id)) { // nao existe

        if (tags.length > 2) {
            return;
        }
        event.target.innerHTML += "  &#10004";


        let span = document.createElement("span");
        span.setAttribute("class", "badge badge-pill badge-success ml-1 " + event.target.id);
        span.innerHTML = event.target.id;
        tagSection.appendChild(span);
        tags.push(event.target.id);

    }
    else { // ja existe la
        var index = tags.indexOf(event.target.id);
        if (index > -1) {
            tags.splice(index, 1);
        }
        event.target.innerHTML = event.target.id;

        let node = document.querySelector('.' + event.target.id);
        node.parentNode.removeChild(node);
    }

}

function sendCreatePostRequest(tags) {
    warn_on_unload = "";
   
    let published = 0;

    if(event.target.classList.contains("publish"))  
        published =1;


    let form = document.querySelector('.card-body');

    let title = document.querySelector('input[name=title]').value;
    let description = document.querySelector('input[name=description]').value;


    let card = document.querySelector(' #errors');

    if (title == "") {
        let divWarn = document.createElement("div");
        divWarn.innerHTML = `<div class="alert alert-danger my-2" role="alert">
        You must write a title.
      </div>`;
        card.appendChild(divWarn);
    }

    if (tags.length == 0) {
        let divWarn = document.createElement("div");
        divWarn.innerHTML = `<div class="alert alert-danger my-2" role="alert">
        You must select at least 1 tag.
      </div>`;
        card.appendChild(divWarn);
    }


    let text = CKEDITOR.instances["editor"].getData();


    if (text == "") {
        let divWarn = document.createElement("div");
        divWarn.innerHTML = `<div class="alert alert-danger my-2" role="alert">
        You must write the text.
      </div>`;
        card.appendChild(divWarn);
    }

    if (description == "") {
        let divWarn = document.createElement("div");
        divWarn.innerHTML = `<div class="alert alert-danger my-2" role="alert">
        You must write the description.
      </div>`;
        card.appendChild(divWarn);
    }

        sendAjaxRequest('post', '/api/post/create', { title: title, text: text, tags: tags, description: description, published: published }, postCreatedHandler);

}

function postCreatedHandler() {
    if (this.status != 200) window.location = '/';
    let response = JSON.parse(this.responseText);
        
    if(response['published'] == 1 )
    window.location = '/post/' + response['slug'];
    else(response['published'] == 0 )
    window.location = '/user/' + response['user_id']+'/drafts';
}



addEventListeners();


