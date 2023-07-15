@extends('adminpanel')
@section('admin')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="tab-content" id="animateLineContent-4">
                <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel"
                    aria-labelledby="animated-underline-home-tab">
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="Analytics">
                            <header class="header navbar navbar-expand-sm">
                                <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                        <line x1="3" y1="12" x2="21" y2="12"></line>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                        <line x1="3" y1="18" x2="21" y2="18"></line>
                                    </svg>
                                </a>
                                <div class="d-flex breadcrumb-content">
                                    <div class="page-header">
                                        <div class="page-title">
                                        </div>
                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Application</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                                            </ol>
                                        </nav>

                                    </div>
                                </div>
                            </header>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form method="post" action="{{ URL::to('my-profile-update') }}" enctype="multipart/form-data" class="section general-info">
                                @csrf
                                <div class="info">
                                    <h5 class="py-3 text-center">Profile Information</h5>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="fullName">Profile photo</label>
                                                <input class="form-control" type="file"
                                                    class="filepond" name="photo"
                                                    accept="image/png, image/jpeg, image/gif" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="fullName">Full Name</label>
                                                <input name="name" type="text" class="form-control mb-3"
                                                    id="fullName" placeholder="Full Name"
                                                    value="{{ Auth::user()->name }}">
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <label for="profession">User Role</label>
                                                <input disabled type="text" class="form-control mb-3"
                                                    id="profession" placeholder="Designer"
                                                    value="{{ Auth::user()->role == 'admin' ? 'Super Admin' : (Auth::user()->role == 'adminManager' ? 'Admission Officer' : (Auth::user()->role == 'agent' ? 'Agent' : (Auth::user()->role == 'student' ? 'Student' : 'Regular User'))) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <select class="form-select mb-3" name="country" id="country">
                                                    <option value="">All Countries</option>
                                                    @foreach ($countries as $country)
                                                    <option value="{{ $country }}">{{ $country }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="address">State</label>
                                                <input type="text" class="form-control mb-3"
                                                    id="address" name="state" placeholder="State"
                                                    value="{{ Auth::user()->state }}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="location">City</label>
                                                <input type="text" name="city" class="form-control mb-3"
                                                    id="location" value="{{ Auth::user()->city }}" placeholder="City">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text" name="phone" class="form-control mb-3"
                                                    id="phone"
                                                    placeholder="Write your phone number here"
                                                    value="{{ Auth::user()->phone }}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input disabled type="text" class="form-control mb-3"
                                                    id="email"
                                                    placeholder="Write your email here"
                                                    value="{{ Auth::user()->email }}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control mb-3"
                                                    id="address" name="address" placeholder="Address"
                                                    value="{{ Auth::user()->address }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-1">
                                        <div class="form-group text-start">
                                            <button class="btn btn-secondary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form method="post" action="{{ URL::to('my-password-change') }}" enctype="multipart/form-data" class="section general-info">
                                @csrf
                                <div class="info">
                                    <h5 class="py-3 text-center">Change Password Section</h5>
                                    <div class="row mb-3">

                                        <div class="col">
                                            <div class="form-group">
                                                <label for="fullName">New Password</label>
                                                <input name="password" type="password" class="form-control">
                                                @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="fullName">Confirm New Password</label>
                                                <input name="password_confirmation" type="password" class="form-control">
                                                @if ($errors->has('password_confirmation'))
                                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <div class="form-group text-start">
                                            <button class="btn btn-warning">Change Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@stop
