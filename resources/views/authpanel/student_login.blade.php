@extends('authpanel')
@section('auth')
<style>
    body{
        background-color: white!important;
    }
</style>
<div class="container">
    <div class="row text-center">
        <div class="text-center">
            <img src="{{ asset('img/logo_ukmc.svg') }}" class="img-fluid py-3" alt="..." style="width: 150px;">
        </div>
        <h3><b style="color: #0F1C89">Welcome to MyMac Student Portal</b></h3>
    </div>
    <div class="row px-md-5">
        <div class="col-md-6 px-md-5 pb-md-5">
            <img src="{{ asset('img/student_login.svg') }}" class="img-fluid p-md-5" alt="...">
        </div>
        <div class="col-md-6 px-md-5 pb-md-5 d-md-flex align-items-center justify-content-center">
            <div class="row">
                <form id="login-form" method="POST" action="{{ URL::to('user-login-post') }}">
                    @csrf
                <div class="col-md-12 mb-3">

                    <h2 class="text-center text-md-start"><b style="color: #0F1C89">Sign In</b></h2>
                    <p>Enter your email and password to login</p>
                    <p>Don’t have an account? <span class="fw-bold"><b><a class="text-danger" href="{{ URL::to('student-register') }}">Sign up</a></b></span></p>

                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input value="{{ (!empty(Session::get('user_email')))?Session::get('user_email'):old('email') }}" id="email" name="email" type="email" class="form-control">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input value="{{ (!empty(Session::get('user_password')))?Session::get('user_password'):old('password') }}" name="password" id="password" type="password" class="form-control">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-between">
                    <div class="mb-3">
                        <div class="form-check form-check-primary form-check-inline">
                            <input name="remember_me" value="remember_me" class="form-check-input me-3" type="checkbox" id="remember-me" {{ (!empty(Session::get('rememberMe')) && Session::get('rememberMe')=='remember_me')?'checked':'' }}>
                            <label class="form-check-label" for="form-check-default">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="{{ URL::to('student-register') }}" class="text-warning">Forgot Password</a>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-4">
                        <button id="submit-btn" class="btn btn-secondary w-100" style="background-color: #0F1C89">SIGN IN</button>
                    </div>
                </div>
                </div>
              </form>
            </div>
        </div>
        {{-- <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
            <div class="card mt-3 mb-3">
                <div class="card-body">
    
                    <div class="row">
                        <form id="login-form" method="POST" action="{{ URL::to('user-login-post') }}">
                            @csrf
                        <div class="col-md-12 mb-3">
    
                            <h2>Sign In</h2>
                            <p>Enter your email and password to login</p>
    
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input value="{{ (!empty(Session::get('user_email')))?Session::get('user_email'):old('email') }}" id="email" name="email" type="email" class="form-control">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input value="{{ (!empty(Session::get('user_password')))?Session::get('user_password'):old('password') }}" name="password" id="password" type="password" class="form-control">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <div class="form-check form-check-primary form-check-inline">
                                    <input name="remember_me" value="remember_me" class="form-check-input me-3" type="checkbox" id="remember-me" {{ (!empty(Session::get('rememberMe')) && Session::get('rememberMe')=='remember_me')?'checked':'' }}>
                                    <label class="form-check-label" for="form-check-default">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-12">
                            <div class="mb-4">
                                <button id="submit-btn" class="btn btn-secondary w-100">SIGN IN</button>
                            </div>
                        </div>
    
                        <div class="col-12 mb-4">
                            <div class="">
                                <div class="seperator">
                                    <hr>
                                    <div class="seperator-text"> <span>Or</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-center">
                                <p class="mb-0">Forgot Password ? <a href="{{ URL::to('reset-password') }}" class="text-warning">Click Here</a></p>
                            </div>
                            <div class="text-center">
                                <p class="mb-0">Don,t You have any account ? <a href="{{ URL::to('student-register') }}" class="text-warning">Click Here</a></p>
                            </div>
                        </div>
                      </form>
                    </div>
    
                </div>
            </div>
        </div> --}}
    
    </div>
</div>

@stop

