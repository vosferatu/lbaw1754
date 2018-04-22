
@extends('auth.master')

@push('styles')
    <link href="{{ asset('css/missing.css') }}" rel="stylesheet">
@endpush

@section('content')
<section class="h-100">
  <div class="container h-100">
    <div class="row justify-content-md-center align-items-center h-100">

      	<div class="card-wrapper">
            <div class="brand">
              <a href={{ url('/') }}><img src={{ url('/img/logo.svg')}}></a>
            </div>

      <div class="card-wrapper">
        <div class="card fat text-center">
          <div class="card-body">
            <img class="card-img-top" src={{ url('/img/404.svg') }} alt="404">
            <p class="card-text margin-top20"> Sorry, the page you are looking for could not be found.</p>
                    </div>
        </div>
        @include('layouts.footer')

      </div>
    </div>
  </div>
</section>


@endsection
