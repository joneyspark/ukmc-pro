@extends('authpanel')
@section('auth')
<div class="row">
    <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
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
                    </div>
                  </form>
                </div>

            </div>
        </div>
    </div>

</div>

@stop

