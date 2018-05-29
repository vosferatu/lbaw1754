function addEventListeners() {
   
    let tags = [];

  let tagsAnchor = document.querySelectorAll('#sidebar .list-group a');


  tagsAnchor.forEach(function(tag){
    tag.setAttribute("href",'#');
  });
  

  [].forEach.call(tagsAnchor, function (tagAction) {
    tagAction.addEventListener('click', function() {return selectTag(tags)});
  });

  let postCreator = document.querySelector('.publish');
  if (postCreator != null)
   postCreator.addEventListener('click', function() {return sendCreatePostRequest(tags)});

   let postDraft = document.querySelector('.save');
   if (postDraft != null)
    postDraft.addEventListener('click', function() {return sendDraftPostRequest(tags)});
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
    let form = document.querySelector('.card-body');

    let title = document.querySelector('input[type=text]').value;
    let text = CKEDITOR.instances["editor"].getData();

    sendAjaxRequest('post', '/api/post/create', { title: title, text: text, tags: tags, published: 1 }, postCreatedHandler);
}

function sendCreateDraftRequest(tags){
    let form = document.querySelector('.card-body');

    let title = document.querySelector('input[type=text]').value;
    let text = CKEDITOR.instances["editor"].getData();

    sendAjaxRequest('post', '/api/post/create', { title: title, text: text, tags: tags, published: 0 }, postCreatedHandler);
}

function postCreatedHandler(){

}


addEventListeners();
