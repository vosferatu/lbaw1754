
<div class="card">
    <div class="card-header">
        <h5 class="card-title" id="createPostTitle">New Post</h5>
        </button>
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
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-outline-dark mr-auto">
            <i class="fas fa-user-plus"></i> Add Author</button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-success">Save</button>
        <input type="button" class="btn btn-outline-primary publish" value="Publish">
    </div>
</div>

<script type="text/javascript" src={{ asset( 'js/new-post.js') }} defer>


