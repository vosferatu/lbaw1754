<div class="card m-2" data-id="{{ $comment->id }}">
    <div class="card-body">
        <div class="row align-items-center ">
            <div class="col-sm-1 text-nowrap text-center px-0">
                <ul class="list-group voting">
                    <li class="list-group-item borderless"><a href=""><img class="upvote" src={{ url( 'img/upvote.svg') }}></a></li>
                    <li class="list-group-item borderless votesCount">{{ $comment->content->votes}}</li>
                    <li class="list-group-item borderless"><a href=""> <img class="downvote" src={{ url( 'img/upvote.svg') }}></a></li>
                </ul>
            </div>


            <div class="col-sm-9 pt-2 pl-1">
                {{ $comment->content->text}}

                <ul class="list-inline my-0 py-0 mt-3">

                    <li class="list-inline-item">
                        <p>
                            <i class="far fa-clock"></i> {{ $comment->content->created->diffForHumans() }}</p>
                    </li>

                    <li class="list-inline-item">
                        <p>
                            <i class="far fa-user-circle"></i> By {{ $comment->user->username }}</p>
                    </li>

                    <li class="list-inline-item float-right mx-auto report"><p><a href="#"><i class="fas fa-flag"></i></p></li></a>
                    @include('layouts.report-modal')
                    <li class="list-inline-item float-right mr-3 save"><p><a href="#"><i class="fas fa-star"></i></p></li></a>

                </ul>

            </div>

        </div>
    </div>
</div>