
@extends('layouts.master') 

@section('title', $post->title )

@push('styles')
<link href="{{ asset('css/app.css') }}" rel="stylesheet"> @endpush @section('content')

<div class="container-fluid">
    <div class="row">

        @include('layouts.sidebar')
        
        <div class="col-sm posts">
        @include('layouts.full-post')
        </div>

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

    </div>
</div>
</div>

@endsection