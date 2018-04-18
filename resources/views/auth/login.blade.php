@extends('auth.master')

@push('styles')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="container">
      <div class="row justify-content-md-center align-items-center">
          <div class="card-wrapper">
              <div class="brand">
                  <img src={{ url('/img/logo.svg')}}>
              </div>

              <div class="card-group">
                  <div class="card fat logincard">
                      <div class="card-body">
                          <h4 class="card-title">Login</h4>

                          <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                              <label class="sr-only" for="inlineFormInputGroup">Username</label>
                              <div class="input-group mb-2">
                                  <div class="input-group-prepend">
                                      <div class="input-group-text">@</div>
                                  </div>
                                  <input type="text" class="form-control" id="inlineFormInputGroup" name="username" value="{{ old('email') }}"
                                         placeholder="Username"  required autofocus>
                                         @if ($errors->has('username'))
                                             <span class="error">
                                               {{ $errors->first('username') }}
                                             </span>
                                         @endif
                              </div>

                              <div>
                                  <input id="password" type="password" class="form-control" name="password"
                                         placeholder="Password"
                                         required data-eye>
                                         @if ($errors->has('password'))
                                             <span class="error">
                                                 {{ $errors->first('password') }}
                                             </span>
                                         @endif
                                  <div class= "afterpassword">
                                  <a href="forgot.html" class="float-right">
                                      Forgot Password?
                                  </a>

                                  <label class="float-left no-margin">
                                      <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input" id="customCheck1"  name="remember" {{ old('remember') ? 'checked' : '' }}>
                                          <label class="custom-control-label" for="customCheck1">Remember me</label>
                                      </div>

                                  </label>
                              </div>
                      </div>


                      <div class="form-group no-margin">
                          <button type="submit" id="login-btn" class="btn btn-primary btn-block">
                              Sign in
                          </button>
                      </div>
                      <div class="margin-top20 text-center">
                          Don't have an account? <a href= {{url('/register')}}>Register now.</a>
                      </div>
                      <div class="title-line">
                          or
                      </div>
                      <a href="#" class="btn-lg btn-block btn-social btn-google">
                          <span class="fa fa-google"></span> Sign in with Google

                      </a>

                      </form>
                  </div>
              </div>
              <!-- card one end -->

              <!-- card two -->
              <div class="card fat imgcard hidden-md-down">
                  <img class="" src={{ url('/img/login.svg')}} alt="Card image">
              </div>
              <!-- card two -->


          </div>

        @include('layouts.footer')

      </div>
  </div>
  </div>
  </div>
  </div>
  </div>

@endsection
