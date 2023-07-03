@extends('adminpanel')
@section('admin')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="secondary-nav">
                <div class="breadcrumbs-container" data-page-heading="Analytics">
                    <header class="header navbar navbar-expand-sm">
                        <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-menu">
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
                                        <li class="breadcrumb-item"><a href="#">Users</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create Admission Officer</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <form method="post" action="{{ URL::to('create-admission-manager-by-manager-post') }}" enctype="multipart/form-data">
                @csrf
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-4">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h4>Admission Officer Information</h4>
                                        <a href="{{ URL::to('my-team-list') }}" class="btn btn-info btn-rounded mb-2 mr-4 inline-flex items-center"> My Team
                                            List <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-eye">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3">
                                                </circle>
                                            </svg></a>
                                    </div><br>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Officer
                                            Name</label>
                                            <input name="officer_name" value="{{ old('officer_name') }}" type="text" class="form-control">
                                            @if ($errors->has('officer_name'))
                                                <span class="text-danger">{{ $errors->first('officer_name') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Officer
                                            Phone</label>
                                            <input name="officer_phone" value="{{ old('officer_phone') }}" type="text" class="form-control">
                                            @if ($errors->has('officer_phone'))
                                                <span class="text-danger">{{ $errors->first('officer_phone') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Officer
                                            Email</label>
                                            <input name="officer_email" value="{{ old('officer_email') }}" type="email" class="form-control">
                                            @if ($errors->has('officer_email'))
                                                <span class="text-danger">{{ $errors->first('officer_email') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Alternative Person
                                            Contact</label>
                                            <input name="officer_alternative_contact" value="{{ old('officer_alternative_contact') }}" type="text" class="form-control">
                                            @if ($errors->has('officer_alternative_contact'))
                                                <span class="text-danger">{{ $errors->first('officer_alternative_contact') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">National ID or
                                            Passport</label>
                                            <input name="officer_nid_or_passport" value="{{ old('officer_nid_or_passport') }}" type="text" class="form-control">
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Nationality</label>
                                            <input name="nationality" value="{{ old('nationality') }}" type="text" class="form-control">
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Country</label>
                                            <select name="country" class="form-control">
                                            <option value="">Select Country</option>
                                            @forelse ($countries as $country)
                                            <option value="{{ $country }}">{{ $country }}</option>
                                            @empty

                                            @endforelse
                                        </select>
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">State</label>
                                        <input name="state" value="{{ old('state') }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">City</label>
                                        <input name="city" value="{{ old('city') }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-4">
                                <div class="col col-md-8">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Address in
                                            Details</label>
                                        <textarea name="address" id="exampleFormControlTextarea1" class="form-control" rows="1" spellcheck="false">{{ old('address') }}</textarea>
                                        
                                        <!---->
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div class="row d-flex align-items-center">
                                        <div class="col col-md-8">
                                            <div class="form-group mb-4"><label>Upload Officer Photo</label><label
                                                    class="custom-file-container__custom-file">
                                                    <input type="file" name="photo" class="form-control-file" accept="image/*">
                                                    @if ($errors->has('photo'))
                                                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                                                    @endif
                                                    </label>
                                                <div class="custom-file-container__image-preview">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-md-4">
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-4">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Admission Officer Login Information</h4><br>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="personName">Person Name</label>
                                        <input name="name" value="{{ old('name') }}" id="personName" type="text" class="form-control">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="email">Email</label>
                                        <input name="email" value="{{ old('email') }}" type="email" class="form-control">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="password">Password</label>
                                        <input name="password" type="password" class="form-control">
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="password">Confirm Password</label>
                                        <input name="password_confirmation" type="password" class="form-control">
                                        @if ($errors->has('password_confirmation'))
                                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-right">
                                    <div class="row">
                                        <div class="col"><button type="button"
                                                class="btn btn-warning mr-2 me-2">Cancel</button><button type="submit"
                                                class="btn btn-primary mr-2"><span>Submit</span></button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
