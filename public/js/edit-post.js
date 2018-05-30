let authors = [];

let warn_on_unload = "You have unsaved changes!"

function addEventListeners() {

    let addAuthorButton = document.querySelector('.addAuthorButton');
    if (addAuthorButton != null)
        addAuthorButton.addEventListener('click', sendAuthorAddRequest);

    window.onbeforeunload = function () {
        if (warn_on_unload != "") {
            return warn_on_unload;
        }
    }
}


function sendAuthorAddRequest() {

    let inputBox = document.querySelector('input[name=author]');
    let username = inputBox.value;
    inputBox.value = "";

    sendAjaxRequest('post', '/api/user/search/' + username, null, authorAddHandler);

}

function authorAddHandler() {
    let inputBox = document.querySelector('input[name=author]');

    //if (this.status != 200) window.location = '/';
    let user = JSON.parse(this.responseText);

    console.log(user);

    switch (user['user']) {
        case 'dontExist': {
            inputBox.style.borderColor = "red";
            inputBox.placeholder = "Couldn't find that user.";
            break;
        }
        case 'owner': {
            inputBox.style.borderColor = "red";
            inputBox.placeholder = "You can't add yourself as an author twice.";
            break;
        }
        default: {
            inputBox.placeholder = "Author";
            inputBox.style.borderColor = null;

            if (authors.includes(user['user']['id'])) {
                inputBox.style.borderColor = "red";
                inputBox.placeholder = "Author already added.";
                return;
            }

            let ul = document.querySelector('#authorsList');

            let li = document.createElement("li");
            li.setAttribute("class", "list-group-item d-flex justify-content-between align-items-center");
            li.innerHTML = user['user']['username'];
            let close = document.createElement("span");
            close.innerHTML = `<button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>`;
            li.setAttribute("id", user['user']['id']);
            li.appendChild(close);

            close.addEventListener('click', removeAuthorFromList)

            ul.appendChild(li);


            authors.push(user['user']['id']);
            let button = document.querySelector('.publish');

            if (authors.length != 0)
                button.disabled = true;
            else
                button.disabled = false;
        }
    }
}

function removeAuthorFromList() {
    let liAuthor = this.closest('li');
    let authorId = liAuthor.id;

    console.log(authorId);
    console.log(authors);

    let index = authors.indexOf(authorId);
    console.log("index - " + index);
    authors.splice(index, 1);

    liAuthor.parentNode.removeChild(liAuthor);
    let button = document.querySelector('.publish');

    if (authors.length != 0)
        button.disabled = true;
    else
        button.disabled = false;
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

if (ready.checked) {
    sendAjaxRequest('post', '/api/post/create', { title: title, text: text, tags: tags, description: description, published: 1 }, postCreatedHandler);
}
else {
    let divWarn = document.createElement("div");
    divWarn.innerHTML = `<div class="alert alert-danger my-2" role="alert">
   You must set <b>ready to publish</b> before publishing.
 </div>`;
    card.appendChild(divWarn);
}
