
@extends('layouts.master')

@section('title', "About" )

@push('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
        <h1 class="mt-3">About</h1>
        <hr>
        <section class="py-3">
            <div class="row">
                <div class="col-md-6">
                    <h2>About Ditto</h2>
                    <p>Nowadays there are few applications where censorship is absent and users can share their
                        thoughts/ideas, their work, and their interests freely.</p>
                    <p>Currently available websites don’t allow the users to manage the content displayed nor the
                        advertisements.</p>
                    <p>Our goal is to build a platform where users can post their news and get recognition by rewarding
                        them with site exposure. The idea is that we intend to give users freedom in posting/deleting,
                        commenting, upvoting/downvoting and tagging posts.</p>
                </div>
                <div class="col-md-6 aboutimg">
                    <img class="img-fluid aboutimg" src={{ url('/img/logo.svg')}} alt="Logo">
                </div>
            </div>
        </section>

        <section class="pb-3">
            <h2 class="my-4">Our Team</h2>
            <hr>

            <div class="card-group">
                <div class="card">
                    <img class="card-img-top" src={{ url('/img/almeida.jpg')}} alt="Almeida">
                    <div class="card-body">
                        <h5 class="card-title">João Almeida <a href=""> <i class="fas fa-user"></i> </a></h5>
                        <p class="card-text"></p>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src={{ url('/img/lago.jpg')}} alt="Lago">
                    <div class="card-body">
                        <h5 class="card-title">João Lago <a href=""> <i class="fas fa-user"></i> </a></h5>
                        <p class="card-text"></p>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src={{ url('/img/mendes.jpg')}} alt="Mendes">
                    <div class="card-body">
                        <h5 class="card-title">João Mendes <a href=""> <i class="fas fa-user"></i> </a></h5>
                        <p class="card-text"></p>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src={{ url('/img/andrade.jpg')}} alt="Andrade">
                    <div class="card-body">
                        <h5 class="card-title">Miguel Andrade <a href=""> <i class="fas fa-user"></i> </a></h5>
                        <p class="card-text"></p>
                    </div>
                </div>

            </div>

        </section>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About</li>
            </ol>
        </nav>

    </div>

    @include('layouts.footer')

@endsection
