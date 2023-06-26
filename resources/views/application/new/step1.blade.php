@extends('adminpanel')
@section('admin')
<div class="container">
    <div class="row secondary-nav">
        <div class="breadcrumbs-container" data-page-heading="Analytics">
            <header class="header navbar navbar-expand-sm">
                <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
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
    {{-- <h5 class="p-3">New Applicant</h5> --}}
    <div class="row col-12" id="cancel-row">
        <div class="container bs-stepper stepper-form-vertical vertical linear mt-3">
            <div class="bs-stepper-header" role="tablist">
                <div class="step active" data-target="#verticalFormStep-one">
                    <button type="button" class="step-trigger active" role="tab">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">Step One</span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#verticalFormStep-two">
                    <button type="button" class="step-trigger" role="tab">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">Step Two</span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#verticalFormStep-three">
                    <button type="button" class="step-trigger" role="tab">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Three</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#verticalFormStep-four">
                    <button type="button" class="step-trigger" role="tab">
                        <span class="bs-stepper-circle">4</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Four</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#verticalFormStep-five">
                    <button type="button" class="step-trigger" role="tab">
                        <span class="bs-stepper-circle">5</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Five</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#verticalFormStep-Six">
                    <button type="button" class="step-trigger" role="tab">
                        <span class="bs-stepper-circle">6</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Final Step</span>
                        </span>
                    </button>
                </div>
            </div>

            <div class="bs-stepper-content">
                <div id="verticalFormStep-one" class="content fade dstepper-block active" role="tabpanel">

                    <h5 class="text-center">Applicant and Course Detail</h5>
                    <hr>
                    <form method="post" action="{{ URL::to('step-1-post') }}">
                        @csrf
                        <input type="hidden" name="application_id" value="{{ (!empty($app_data->id))?$app_data->id:'' }}"/>
                        @if(Auth::check() && Auth::user()->role=='admin')
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">Agent/Company/Referral:</label>
                            <select name="company_id" id="company_id" class="form-select">
                                <option value="" selected>Choose...</option>
                                @foreach ($a_company_data as $crow)
                                <option {{ (!empty($app_data->company_id) && $app_data->company_id==$crow->id)?'selected':'' }} value="{{ $crow->id }}">{{ $crow->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        @if(Auth::check() && Auth::user()->role=='agent')
                            <input type="hidden" name="company_id" value="{{ Auth::user()->company_id }}" />
                        @endif

                        <div class="row">
                            <div class="col-2 form-group mb-4">
                                <label for="verticalFormStepform-name">Title:</label>
                                <select name="title" id="inputState" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($name_title as $nrow)
                                    <option {{ (!empty($app_data->title) && $app_data->title==$nrow['id'])?'selected':'' }} value="{{ $nrow['id'] }}">{{ $nrow['val'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="col-5 form-group mb-4">
                                <label for="verticalFormStepform-name">First name:</label>
                                <input name="first_name" value="{{ (!empty($app_data->first_name))?$app_data->first_name:old('first_name') }}" type="text" class="form-control" id="verticalFormStepform-name" placeholder="">
                                @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                            <div class="col-5 form-group mb-4">
                                <label for="verticalFormStepform-name">Last name:</label>
                                <input name="last_name" value="{{ (!empty($app_data->last_name))?$app_data->last_name:old('last_name') }}" type="text" class="form-control" id="verticalFormStepform-name" placeholder="">
                                @if ($errors->has('last_name'))
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Gender:</label>
                                <select name="gender" id="inputState" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($gender as $grow)
                                    <option {{ (!empty($app_data->gender) && $app_data->gender==$grow['id'])?'selected':'' }} value="{{ $grow['id'] }}">{{ $grow['val'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Date of
                                    Birth:</label>
                                <input value="{{ (!empty($app_data->date_of_birth))?$app_data->date_of_birth:old('date_of_birth') }}" name="date_of_birth" type="date" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('date_of_birth'))
                                    <span class="text-danger">{{ $errors->first('date_of_birth') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Email:</label>
                                <input value="{{ (!empty($app_data->email))?$app_data->email:old('email') }}" name="email" type="email" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Phone:</label>
                                <input value="{{ (!empty($app_data->phone))?$app_data->phone:old('phone') }}" type="text" name="phone" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8 form-group mb-4">
                                <label for="verticalFormStepform-name">NI Number:</label>
                                <input value="{{ (!empty($app_data->ni_number))?$app_data->ni_number:old('ni_number') }}" type="text" name="phone" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('ni_number'))
                                    <span class="text-danger">{{ $errors->first('ni_number') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Emergency Contact Name:</label>
                                <input value="{{ (!empty($app_data->emergency_contact_name))?$app_data->emergency_contact_name:old('emergency_contact_name') }}" type="text" name="emergency_contact_name" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('emergency_contact_name'))
                                    <span class="text-danger">{{ $errors->first('emergency_contact_name') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Emergency Contact Number:</label>
                                <input value="{{ (!empty($app_data->emergency_contact_number))?$app_data->emergency_contact_number:old('emergency_contact_number') }}" type="text" name="emergency_contact_number" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('emergency_contact_number'))
                                    <span class="text-danger">{{ $errors->first('emergency_contact_number') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Nationality:</label>
                                <input value="{{ (!empty($app_data->emergency_contact_name))?$app_data->emergency_contact_name:old('emergency_contact_name') }}" type="text" name="emergency_contact_name" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('emergency_contact_name'))
                                    <span class="text-danger">{{ $errors->first('emergency_contact_name') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Other Nationality:</label>
                                <input value="{{ (!empty($app_data->emergency_contact_number))?$app_data->emergency_contact_number:old('emergency_contact_number') }}" type="text" name="emergency_contact_number" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('emergency_contact_number'))
                                    <span class="text-danger">{{ $errors->first('emergency_contact_number') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Date Entry Of UK:</label>
                                <input value="{{ (!empty($app_data->emergency_contact_name))?$app_data->emergency_contact_name:old('emergency_contact_name') }}" type="text" name="emergency_contact_name" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('emergency_contact_name'))
                                    <span class="text-danger">{{ $errors->first('emergency_contact_name') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Ethnicity:</label>
                                <input value="{{ (!empty($app_data->emergency_contact_number))?$app_data->emergency_contact_number:old('emergency_contact_number') }}" type="text" name="emergency_contact_number" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('emergency_contact_number'))
                                    <span class="text-danger">{{ $errors->first('emergency_contact_number') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="button-action mt-3">
                            <button class="btn btn-secondary btn-prev me-3" disabled>Prev</button>
                            <button type="submit" class="btn btn-secondary">Next</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

@stop
