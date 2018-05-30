<div id="errors" class="mb-3"></div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title" id="createPostTitle">New Post</h5>
    </div>
    <div class="card-body">
            <div class="form-group">
                <input name="title" type="text" class="form-control form-control-lg" id="title" placeholder="Title">
            </div>

            <div class="form-group">
                <textarea name="editor" id="editor" rows="10" cols="80" placeholder="Article"></textarea>
            </div>

            <div class="form-group tagSection">
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="readyCheck">
                <label class="custom-control-label" required for="readyCheck">Ready to publish?</label>
            </div>
    </div>
    <div class="card-footer text-right">
        <button type="button" class="btn btn-success saveDraft">Save</button>
        <input type="button" class="btn btn-primary publish" value="Publish">
    </div>
</div>


<div class="card mt-2">
    <div class="card-header">
        <h5 class="card-title" id="createPostAuthorsTitle">Authors</h5>
    </div>
    <div  class="card-body">
            <ul id="authorsList" class="list-group ">
                
                <li id="own" class="list-group-item d-flex justify-content-between align-items-center">{{ Auth::user()->username }}</li>
             </ul>
                
    </div>
    <div class="card-footer">

         <input name="author" type="text" class="form-control form-control-lg" id="author" placeholder="Author">
        <button type="button" class="btn btn-outline-dark mr-auto addAuthorButton">
            <i class="fas fa-user-plus"></i> Add Author</button>
    </div>
</div>
