<div class="card">
        <div class="card-block">
            <form method="post" action="/post/{{  $post->slug }}/comments">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="text" class="form-control" placeholder="Your comment here."></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary"> Add Comment </button>
                </div>
            </form>
        </div>
    </div>