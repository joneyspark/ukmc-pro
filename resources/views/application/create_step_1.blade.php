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
            </div>

            <div class="bs-stepper-content">
                <div id="verticalFormStep-one" class="content fade dstepper-block active" role="tabpanel">

                    <h5 class="text-center">Applicant and Course Detail</h5>
                    <hr>
                    <form method="post" action="{{ URL::to('application-step1-post') }}">
                        @csrf
                        <input type="hidden" name="application_id" value="{{ (!empty($app_data->id))?$app_data->id:'' }}"/>
                        @if(!Auth::check())
                        <div class="col-7 form-group mb-4">
                            <label for="verticalFormStepform-name">Reference (Optional):</label>
                            <input name="reference" value="{{ (!empty($app_data->reference))?$app_data->reference:'' }}" type="text" class="form-control" id="verticalFormStepform-name" placeholder="">
                        </div>
                        @endif
                        @if(Auth::check())
                            @if(Auth::user()->role=='student')
                            <input type="hidden" name="company_id" value="46" />
                            <div class="col-7 form-group mb-4">
                                <label for="verticalFormStepform-name">Reference (Optional):</label>
                                <input name="reference" value="{{ (!empty($app_data->reference))?$app_data->reference:'' }}" type="text" class="form-control" id="verticalFormStepform-name" placeholder="">
                            </div>
                            @else
                            <input name="reference" value="NIL" type="hidden" class="form-control" id="verticalFormStepform-name" placeholder="">
                            @endif
                        @endif
                        @if(Auth::check())
                            @if(Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->role=='adminManager')
                            <div class="form-group mb-4">
                                <label for="verticalFormStepform-name">Agent/Company/Referral:</label>
                                @if(!empty($app_data->company_id) && $app_data->company_id != 42)
                                <select name="company_id" id="company_id" class="form-select">
                                    <option value="" selected>Choose...</option>
                                    @foreach ($a_company_data as $crow)
                                    <option {{ (!empty($app_data->company_id) && $app_data->company_id == $crow->id) ? 'selected' : '' }} value="{{ $crow->id }}">{{ $crow->company_name }}</option>
                                    @endforeach
                                </select>
                                @else
                                <select name="company_id" id="company_id" class="form-select">
                                    <option value="" selected>Choose...</option>
                                    @foreach ($a_company_data as $crow)
                                    <option {{ ($crow->id==43) ? 'selected' : '' }} value="{{ $crow->id }}">{{ $crow->company_name }}</option>
                                    @endforeach
                                </select>
                                @endif

                            </div>
                            @endif
                        @endif
                        @if(Auth::check())
                            @if(Auth::user()->role=='agent' || Auth::user()->role=='subAgent')
                                <input type="hidden" name="company_id" value="{{ Auth::user()->company_id }}" />
                            @endif
                        @endif
                        <div class="row">
                            <div class="col-2 form-group mb-4">
                                <label for="verticalFormStepform-name">Title*:</label>
                                <select name="title" id="inputState" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($name_title as $nrow)
                                    <option {{ (old('title')==$nrow['id'])?'selected':'' }} {{ (!empty($app_data->title) && $app_data->title==$nrow['id'])?'selected':'' }} value="{{ $nrow['id'] }}">{{ $nrow['val'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="col-5 form-group mb-4">
                                <label for="verticalFormStepform-name">First name*:</label>
                                <input name="first_name" value="{{ (!empty($app_data->first_name))?$app_data->first_name:old('first_name') }}" type="text" class="form-control" id="verticalFormStepform-name" placeholder="">
                                @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                            <div class="col-5 form-group mb-4">
                                <label for="verticalFormStepform-name">Last name*:</label>
                                <input name="last_name" value="{{ (!empty($app_data->last_name))?$app_data->last_name:old('last_name') }}" type="text" class="form-control" id="verticalFormStepform-name" placeholder="">
                                @if ($errors->has('last_name'))
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Gender*:</label>
                                <select name="gender" id="inputState" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($gender as $grow)
                                    <option {{ (old('gender')==$grow['id'])?'selected':'' }} {{ (!empty($app_data->gender) && $app_data->gender==$grow['id'])?'selected':'' }} value="{{ $grow['id'] }}">{{ $grow['val'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Date of
                                    Birth*:</label>
                                <input value="{{ (!empty($app_data->date_of_birth))?$app_data->date_of_birth:old('date_of_birth') }}" name="date_of_birth" type="date" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('date_of_birth'))
                                    <span class="text-danger">{{ $errors->first('date_of_birth') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Email*:</label>
                                <input value="{{ (!empty($app_data->email))?$app_data->email:old('email') }}" name="email" type="email" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Phone*:</label>
                                <input value="{{ (!empty($app_data->phone))?$app_data->phone:old('phone') }}" type="text" name="phone" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        @if(!Auth::check() && empty($app_data))
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Password*:</label>
                                <input value="" name="password" type="password" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Confirm Password*:</label>
                                <input value="" type="password" name="password_confirmation" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-8 form-group mb-4">
                                <label for="verticalFormStepform-name">NI Number*:</label>
                                <input value="{{ (!empty($app_data->ni_number))?$app_data->ni_number:old('ni_number') }}" type="text" name="ni_number" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('ni_number'))
                                    <span class="text-danger">{{ $errors->first('ni_number') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Next of Keen Details:</label>
                                <input value="{{ (!empty($app_data->emergency_contact_name))?$app_data->emergency_contact_name:old('emergency_contact_name') }}" type="text" name="emergency_contact_name" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Next of Keen Contact Number:</label>
                                <input value="{{ (!empty($app_data->emergency_contact_number))?$app_data->emergency_contact_number:old('emergency_contact_number') }}" type="text" name="emergency_contact_number" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="text-center">Permanent home address</h5>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">House Number/Name and
                                    Street*:</label>
                                <input id="house_number" name="house_number" value="{{ (!empty($app_data->house_number))?$app_data->house_number:old('house_number') }}" type="text" class="form-control">
                                @if ($errors->has('house_number'))
                                    <span class="text-danger">{{ $errors->first('house_number') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Address Line
                                    2*:</label>
                                <input id="address_line_2" name="address_line_2" value="{{ (!empty($app_data->address_line_2))?$app_data->address_line_2:old('address_line_2') }}" type="text" class="form-control">
                                @if ($errors->has('address_line_2'))
                                    <span class="text-danger">{{ $errors->first('address_line_2') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">City/Town*:</label>
                                <input id="city" name="city" value="{{ (!empty($app_data->city))?$app_data->city:old('city') }}" type="text" class="form-control">
                                @if ($errors->has('city'))
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">State/Province:</label>
                                <input id="state" name="state" value="{{ (!empty($app_data->state))?$app_data->state:old('state') }}" type="text" class="form-control">
                                @if ($errors->has('state'))
                                    <span class="text-danger">{{ $errors->first('state') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Postal Code:</label>
                                <input id="postal_code" name="postal_code" value="{{ (!empty($app_data->postal_code))?$app_data->postal_code:old('postal_code') }}" type="text" class="form-control">
                                @if ($errors->has('postal_code'))
                                    <span class="text-danger">{{ $errors->first('postal_code') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Country*:</label>
                                <select name="address_country" id="address_country" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($country_of_birth as $country1)
                                        <option {{ (!empty($app_data->address_country) && $app_data->address_country==$country1)?'selected':'' }} value="{{ $country1 }}">{{ $country1 }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('address_country'))
                                    <span class="text-danger">{{ $errors->first('address_country') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="text-center">Term Time Address</h5>
                            <hr>
                        </div>
                        <div class="col form-group mb-4">
                            <label for="verticalFormStepform-name">Same as permanent home
                                address ?</label><br>
                            <div class="form-check form-check-primary form-check-inline">
                                <input class="form-check-input" type="radio" {{ (!empty($app_data->same_as) && $app_data->same_as=='no')?'checked':'' }} name="same_as" value="no" id="form-check-radio-info">
                                <label class="form-check-label" for="form-check-radio-primary">
                                    No
                                </label>
                            </div>
                            <div class="form-check form-check-info form-check-inline">
                                <input class="form-check-input" type="radio" value="yes" name="same_as" {{ (!empty($app_data->same_as) && $app_data->same_as=='yes')?'checked':'' }} id="form-check-radio-info">
                                <label class="form-check-label" for="form-check-radio-info">
                                    Yes
                                </label>
                            </div>
                            @if ($errors->has('same_as'))
                                <span class="text-danger">{{ $errors->first('same_as') }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">House Number/Name and
                                    Street:</label>
                                <input type="text" id="current_house_number" name="current_house_number" value="{{ (!empty($app_data->current_house_number))?$app_data->current_house_number:old('current_house_number') }}" class="form-control">
                                @if ($errors->has('current_house_number'))
                                    <span class="text-danger">{{ $errors->first('current_house_number') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Address Line
                                    2:</label>
                                <input id="current_address_line_2" type="text" name="current_address_line_2" value="{{ (!empty($app_data->current_address_line_2))?$app_data->current_address_line_2:old('current_address_line_2') }}" class="form-control">
                                @if ($errors->has('current_address_line_2'))
                                    <span class="text-danger">{{ $errors->first('current_address_line_2') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">City/Town:</label>
                                <input id="current_city" name="current_city" value="{{ (!empty($app_data->current_city))?$app_data->current_city:old('current_city') }}" type="text" class="form-control">
                                @if ($errors->has('current_city'))
                                    <span class="text-danger">{{ $errors->first('current_city') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">County/State/Province:</label>
                                <input id="current_state" name="current_state" value="{{ (!empty($app_data->current_state))?$app_data->current_state:old('current_state') }}" type="text" class="form-control">
                                @if ($errors->has('current_state'))
                                    <span class="text-danger">{{ $errors->first('current_state') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Postal Code:</label>
                                <input id="current_postal_code" name="current_postal_code" value="{{ (!empty($app_data->current_postal_code))?$app_data->current_postal_code:old('current_postal_code') }}" type="text" class="form-control">
                                @if($errors->has('current_postal_code'))
                                    <span class="text-danger">{{ $errors->first('current_postal_code') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Country of permanent
                                residence:</label>
                                <select name="current_country" id="current_country" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($country_of_birth as $country2)
                                        <option {{ (!empty($app_data->current_country) && $app_data->current_country==$country2)?'selected':'' }} value="{{ $country2 }}">{{ $country2 }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('current_country'))
                                    <span class="text-danger">{{ $errors->first('current_country') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group mb-4">
                                <label for="verticalFormStepform-name">Nationality*:</label>
                                <select name="nationality" id="nationality" class="form-select" onchange="change_nationality()">
                                    <option value="">Choose...</option>
                                    <option {{ (old('nationality')=='UK National')?'selected':'' }} {{ (!empty($app_data->nationality) && $app_data->nationality=='UK National')?'selected':'' }} value="UK National">UK National</option>
                                    <option {{ (old('nationality')=='Other')?'selected':'' }} {{ (!empty($app_data->nationality) && $app_data->nationality=='Other')?'selected':'' }} value="Other">Other Nationality</option>
                                </select>
                                @if ($errors->has('nationality'))
                                    <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Date Entry Of UK*:</label>
                                <input name="date_entry_of_uk" value="{{ (!empty($app_data->date_entry_of_uk))?$app_data->date_entry_of_uk:old('date_entry_of_uk') }}" type="date" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('date_entry_of_uk'))
                                    <span class="text-danger">{{ $errors->first('date_entry_of_uk') }}</span>
                                @endif
                            </div>
                        </div>
                        @if(!empty($app_data->nationality) && $app_data->nationality=="Other")
                        <div id="national-other-id" class="">
                            <div class="row">
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Other
                                        Nationality*:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                        </div>
                                        <select name="other_nationality" id="inputState" class="form-select">
                                            <option value="">Choose...</option>
                                            @foreach ($nationalities as $nrow)
                                                <option {{ (!empty($app_data->other_nationality) && $app_data->other_nationality==$nrow)?'selected':'' }} value="{{ $nrow }}">{{ $nrow }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('other_nationality'))
                                            <span class="text-danger">{{ $errors->first('other_nationality') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Visa Category*:</label>
                                    <div class="input-group mb-3">
                                        <select name="visa_category" id="visa_category" class="form-select">
                                            <option value="">Choose...</option>
                                            @foreach ($visa_category as $vrow)
                                                <option {{ (old('visa_category')==$vrow)?'selected':'' }} {{ (!empty($app_data->visa_category) && $app_data->visa_category==$vrow)?'selected':'' }} value="{{ $vrow }}">{{ $vrow }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('visa_category'))
                                            <span class="text-danger">{{ $errors->first('visa_category') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8 form-group mb-4">
                                    <label for="verticalFormStepEmailAddress">Ethnic
                                        Origin*:</label>
                                    <select name="ethnic_origin" id="inputState" class="form-select">
                                        <option value="">Choose...</option>
                                        @foreach ($ethnic_origins as $erow)
                                            <option {{ (old('ethnic_origin')==$erow)?'selected':'' }} {{ (!empty($app_data->ethnic_origin) && $app_data->ethnic_origin==$erow)?'selected':'' }} value="{{ $erow }}">{{ $erow }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ethnic_origin'))
                                        <span class="text-danger">{{ $errors->first('ethnic_origin') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @else
                        <div id="national-other-id" class="national-other-select">
                            <div class="row">
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Other
                                        Nationality*:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                        </div>
                                        <select name="other_nationality" id="inputState" class="form-select">
                                            <option value="">Choose...</option>
                                            @foreach ($nationalities as $nrow)
                                                <option {{ (old('other_nationality')==$nrow)?'selected':'' }} {{ (!empty($app_data->other_nationality) && $app_data->other_nationality==$nrow)?'selected':'' }} value="{{ $nrow }}">{{ $nrow }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('other_nationality'))
                                            <span class="text-danger">{{ $errors->first('other_nationality') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Visa Category*:</label>
                                    <div class="input-group mb-3">
                                        <select name="visa_category" id="visa_category" class="form-select">
                                            <option value="">Choose...</option>
                                            @foreach ($visa_category as $vrow)
                                                <option {{ (old('visa_category')==$vrow)?'selected':'' }} {{ (!empty($app_data->visa_category) && $app_data->visa_category==$vrow)?'selected':'' }} value="{{ $vrow }}">{{ $vrow }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('visa_category'))
                                            <span class="text-danger">{{ $errors->first('visa_category') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8 form-group mb-4">
                                    <label for="verticalFormStepEmailAddress">Ethnic
                                        Origin*:</label>
                                    <select name="ethnic_origin" id="inputState" class="form-select">
                                        <option value="">Choose...</option>
                                        @foreach ($ethnic_origins as $erow)
                                            <option {{ (old('ethnic_origin')==$erow)?'selected':'' }} {{ (!empty($app_data->ethnic_origin) && $app_data->ethnic_origin==$erow)?'selected':'' }} value="{{ $erow }}">{{ $erow }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ethnic_origin'))
                                        <span class="text-danger">{{ $errors->first('ethnic_origin') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Select University*:</label>
                                <select onchange="getCampus()" data-action="{{ URL::to('get-campus-by-university') }}" id="university_id" name="university_id" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($a_list_university as $urow)
                                    <option {{ (old('university_id')==$urow->id)?'selected':'' }} {{ (!empty($app_data->university_id) && $app_data->university_id==$urow->id)?'selected':'' }} value="{{ $urow->id }}">{{ $urow->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('university_id'))
                                    <span class="text-danger">{{ $errors->first('university_id') }}</span>
                                @endif
                            </div>
                            @if(!empty($app_data->university_id))
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Select Campus*:</label>
                                <select onchange="getCourse()" data-action="{{ URL::to('get-courses-by-campus') }}" id="campus_id" name="campus_id" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($a_campuses_data as $cdata)
                                    <option {{ (!empty($app_data->campus_id) && $app_data->campus_id==$cdata->id)?'selected':'' }} value="{{ $cdata->id }}">{{ $cdata->campus_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('campus_id'))
                                    <span class="text-danger">{{ $errors->first('campus_id') }}</span>
                                @endif
                            </div>
                            @else
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Select Campus*:</label>
                                <select onchange="getCourse()" data-action="{{ URL::to('get-courses-by-campus') }}" id="campus_id" name="campus_id" class="form-select">
                                    <option value="">Choose...</option>

                                </select>
                                @if ($errors->has('campus_id'))
                                    <span class="text-danger">{{ $errors->first('campus_id') }}</span>
                                @endif
                            </div>
                            @endif

                            @if(!empty($app_data->course_id))
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Course*:</label>
                                <select onchange="getCourseInfo()" data-action="{{ URL::to('get-course-info') }}" id="course_data" name="course_id" class="get-course-info-data form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($course_list_data as $crow)
                                    <option {{ (!empty($app_data->course_id) && $app_data->course_id==$crow->id)?'selected':'' }} value="{{ $crow->id }}">{{ $crow->course_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('course_id'))
                                    <span class="text-danger">{{ $errors->first('course_id') }}</span>
                                @endif
                            </div>
                            @else
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Course*:</label>
                                <select onchange="getCourseInfo()" data-action="{{ URL::to('get-course-info') }}" id="course_data" name="course_id" class="get-course-info-data form-select">
                                    <option value="">Choose...</option>
                                </select>
                                @if ($errors->has('course_id'))
                                    <span class="text-danger">{{ $errors->first('course_id') }}</span>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-6 form-group mb-4">
                                <label for="verticalFormStepform-name">Course fee
                                    (GBP) Per Year (Local):</label>
                                <input type="text" value="{{ (!empty($app_data->local_course_fee))?$app_data->local_course_fee:old('local_course_fee') }}" class="course-fee-local-data form-control" id="local_course_fee" name="local_course_fee" placeholder="">
                                <input value="{{ (!empty($app_data->international_course_fee))?$app_data->international_course_fee:old('international_course_fee') }}" type="hidden" class="form-control" id="international_course_fee" name="international_course_fee" placeholder="">
                                @if ($errors->has('local_course_fee'))
                                    <span class="text-danger">{{ $errors->first('local_course_fee') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label style="display: flex;" for="verticalFormStepform-name">Intake: <div id="course_intake"></div></label>
                                <select name="intake" id="inputState" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($intakes as $irow)
                                    <option {{ (old('intake')==$irow->value)?'selected':'' }} {{ (!empty($app_data->intake) && $app_data->intake==$irow->value)?'selected':'' }} value="{{ $irow->value }}">{{ date('F Y',strtotime($irow->title)) }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('intake'))
                                    <span class="text-danger">{{ $errors->first('intake') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Delivery
                                    Pattern:</label>
                                <select name="delivery_pattern" id="inputState" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($delivery_pattern as $pattern)
                                    <option {{ (old('delivery_pattern')==$pattern['id'])?'selected':'' }} {{ (!empty($app_data->delivery_pattern) && $app_data->delivery_pattern==$pattern['id'])?'selected':'' }} value="{{ $pattern['id'] }}">{{ $pattern['val'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('delivery_pattern'))
                                    <span class="text-danger">{{ $errors->first('delivery_pattern') }}</span>
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
<script src="{{ asset('web/js/jquery.js') }}"></script>
<script>
    $(document).ready(function() {
    $('input[name="same_as"]').change(function() {
      var selectedValue = $('input[name="same_as"]:checked').val();
      if(selectedValue==='yes'){
        //alert('Selected same: ' + selectedValue);
        var house_number = $('#house_number').val();
        var address_line_2 = $('#address_line_2').val();
        var city = $('#city').val();
        var state = $('#state').val();
        var postal_code = $('#postal_code').val();
        var address_country = $('#address_country').val();

        $('#current_house_number').val(house_number);
        $('#current_address_line_2').val(address_line_2);
        $('#current_city').val(city);
        $('#current_state').val(state);
        $('#current_postal_code').val(postal_code);
        $('#current_country').val(address_country);
      }else{
        $('#current_house_number').val("");
        $('#current_address_line_2').val("");
        $('#current_city').val("");
        $('#current_state').val("");
        $('#current_postal_code').val("");
        $('#current_country').val("");
      }

    });
  });
</script>
<style>
    .national-other-select{
        display: none;
    }
</style>
@stop
