<div class="card" data-id="{{ $post->id }}">
            <div class="card-body">
                <div class="row align-items-center my-auto">
                    <div class="col-sm-1 text-nowrap text-center px-0">
                      <ul class="list-group voting">
                          <li class="list-group-item borderless"><a href="#"><img class="upvote" src={{ url('img/upvote.svg') }}></a></li>
                          <li class="list-group-item borderless votesCount">{{  $post->content->votes}}</li>
                          <li class="list-group-item borderless"><a href="#"><img class="downvote" src={{ url('img/upvote.svg') }}></a></li>
                      </ul>
                    </div>
                    <div class="col-sm-2  pl-1">
                        <a href="">
                            <img class="img-fluid rounded" src={{ url('img/waves.jpg') }}>
                        </a>
                    </div>

                    <div class="col-sm-9 pt-2 pl-1">
                        <h2 class="d-inline"><a href="/post/{{ $post->slug }}">{{ $post->title }}</a></h2>
                        <span class="badge badge-pill badge-warning">Photography</span> <span class="badge badge-pill badge-warning">Technology</span>

                        <p>{{ $post->content->text }}</p>

                        <ul class="list-inline my-0 py-0">

                            <li class="list-inline-item">
                                <p><i class="far fa-comments"></i> {{  $post->comments_count }} Comments</p>
                            </li>

                            <li class="list-inline-item">
                                <p><i class="far fa-clock"></i> {{  $post->published_date }}</p>
                            </li>

                            <li class="list-inline-item">
                                <p><i class="far fa-user-circle"></i> By Kevin</p>
                            </li>

                            <li class="list-inline-item float-right mx-auto report"><p><a href="#"><i class="fas fa-flag"></i></p></li></a>
                            @include('layouts.report-modal')
                            <li class="list-inline-item float-right mr-3 save"><p><a href="#"><i class="fas fa-star"></i></p></li></a>

                        </ul>

                    </div>


                </div>
            </div>
        </div>
