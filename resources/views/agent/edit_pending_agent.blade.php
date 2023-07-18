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
                                            <input name="company_name" value="{{ (!empty($company_data->company_name))?$company_data->company_name:old('company_name') }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company Registration
                                            Number*</label>
                                            <input value="{{ (!empty($company_data->company_registration_number))?$company_data->company_registration_number:old('company_registration_number') }}" name="company_registration_number" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company Establish
                                            Date*</label>
                                            <input name="company_establish_date" value="{{ (!empty($company_data->company_establish_date))?$company_data->company_establish_date:old('company_establish_date') }}" type="date" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="exampleFormControlInput1">Company Trade License
                                            Number*</label>
                                            <input type="text" value="{{ (!empty($company_data->company_trade_license_number))?$company_data->company_trade_license_number:old('company_trade_license_number') }}" name="company_trade_license_number" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            Email*</label>
                                            <input value="{{ (!empty($company_data->company_email))?$company_data->company_email:old('company_email') }}" name="company_email" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            Phone*</label>
                                            <input name="company_phone" value="{{ (!empty($company_data->company_phone))?$company_data->company_phone:old('company_phone') }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            Country*</label>
                                            <select name="country" class="form-control">
                                                <option value="">--Select Country--</option>
                                                @foreach ($countries as $country)
                                                <option {{ (!empty($company_data->country) && $company_data->country==$country)?'selected':'' }} value="{{ $country }}">{{ $country }}</option>
                                                @endforeach
                                            </select>

                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            State*</label>
                                            <input name="state" value="{{ (!empty($company_data->state))?$company_data->state:old('state') }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            City*</label>
                                            <input name="city" value="{{ (!empty($company_data->city))?$company_data->city:old('city') }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company Zip
                                            Code*</label>
                                            <input name="zip_code" value="{{ (!empty($company_data->zip_code))?$company_data->zip_code:old('zip_code') }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 d-flex align-items-center">
                                <div class="col col-md-6">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Company
                                            Address*</label>
                                        <textarea name="address" id="exampleFormControlTextarea1" class="form-control" rows="2" spellcheck="false">{{ (!empty($company_data->address))?$company_data->address:old('address') }}</textarea>

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
                                            <input name="director_name" value="{{ (!empty($company_data->company_director->director_name))?$company_data->company_director->director_name:'' }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Director Phone*</label>
                                            <input name="director_phone" value="{{ (!empty($company_data->company_director->phone))?$company_data->company_director->phone:'' }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Director
                                            Email*</label>
                                            <input name="director_email" value="{{ (!empty($company_data->company_director->email))?$company_data->company_director->email:'' }}" type="email" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Passport Number</label>
                                            <input name="passport_number" value="{{ (!empty($company_data->company_director->passport_number))?$company_data->company_director->passport_number:'' }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Nationality*</label>
                                            <input type="text" value="{{ (!empty($company_data->company_director->nationality))?$company_data->company_director->nationality:'' }}" name="nationality" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col col-md-6">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Address in
                                            Details*</label>
                                        <textarea name="director_address" id="exampleFormControlTextarea1" class="form-control" rows="2" spellcheck="false">{{ (!empty($company_data->company_director->address))?$company_data->company_director->address:'' }}</textarea>

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">City*</label>
                                        <input name="director_city" value="{{ (!empty($company_data->company_director->city))?$company_data->company_director->city:'' }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Key Contact Name*</label>
                                            <input name="key_contact_name" value="{{ (!empty($company_data->company_director->key_contact_name))?$company_data->company_director->key_contact_name:'' }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Key Contact Number</label>
                                            <input name="key_contact_number" value="{{ (!empty($company_data->company_director->key_contact_number))?$company_data->company_director->key_contact_number:'' }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count($company_data->company_reference) > 0)
                @foreach ($company_data->company_reference as $key=>$reference)
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-4">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h4>Reference {{ $key+1 }}</h4>
                                    </div><br>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Company
                                            Name*</label>
                                            <input name="reference_company_name2" value="{{ (!empty($reference->company_name))?$reference->company_name:'' }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Referee Name*</label>
                                            <input name="referee_name2" value="{{ (!empty($reference->referee_name))?$reference->referee_name:'' }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Referee Job Title*</label>
                                            <input name="referee_job_title2" value="{{ (!empty($reference->referee_job_title))?$reference->referee_job_title:'' }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-4">
                                <div class="col col-md-7">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Address in
                                            Details*</label>
                                        <textarea name="referee_address2" id="exampleFormControlTextarea1" class="form-control" rows="2" spellcheck="false">{{ (!empty($reference->address))?$reference->address:'' }}</textarea>

                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Referee Phone*</label>
                                            <input name="referee_phone2" value="{{ (!empty($reference->phone))?$reference->phone:'' }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Referee Contact Email*</label>
                                            <input name="referee_contact_email2" value="{{ (!empty($reference->contact_email_address))?$reference->contact_email_address:'' }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
                @endif

                @if(count($company_data->company_document) > 0)
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-4">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h4>Document List</h4>
                                    </div><br>
                                </div>
                                <table class="table" border="0">
                                    @foreach ($company_data->company_document as $document)
                                    <tr>
                                        <td>{{ (!empty($document->title))?$document->title:'' }}</td>
                                        <td>{{ (!empty($document->title))?'Yes':'No' }}</td>
                                        <td><a download href="{{ asset($document->document) }}">Download</a></td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <form method="post" action="{{ URL::to('request-agent-application-data-post') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="widget-content widget-content-area">
                                <div class="row mb-4">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Agent Login Information</h4><br>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mb-4"><label for="personName">Person Name*</label>
                                            <input type="hidden" name="company_id" value="{{ (!empty($company_data->id))?$company_data->id:'' }}" />
                                            <input name="name" value="{{ (!empty($company_data->company_director->director_name))?$company_data->company_director->director_name:old('name') }}" id="personName" type="text" class="form-control">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                            <!---->
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mb-4"><label for="email">Email*</label>
                                            <input type="email" name="email" value="{{ (!empty($company_data->company_email))?$company_data->company_email:old('email') }}" class="form-control">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                            <!---->
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mb-4"><label for="password">Password*</label>
                                            <input name="password" type="password" class="form-control">
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                            <!---->
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mb-4"><label for="password">Confirm Password*</label>
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
                                            <div class="col"><a href="/agents" class=""><button type="submit"
                                                        class="btn btn-warning mr-2">Cancel</button></a><button
                                                    class="btn btn-primary ms-2"><span>Submit</span></button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

        </div>
    </div>

@stop
