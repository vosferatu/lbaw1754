@extends('layouts.master')

@push('styles')
    <link href="{{ asset('css/feed.css') }}" rel="stylesheet">
@endpush

@section('content')
   <div class="modal-content">
       <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLongTitle">New Post</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
           </button>
       </div>
       <div class="modal-body">
           <form method="POST" action="{{ route('post.create') }}">

               {{ csrf_field() }}

               <div class="form-group">
                   <input name="title" type="text" class="form-control form-control-lg" id="title" placeholder="Title">
               </div>

               <div class="form-group">
               <textarea name="article" id="editor" rows="10" cols="80" placeholder="Article"></textarea>
               </div>

               <div class="form-group">
                   <input name="tags" type="text" class="form-control form-control-lg" id="tags" placeholder="Add Tags"> <span class="badge badge-pill badge-success">Photography</span> <span class="badge badge-pill badge-success">Technology</span>

               </div>
             </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-outline-dark mr-auto"><i class="fas fa-user-plus"></i> Add Author</button>
               <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-outline-success">Save</button>
               <input type="submit" class="btn btn-outline-primary" value="Publish">
             </div>
           </form>
   </div>

@endsection
