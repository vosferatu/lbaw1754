@extends('layouts.master')

@push('styles')
    <link href="{{ asset('css/feed.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="container-fluid">
      <div class="row">

          @include('layouts.sidebar')

          <!-- Posts here -->
          <div class="col-sm posts">
              <h4 class="title"> Hottest news right now  <i class="fas fa-bolt"></i> </a></li></h4>

              <!-- single post -->
              <div class="row">
                  <div class="col-12 col-sm-12 mx-3 my-2">
                      <a href="post.html">
                      <div class="card">
                          <div class="card-body">
                              <div class="row align-items-center my-auto">
                                  <div class="col-sm-1 text-nowrap text-center px-0">
                                      <ul class="list-group">
                                          <li class="list-group-item borderless"><a href=""><img class="upvote" src={{ url('img/upvote.svg') }}></a></li>
                                          <li class="list-group-item borderless">112</li>
                                          <li class="list-group-item borderless"><a href=""><img class="upvote rotate" src={{ url('img/upvote.svg') }}></a></li>
                                      </ul>
                                  </div>
                                  <div class="col-sm-2  pl-1">
                                      <a href="">
                                          <img class="img-fluid rounded" src={{ url('img/waves.jpg') }}>
                                      </a>
                                  </div>

                                  <div class="col-sm-9 pt-2 pl-1">
                                      <h2 class="d-inline"><a href="post.html">ADSactly Fun - Oh Brother</a></h2>
                                      <span class="badge badge-pill badge-warning">Photography</span> <span class="badge badge-pill badge-warning">Technology</span>

                                      <p>Even if Even if Steem Dollar (SBD) gets pegged or locked up or lassoed to $1 mark; unbridled demand will not allow it to be confined in valuation. </p>

                                      <ul class="list-inline my-0 py-0">

                                          <li class="list-inline-item">
                                              <p><i class="far fa-comments"></i> 44 Comments</p>
                                          </li>

                                          <li class="list-inline-item">
                                              <p><i class="far fa-clock"></i> 1h20min ago</p>
                                          </li>

                                          <li class="list-inline-item">
                                              <p><i class="far fa-user-circle"></i> By Kevin</p>
                                          </li>

                                          <li class="list-inline-item float-right mx-auto">
                                              <p><i class="fas fa-flag" ></i></p>
                                          </li>
                                          <li class="list-inline-item float-right mr-3">
                                              <p><i class="fas fa-star"></i></p>
                                          </li>

                                      </ul>

                                  </div>


                              </div>
                          </div>
                      </div>
                    </a>
                </div>
              </div>
              <!-- end of single post-- -->
          </div>
      </div>
  </div>

@endsection
