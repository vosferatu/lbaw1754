@extends('layouts.master')

@push('styles')
    <link href="{{ asset('css/feed.css') }}" rel="stylesheet">
@endpush

@section('title', 'Trending' )

@section('content')


<div class="container-fluid">
      <div class="row">

          @include('layouts.sidebar')

          <!-- Posts here -->
          <div class="col-sm posts">
              <h4 class="title"> Hottest news right now  <i class="fas fa-bolt"></i> </a></li></h4>
              
              @if(session()->has('message-type'))
              <div class="alert alert-{{ session('message-type') }}"> 
              {!! session('message') !!}
              </div>
            @endif

            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
              @foreach($posts as $post)
              <div class="row">
                <div class="col-12 col-sm-12 mx-3 my-2">
                    @include('layouts.partial-post')
                </div>
            </div>
              @endforeach
          </div>
      </div>
  </div>

@endsection
