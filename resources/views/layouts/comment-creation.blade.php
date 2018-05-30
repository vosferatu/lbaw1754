
            <form class="mt-3" method="post" action="/post/{{  $post->slug }}/comments">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="text" rows="4" class="form-control" placeholder="Your comment here."></textarea>
                </div>

                <div class="form-group float-right">
                    <button type="submit" class="btn btn-primary"> Add Comment </button>
                </div>
            </form>
