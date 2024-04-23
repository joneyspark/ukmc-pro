@extends('authpanel')
@section('auth')
<div class="row">
    <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
        <div class="card mt-3 mb-3">
            <div class="card-body">

                <div class="row">
                    <form id="login-form" method="POST" action="{{ URL::to('student-register-post') }}">
                        @csrf
                    <div class="col-md-12 mb-3">
                        <h2>Sign Up</h2>
                        <p>Enter your Name email and password to Register</p>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input value="{{ (!empty(Session::get('name')))?Session::get('name'):old('name') }}" id="name" name="name" type="text" class="form-control">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input value="{{ old('email') }}" id="email" name="email" type="email" class="form-control">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input value="{{ old('phone') }}" id="phone" name="phone" type="text" class="form-control">
                            @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input value="" name="password" id="password" type="password" class="form-control">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">Confirm Password</label>
                            <input name="password_confirmation" type="password" class="form-control">
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
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
                            <p class="mb-0">You have any account ? <a href="{{ URL::to('student-login') }}" class="text-warning">Login Here</a></p>
                        </div>
                    </div>
                  </form>
                </div>

            </div>
        </div>
    </div>

</div>

@stop

