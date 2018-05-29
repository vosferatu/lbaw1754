@extends('layouts.master') 

@if($type == "show")
@section('title', $post->title )
@elseif ($type == "create")
@section('title', 'Create New Post' )
@endif

@push('styles')
<link href="{{ asset('css/feed.css') }}" rel="stylesheet"> @endpush @section('content')

<div class="container-fluid">
    <div class="row">

        @include('layouts.sidebar')
        
        <div class="col-sm posts">
         @if($type == "show")
             @include('layouts.full-post')
             <h1 class="mt-3">Discussion</h1>
             <hr> 
        
            @foreach($post->comments as $comment)
            <div class="row">
            <div class="col-10"> 
             @include('layouts.comment') 
              </div>
          </div>
        @endforeach 
        
        @if (Auth::check())
        @include('layouts.comment-creation')
        @endif

        @elseif ($type == "create")
        @include('layouts.create-post')
        @endif
        </div>

        
    </div>
</div>
</div>

@endsection