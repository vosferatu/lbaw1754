
@extends('layouts.master')

@push('styles')
    <link href="{{ asset('css/feed.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="profile">

        <div class="profile-info">
    
        <div class="container mt-3">
            <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-2 col-4 mx-auto text-nowrap text-center px-2">
                                    <a href="">
                                        <img class="d-block mx-auto img-fluid" src={{ URL::to('uploads/profilePictures/' . $user->photo)}}>
                                    </a>
                                </div>
                                <div class="col-lg-7 col-6 text-center text-lg-left">
                                    <h2 class="d-inline">{{ $user->name }}</h2> <span class="flag-icon flag-icon-br  "></span>
                                    <h6>&commat;{{ $user->username }} <i class="fas fa-check-circle"></i></h6>
                                    @if($user->introduction == NULL)
                                    <h2> Empty introduction. </h2>
                                    @else
                                    <h2>{{$user->introduction}}</h2>
                                    @endif    
                                </div>
                                <div class="col-lg-2 col-2 mx-auto">
                                    <div class="row no-gutters text-center justify-content-end align-items-end">
                                        <div class="col">
                                            <h2>123</h2>
                                            <span class="badge badge-pill badge-dark font-weight-normal">posts</span>
                                        </div>
                                        <div class="col">
                                            <h2>{{$user->followers}}</h2>
                                            <span class="badge badge-pill badge-dark font-weight-normal">followers</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </div>

        @yield('profile')
    
        
 </div>
    
    
@endsection
