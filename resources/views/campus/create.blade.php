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
                                        <li class="breadcrumb-item"><a href="#">Application</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <form method="post" action="{{ URL::to('store-campus-data') }}" enctype="multipart/form-data">
                @csrf
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-2">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h5>Add Campus Information</h5>
                                        <a href="/institute" class=""><button
                                                class="btn btn-info btn-rounded mb-2 mr-4 inline-flex items-center"> View
                                                Campus <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                    height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-eye">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg></button></a>
                                    </div><br>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Country*</label>
                                        <select name="country" class="form-control">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country'))
                                            <span class="text-danger">{{ $errors->first('country') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2">
                                        <label for="exampleFormControlInput1">Campus Name*</label>
                                        <input value="{{ old('campus_name') }}" type="text" class="form-control" name="campus_name">
                                        @if ($errors->has('campus_name'))
                                            <span class="text-danger">{{ $errors->first('campus_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Website</label><input
                                            type="text" class="form-control" value="{{ old('website') }}" name="website">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Monthly Living Cost*</label>
                                        <input type="text" class="form-control" value="{{ old('monthly_living_cost') }}" name="monthly_living_cost">
                                        @if ($errors->has('monthly_living_cost'))
                                            <span class="text-danger">{{ $errors->first('monthly_living_cost') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Funds Requirements
                                            for Visa*</label><input type="text" class="form-control"
                                            name="funds_requirements_for_visa" value="{{ old('funds_requirements_for_visa') }}">
                                        @if ($errors->has('funds_requirements_for_visa'))
                                            <span class="text-danger">{{ $errors->first('funds_requirements_for_visa') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Application Fees*</label>
                                        <input type="text" class="form-control" name="application_fee" value="{{ old('application_fee') }}">
                                        @if ($errors->has('application_fee'))
                                            <span class="text-danger">{{ $errors->first('application_fee') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2"><label
                                            for="exampleFormControlInput1">Currency*</label><input type="text"
                                            class="form-control" name="currency" value="{{ old('currency') }}">
                                        @if ($errors->has('currency'))
                                            <span class="text-danger">{{ $errors->first('currency') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Is Language
                                            Mandatory*</label><input type="text" class="form-control"
                                            placeholder="Yes or No" name="is_lang_mendatory" value="{{ old('is_lang_mendatory') }}">
                                        @if ($errors->has('is_lang_mendatory'))
                                            <span class="text-danger">{{ $errors->first('is_lang_mendatory') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlTextarea1">Language
                                            Requirements*</label>
                                        <textarea id="exampleFormControlTextarea1" class="form-control" rows="3" spellcheck="false"
                                            name="lang_requirements">{{ old('lang_requirements') }}</textarea>
                                        @if ($errors->has('lang_requirements'))
                                            <span class="text-danger">{{ $errors->first('lang_requirements') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlTextarea1">Campus
                                            Benifits*</label>
                                        <textarea id="exampleFormControlTextarea1" class="form-control" rows="3" spellcheck="false"
                                            name="institute_benifits">{{ old('institute_benifits') }}</textarea>
                                        @if ($errors->has('institute_benifits'))
                                            <span class="text-danger">{{ $errors->first('institute_benifits') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlTextarea1"> Part Time Work
                                            Details*</label>
                                        <textarea id="exampleFormControlTextarea1" class="form-control" rows="3" spellcheck="false"
                                            name="per_time_work_details">{{ old('per_time_work_details') }}</textarea>
                                        @if ($errors->has('per_time_work_details'))
                                            <span class="text-danger">{{ $errors->first('per_time_work_details') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlTextarea1">Scholarship
                                            Policy*</label>
                                        <textarea id="exampleFormControlTextarea1" class="form-control" rows="3" spellcheck="false"
                                            name="scholarship_policy">{{ old('scholarship_policy') }}</textarea>
                                        @if ($errors->has('scholarship_policy'))
                                            <span class="text-danger">{{ $errors->first('scholarship_policy') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlTextarea1"> Campus
                                            Important Notes*</label>
                                        <textarea id="exampleFormControlTextarea1" class="form-control" rows="3" spellcheck="false"
                                            name="institute_important_notes">{{ old('institute_important_notes') }}</textarea>
                                        @if ($errors->has('institute_important_notes'))
                                            <span class="text-danger">{{ $errors->first('institute_important_notes') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="row d-flex align-items-center">
                                        <div class="col col-md-8">
                                            <div class="form-group mb-2"><label>Upload Campus Logo*</label><label
                                                    class="custom-file-container__custom-file"><input type="file"
                                                        class="form-control-file" accept="image/*"
                                                        name="institute_logo"></label>
                                                    @if ($errors->has('institute_logo'))
                                                        <span class="text-danger">{{ $errors->first('institute_logo') }}</span>
                                                    @endif
                                                <div class="custom-file-container__image-preview"></div>
                                            </div>
                                        </div>
                                        <div class="col col-md-4">
                                            <!---->
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row d-flex align-items-center">
                                        <div class="col col-md-8">
                                            <div class="form-group mb-2"><label>Campus Prospectus</label><label
                                                    class="custom-file-container__custom-file"><input type="file"
                                                        class="form-control-file" name="institute_prospectus"></label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row d-flex align-items-center">
                                        <div class="col col-md-8">
                                            <div class="form-group mb-2"><label>Campus Course Module</label><label
                                                    class="custom-file-container__custom-file"><input type="file"
                                                        class="form-control-file" name="institute_course_pdf"></label>
                                                <div class="custom-file-container__image-preview"></div>
                                            </div>
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
                            <div class="row mb-2">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Campus Contact Person</h4><br>
                                </div>
                                <div class="col col-md-12">
                                    <div class="col col-md-12 text-right">
                                        <div class="row ml-4">
                                            <div><a id="addAttributeButton" class="btn btn-warning btn-rounded mb-2 mr-2 inline-flex"> Add
                                                    More <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-plus-circle">
                                                        <circle cx="12" cy="12" r="10">
                                                        </circle>
                                                        <line x1="12" y1="8" x2="12"
                                                            y2="16"></line>
                                                        <line x1="8" y1="12" x2="16"
                                                            y2="12"></line>
                                                    </svg></a></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="select-wrapper">
                                            <div id="element-wrapper">
                                                <div class="row">
                                                    <div class="col col-md-3">
                                                        <div class="form-group mb-2"><label for="personName">Contact Person
                                                                Name</label>
                                                                <input id="personName" type="text" class="form-control" name="name[]">

                                                        </div>
                                                    </div>
                                                    <div class="col col-md-3">
                                                        <div class="form-group mb-2"><label for="email">Email</label><input
                                                                type="email" class="form-control" name="email[]">

                                                        </div>
                                                    </div>
                                                    <div class="col col-md-3">
                                                        <div class="form-group mb-2"><label for="phone">Phone</label><input
                                                                type="text" class="form-control" name="phone[]">
                                                        </div>
                                                    </div>
                                                    <div class="col col-md-3">
                                                        <div class="form-group mb-2"><label for="alternate_phone">Alternate
                                                                Phone</label><input type="text" class="form-control"
                                                                name="alternate_phone[]">
                                                        </div>
                                                    </div>
                                                    <br><span class="input-group-btn"><button type="button" class="btn btn-danger remove-attribute-element"><i class="glyphicon glyphicon-minus"></i>-</button></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mt-5">
                                        <div class="col"><a href="{{ URL::to('all-campus') }}" type="button" class="btn btn-warning btn-lg me-2">
                                                Cancel </a>
                                                <button type="submit" class="btn btn-primary btn-lg mr-2"> Submit </button></div>
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
