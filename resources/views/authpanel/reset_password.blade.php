@extends('authpanel')
@section('auth')
<div class="row">
    
    <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
        <div class="card mt-3 mb-3">
            <div class="card-body">

                <div class="row">
                    <form id="login-form" method="POST" action="{{ URL::to('reset-password-post') }}">
                        @csrf
                    <div class="col-md-12 mb-3">
                        
                        <h2>Password Reset</h2>
                        <p>Enter your email to recover your ID</p>
                        
                    </div>
                    <div class="col-md-12">
                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control">
                            @if ($errors->has('email'))
                               <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <button class="btn btn-secondary w-100">RECOVER</button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="text-center">
                            <p class="mb-0">Go To Login ? <a href="{{ URL::to('login') }}" class="text-warning">Click Here</a></p>
                        </div>
                    </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    
</div>
@stop