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
                                        <li class="breadcrumb-item"><a href="{{ URL::to('agents') }}">Agent Company</a></li>
                                        <li class="breadcrumb-item"><a href="#">{{ $company_data->company_name }}</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Crete New</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <form method="post" action="{{ URL::to('edit_employee_by_agent_post') }}" enctype="multipart/form-data">
                @csrf
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-4">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h4>New Agent Information</h4>
                                    </div><br>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Agent
                                            Name*</label>
                                            <input type="hidden" name="user_id" value="{{ $agent_data->id }}" />
                                            <input name="agent_name" value="{{ $agent_data->agent->agent_name }}" type="text" class="form-control">
                                            @if ($errors->has('agent_name'))
                                                <span class="text-danger">{{ $errors->first('agent_name') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Agent
                                            Phone*</label>
                                            <input name="agent_phone" value="{{ $agent_data->agent->agent_phone }}" type="text" class="form-control">
                                            @if ($errors->has('agent_phone'))
                                                <span class="text-danger">{{ $errors->first('agent_phone') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Agent
                                            Email*</label>
                                            <input name="agent_email" value="{{ $agent_data->agent->agent_email }}" type="email" class="form-control">
                                            @if ($errors->has('agent_email'))
                                                <span class="text-danger">{{ $errors->first('agent_email') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Alternative Person
                                            Contact</label>
                                            <input name="alternative_person_contact" value="{{ $agent_data->agent->alternative_person_contact }}" type="text" class="form-control">

                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">NID or Passport
                                            Number*</label>
                                            <input name="nid_or_passport" value="{{ $agent_data->agent->nid_or_passport }}" type="text" class="form-control">
                                            @if ($errors->has('nid_or_passport'))
                                                <span class="text-danger">{{ $errors->first('nid_or_passport') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Nationality*</label>
                                            <input type="text" value="{{ $agent_data->agent->nationality }}" name="nationality" class="form-control">
                                            @if ($errors->has('nationality'))
                                                <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                            @endif
                                        <!---->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Country*</label>
                                            <select name="agent_country" class="form-control">
                                            <option value="">Select Country
                                            </option>
                                            @foreach ($countries as $country)
                                            <option {{ (!empty($agent_data->agent->agent_country) && $agent_data->agent->agent_country==$country)?'selected':'' }} value="{{ $country }}">{{ $country }}</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('agent_country'))
                                            <span class="text-danger">{{ $errors->first('agent_country') }}</span>
                                        @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">State*</label>
                                        <input name="agent_state" value="{{ $agent_data->agent->agent_state }}" type="text" class="form-control">
                                        @if ($errors->has('agent_state'))
                                            <span class="text-danger">{{ $errors->first('agent_state') }}</span>
                                        @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">City*</label>
                                        <input name="agent_city" value="{{ $agent_data->agent->agent_city }}" type="text" class="form-control">
                                        @if ($errors->has('agent_city'))
                                            <span class="text-danger">{{ $errors->first('agent_city') }}</span>
                                        @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Zip Code*</label>
                                        <input name="agent_zip_code" value="{{ $agent_data->agent->agent_zip_code }}" type="text" class="form-control">
                                        @if ($errors->has('agent_zip_code'))
                                            <span class="text-danger">{{ $errors->first('agent_zip_code') }}</span>
                                        @endif
                                        <!---->
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-4 d-flex align-items-center">
                                <div class="col col-md-6">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Address in
                                            Details*</label>
                                        <textarea name="agent_address" id="exampleFormControlTextarea1" class="form-control" rows="2" spellcheck="false">{{ $agent_data->agent->agent_address }}</textarea>
                                        @if ($errors->has('agent_address'))
                                            <span class="text-danger">{{ $errors->first('agent_address') }}</span>
                                        @endif
                                        <!---->
                                    </div>
                                </div>
                                <div class="col col-md-8">
                                    <div class="row d-flex align-items-center">
                                        <div class="col col-md-8">
                                            <div class="form-group mb-4"><label>Upload Agent Picture</label><label
                                                    class="custom-file-container__custom-file">
                                                    <input type="file" name="image" class="form-control-file" accept="image/*"></label>
                                                <div class="custom-file-container__image-preview">
                                                    <img src="{{ asset($agent_data->photo) }}" width="70px" height="70px" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-md-4">
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
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
