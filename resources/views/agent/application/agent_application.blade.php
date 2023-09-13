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
                                        <li class="breadcrumb-item"><a href="#">Agent Application</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Form</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <form method="post" action="{{ URL::to('agent-application-data-post') }}" enctype="multipart/form-data">
                @csrf
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="d-flex align-items-start justify-content-between">
                                <h4>Agent Company Information</h4>
                            </div><br>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            Name*</label>
                                            <input name="company_name" value="{{ old('company_name') }}" type="text" class="form-control">
                                            @if ($errors->has('company_name'))
                                                <span class="text-danger">{{ $errors->first('company_name') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company Registration
                                            Number*</label>
                                            <input value="{{ old('company_registration_number') }}" name="company_registration_number" type="text" class="form-control">
                                            @if ($errors->has('company_registration_number'))
                                                <span class="text-danger">{{ $errors->first('company_registration_number') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company Establish
                                            Date*</label>
                                            <input name="company_establish_date" value="{{ old('company_establish_date') }}" type="date" class="form-control">
                                            @if ($errors->has('company_establish_date'))
                                                <span class="text-danger">{{ $errors->first('company_establish_date') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="exampleFormControlInput1">Company Trade License
                                            Number*</label>
                                            <input type="text" value="{{ old('company_trade_license_number') }}" name="company_trade_license_number" class="form-control">
                                            @if ($errors->has('company_trade_license_number'))
                                                <span class="text-danger">{{ $errors->first('company_trade_license_number') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            Email*</label>
                                            <input value="{{ old('company_email') }}" name="company_email" type="text" class="form-control">
                                            @if ($errors->has('company_email'))
                                                <span class="text-danger">{{ $errors->first('company_email') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            Phone*</label>
                                            <input name="company_phone" value="{{ old('company_phone') }}" type="text" class="form-control">
                                            @if ($errors->has('company_phone'))
                                                <span class="text-danger">{{ $errors->first('company_phone') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            Country*</label>
                                            <select name="country" class="form-control">
                                                <option value="">--Select Country--</option>
                                                @foreach ($countries as $country)
                                                <option value="{{ $country }}">{{ $country }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('country'))
                                                <span class="text-danger">{{ $errors->first('country') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            State*</label>
                                            <input name="state" value="{{ old('state') }}" type="text" class="form-control">
                                            @if ($errors->has('state'))
                                                <span class="text-danger">{{ $errors->first('state') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            City*</label>
                                            <input name="city" value="{{ old('city') }}" type="text" class="form-control">
                                            @if ($errors->has('city'))
                                                <span class="text-danger">{{ $errors->first('city') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company Zip
                                            Code*</label>
                                            <input name="zip_code" value="{{ old('zip_code') }}" type="text" class="form-control">
                                            @if ($errors->has('zip_code'))
                                                <span class="text-danger">{{ $errors->first('zip_code') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 d-flex align-items-center">
                                <div class="col col-md-6">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Company
                                            Address*</label>
                                        <textarea name="address" id="exampleFormControlTextarea1" class="form-control" rows="2" spellcheck="false">{{ old('address') }}</textarea>
                                        @if ($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
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
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h4>Director’s Information</h4>
                                    </div><br>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Director
                                            Name*</label>
                                            <input name="director_name" value="{{ old('director_name') }}" type="text" class="form-control">
                                            @if ($errors->has('director_name'))
                                                <span class="text-danger">{{ $errors->first('director_name') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Director Phone*</label>
                                            <input name="director_phone" value="{{ old('director_phone') }}" type="text" class="form-control">
                                            @if ($errors->has('director_phone'))
                                                <span class="text-danger">{{ $errors->first('director_phone') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Director
                                            Email*</label>
                                            <input name="director_email" value="{{ old('director_email') }}" type="email" class="form-control">
                                            @if ($errors->has('director_email'))
                                                <span class="text-danger">{{ $errors->first('director_email') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Passport Number</label>
                                            <input name="passport_number" value="{{ old('passport_number') }}" type="text" class="form-control">
                                            @if ($errors->has('passport_number'))
                                                <span class="text-danger">{{ $errors->first('passport_number') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Nationality*</label>
                                            <input type="text" value="{{ old('nationality') }}" name="nationality" class="form-control">
                                            @if ($errors->has('nationality'))
                                                <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col col-md-6">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Address in
                                            Details*</label>
                                        <textarea name="director_address" id="exampleFormControlTextarea1" class="form-control" rows="2" spellcheck="false">{{ old('director_address') }}</textarea>
                                        @if ($errors->has('director_address'))
                                            <span class="text-danger">{{ $errors->first('director_address') }}</span>
                                        @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">City*</label>
                                        <input name="director_city" value="{{ old('director_city') }}" type="text" class="form-control">
                                        @if ($errors->has('director_city'))
                                            <span class="text-danger">{{ $errors->first('director_city') }}</span>
                                        @endif
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Key Contact Name*</label>
                                            <input name="key_contact_name" value="{{ old('key_contact_name') }}" type="text" class="form-control">
                                            @if ($errors->has('key_contact_name'))
                                                <span class="text-danger">{{ $errors->first('key_contact_name') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Key Contact Number</label>
                                            <input name="key_contact_number" value="{{ old('key_contact_number') }}" type="text" class="form-control">
                                            @if ($errors->has('key_contact_number'))
                                                <span class="text-danger">{{ $errors->first('key_contact_number') }}</span>
                                            @endif
                                        <!---->
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
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h4>1st Reference</h4>
                                    </div><br>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            Name*</label>
                                            <input name="reference_company_name" value="{{ old('reference_company_name') }}" type="text" class="form-control">
                                            @if ($errors->has('reference_company_name'))
                                                <span class="text-danger">{{ $errors->first('reference_company_name') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Referee Name*</label>
                                            <input name="referee_name" value="{{ old('referee_name') }}" type="text" class="form-control">
                                            @if ($errors->has('referee_name'))
                                                <span class="text-danger">{{ $errors->first('referee_name') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Referee Job Title*</label>
                                            <input name="referee_job_title" value="{{ old('referee_job_title') }}" type="text" class="form-control">
                                            @if ($errors->has('referee_job_title'))
                                                <span class="text-danger">{{ $errors->first('referee_job_title') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-4">
                                <div class="col col-md-7">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Address in
                                            Details*</label>
                                        <textarea name="referee_address" id="exampleFormControlTextarea1" class="form-control" rows="2" spellcheck="false">{{ old('referee_address') }}</textarea>
                                        @if ($errors->has('referee_address'))
                                            <span class="text-danger">{{ $errors->first('referee_address') }}</span>
                                        @endif
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Referee Phone*</label>
                                            <input name="referee_phone" value="{{ old('referee_phone') }}" type="text" class="form-control">
                                            @if ($errors->has('referee_phone'))
                                                <span class="text-danger">{{ $errors->first('referee_phone') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Referee Contact Email*</label>
                                            <input name="referee_contact_email" value="{{ old('referee_contact_email') }}" type="text" class="form-control">
                                            @if ($errors->has('referee_contact_email'))
                                                <span class="text-danger">{{ $errors->first('referee_contact_email') }}</span>
                                            @endif
                                        <!---->
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
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h4>2nd Reference</h4>
                                    </div><br>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            Name</label>
                                            <input name="reference_company_name2" value="{{ old('reference_company_name2') }}" type="text" class="form-control">
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Referee Name</label>
                                            <input name="referee_name2" value="{{ old('referee_name2') }}" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Referee Job Title</label>
                                            <input name="referee_job_title2" value="{{ old('referee_job_title2') }}" type="text" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-4">
                                <div class="col col-md-7">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Address in
                                            Details</label>
                                        <textarea name="referee_address2" id="exampleFormControlTextarea1" class="form-control" rows="2" spellcheck="false">{{ old('referee_address2') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Referee Phone</label>
                                            <input name="referee_phone2" value="{{ old('referee_phone2') }}" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Referee Contact Email</label>
                                            <input name="referee_contact_email2" value="{{ old('referee_contact_email2') }}" type="text" class="form-control">
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
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h4>Document Upload</h4>
                                    </div><br>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company certification of incorporation</label>
                                            <input type="hidden" name="company_certification_of_incorporation" value="Company certification of incorporation"/>
                                            <input name="company_certificate" value="" type="file" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Director ID or Passport</label>
                                            <input type="hidden" name="director_id_or_passport" value="Director ID or Passport"/>
                                            <input name="director_id_passport" value="" type="file" class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Bank account details </label>
                                            <input type="hidden" name="bank_account_details" value="Bank Account Details"/>
                                            <input name="bank_account_details_photo" value="" type="file" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Signed Agent Agreement  </label>
                                            <input type="hidden" name="signed_agent_agreement" value="Signed Agent Agreement "/>
                                            <input name="signed_agent_agreement_photo" value="" type="file" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="row">
                                    <div class="col text-right">
                                        <div class="row">
                                            <div class="col"><a href="/agents" class=""><button type="submit"
                                                        class="btn btn-warning mr-2">Cancel</button></a><button
                                                    class="btn btn-primary ms-2"><span>Submit</span></button></div>
                                        </div>
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
