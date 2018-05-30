<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
    </script>

<div id="errors" class="mb-3"></div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title" id="createPostTitle">New Post</h5>
    </div>
    <div class="card-body">
            <div class="form-group" >
                <input name="title" data-toggle="tooltip" title="Use buzzwords to highlight the content of your post." type="text"  class="form-control form-control-lg" id="titleInput" placeholder="Title">
            </div>

            <div class="form-group" data-toggle="tooltip" title="You can format the text as you like with the helper functions.">
                <textarea name="editor" id="editor" rows="10" cols="80" placeholder="Article"></textarea>
            </div>

            <div class="form-group" data-toggle="tooltip" title="The description will be shown on the partial post in the homepage." >
                <input  name="description" type="text" class="form-control form-control-lg" id="description" placeholder="Description">
            </div>

            <div class="form-group tagSection">
            </div>
    </div>
    <div class="card-footer text-right">
        <button type="button" class="btn btn-success saveDraft">Save</button>
        <input type="button" class="btn btn-primary publish" value="Publish">
    </div>
</div>



<script type="text/javascript" src={{ asset( 'js/new-post.js') }} defer>




