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
                                <li class="breadcrumb-item active" aria-current="page">Create Step 2</li>
                            </ol>
                        </nav>

                    </div>
                </div>
            </header>
        </div>
    </div>
    {{-- <h5 class="p-3">New Applicant</h5> --}}
    <div class="row" id="cancel-row">
        <div class="container bs-stepper stepper-form-vertical vertical linear mt-3">
            <div class="bs-stepper-header" role="tablist">
                <div class="step crossed" data-target="#verticalFormStep-one">
                    <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">Step One</span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step active" data-target="#verticalFormStep-two">
                    <button type="button" class="step-trigger active" role="tab">
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
                <div id="verticalFormStep-two" class="content fade dstepper-block active" role="tabpanel">
                    <h5 class="text-center">Personal Information</h5>
                    <hr>
                    <form method="post" action="{{ URL::to('step-2-post') }}">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="app_step_2_id" value="{{ (!empty($app_data_2->id)) }}" />
                            <input type="hidden" name="application_id" value="{{ (!empty($application_id))?$application_id:'' }}" />
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Nationality*:</label>
                                <select name="nationality" id="inputState" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($nationalities as $nrow)
                                    <option {{ (!empty($app_data_2->nationality) && $app_data_2->nationality==$nrow)?'selected':'' }} value="{{ $nrow }}">{{ $nrow }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('nationality'))
                                    <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Other
                                    Nationality:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                    </div>
                                    <select name="other_nationality" id="inputState" class="form-select">
                                        <option value="">Choose...</option>
                                        @foreach ($nationalities as $nrow)
                                            <option {{ (!empty($app_data_2->other_nationality) && $app_data_2->other_nationality==$nrow)?'selected':'' }} value="{{ $nrow }}">{{ $nrow }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepEmailAddress">Ethnic
                                    Origin*:</label>
                                <select name="ethnic_origin" id="inputState" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($ethnic_origins as $erow)
                                        <option {{ (!empty($app_data_2->ethnic_origin) && $app_data_2->ethnic_origin==$erow)?'selected':'' }} value="{{ $erow }}">{{ $erow }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('ethnic_origin'))
                                    <span class="text-danger">{{ $errors->first('ethnic_origin') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Country of
                                    Birth*:</label>
                                <select name="country" id="inputState" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($country_of_birth as $country)
                                        <option {{ (!empty($app_data_2->country) && $app_data_2->country==$country)?'selected':'' }} value="{{ $country }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country'))
                                    <span class="text-danger">{{ $errors->first('country') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">Highest qualification on
                                entry:</label>
                            <div class="div">
                                <div class="form-check form-check-primary form-check-inline">
                                    <input class="form-check-input" type="radio" name="highest_qualification_entry" {{ (!empty($app_data_2->highest_qualification_entry) && $app_data_2->highest_qualification_entry=='UK')?'checked':'checked' }} value="UK" id="form-check-radio-primary">
                                    <label class="form-check-label" for="form-check-radio-primary">
                                        UK
                                    </label>
                                </div>

                                <div class="form-check form-check-info form-check-inline">
                                    <input class="form-check-input" value="Overseas" type="radio" {{ (!empty($app_data_2->highest_qualification_entry) && $app_data_2->highest_qualification_entry=='Overseas')?'checked':'' }} name="highest_qualification_entry" id="form-check-radio-info">
                                    <label class="form-check-label" for="form-check-radio-info">
                                        Overseas
                                    </label>
                                </div>
                                <p class="text-white">We need to know the highest qualification you expect to have achieved before you start the course that you're applying for. To provide you with a list of options to choose from, please tell us
                                    if the highest qualification you expect to have achieved was studied in the UK or overseas.</p>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">Please choose your
                                highest qualification from the list*:</label>
                            <select name="highest_qualification" id="inputState" class="form-select">
                                <option selected>Choose...</option>
                                @foreach ($highest_qualifications as $hrow)
                                    <option {{ (!empty($app_data_2->highest_qualification) && $app_data_2->highest_qualification==$hrow['id'])?'selected':'' }} value="{{ $hrow['id'] }}">{{ $hrow['val'] }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('highest_qualification'))
                                <span class="text-danger">{{ $errors->first('highest_qualification') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">When you start this
                                course what will the last institution you attended
                                be?*</label>
                            <select name="last_institution_you_attended" id="inputState" class="form-select">
                                <option value="">Choose...</option>
                                @foreach ($last_institution_to_be_attend as $hirow)
                                    <option {{ (!empty($app_data_2->last_institution_you_attended) && $app_data_2->last_institution_you_attended==$hirow['id'])?'selected':'' }} value="{{ $hirow['id'] }}">{{ $hirow['val'] }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('last_institution_you_attended'))
                                <span class="text-danger">{{ $errors->first('last_institution_you_attended') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">Unique Learner Number
                                (ULN)*:</label>
                            <input type="text" name="unique_learner_number" value="{{ (!empty($app_data_2->unique_learner_number))?$app_data_2->unique_learner_number:old('unique_learner_number') }}" class="form-control" id="verticalFormStepform-name">
                            @if ($errors->has('unique_learner_number'))
                                <span class="text-danger">{{ $errors->first('unique_learner_number') }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Name of
                                    qualification*:</label>
                                <input type="text" value="{{ (!empty($app_data_2->name_of_qualification))?$app_data_2->name_of_qualification:old('name_of_qualification') }}" name="name_of_qualification" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('name_of_qualification'))
                                    <span class="text-danger">{{ $errors->first('name_of_qualification') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Year
                                    achieved/obtained*:</label>
                                <input name="you_obtained" value="{{ (!empty($app_data_2->you_obtained))?$app_data_2->you_obtained:old('you_obtained') }}" type="text" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('you_obtained'))
                                    <span class="text-danger">{{ $errors->first('you_obtained') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Subject*:</label>
                                <input type="text" name="subject" value="{{ (!empty($app_data_2->subject))?$app_data_2->subject:old('subject') }}" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('subject'))
                                    <span class="text-danger">{{ $errors->first('subject') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Grade*:</label>
                                <input type="text" name="grade" value="{{ (!empty($app_data_2->grade))?$app_data_2->grade:old('grade') }}" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('grade'))
                                    <span class="text-danger">{{ $errors->first('grade') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Passport No:</label>
                                <input type="text" name="passport_no" value="{{ (!empty($app_data_2->passport_no))?$app_data_2->passport_no:old('passport_no') }}" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Passport Expiry
                                    :</label>
                                <input type="date" name="passport_expiry" value="{{ (!empty($app_data_2->passport_expiry))?$app_data_2->passport_expiry:old('passport_expiry') }}" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Passport Place of
                                    Issuance:</label>
                                <input name="passport_place" value="{{ (!empty($app_data_2->passport_place))?$app_data_2->passport_place:old('passport_place') }}" type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7 form-group mb-4">
                                <label for="verticalFormStepform-name">Have you spent any
                                    time in public care up to the age of 18? </label>
                                <input name="spent_public_care" value="{{ (!empty($app_data_2->spent_public_care))?$app_data_2->spent_public_care:old('spent_public_care') }}" type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Disability/special
                                    needs</label>
                                <input name="disability" value="{{ (!empty($app_data_2->disability))?$app_data_2->disability:old('disability') }}" type="text" class="form-control" id="verticalFormStepform-name">
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
                                <input name="house_number" value="{{ (!empty($app_data_2->house_number))?$app_data_2->house_number:old('house_number') }}" type="text" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('house_number'))
                                    <span class="text-danger">{{ $errors->first('house_number') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Address Line
                                    2*:</label>
                                <input name="address_line_2" value="{{ (!empty($app_data_2->address_line_2))?$app_data_2->address_line_2:old('address_line_2') }}" type="text" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('address_line_2'))
                                    <span class="text-danger">{{ $errors->first('address_line_2') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">City/Town*:</label>
                                <input name="city" value="{{ (!empty($app_data_2->city))?$app_data_2->city:old('city') }}" type="text" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('city'))
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">State/Province:</label>
                                <input name="state" value="{{ (!empty($app_data_2->state))?$app_data_2->state:old('state') }}" type="text" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('state'))
                                    <span class="text-danger">{{ $errors->first('state') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Postal Code:</label>
                                <input name="postal_code" value="{{ (!empty($app_data_2->postal_code))?$app_data_2->postal_code:old('postal_code') }}" type="text" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('postal_code'))
                                    <span class="text-danger">{{ $errors->first('postal_code') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Country*:</label>
                                <select name="address_country" id="inputState" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($country_of_birth as $country1)
                                        <option {{ (!empty($app_data_2->address_country) && $app_data_2->address_country==$country1)?'selected':'' }} value="{{ $country1 }}">{{ $country1 }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('address_country'))
                                    <span class="text-danger">{{ $errors->first('address_country') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="text-center">Current address</h5>
                            <hr>
                        </div>
                        <div class="col form-group mb-4">
                            <label for="verticalFormStepform-name">Same as permanent home
                                address ?</label><br>
                            <div class="form-check form-check-primary form-check-inline">
                                <input class="form-check-input" type="radio" {{ (!empty($app_data_2->same_as) && $app_data_2->same_as=='no')?'checked':'' }} name="same_as" value="no" id="form-check-radio-primary">
                                <label class="form-check-label" for="form-check-radio-primary">
                                    No
                                </label>
                            </div>
                            <div class="form-check form-check-info form-check-inline">
                                <input class="form-check-input" type="radio" name="same_as" {{ (!empty($app_data_2->same_as) && $app_data_2->same_as=='yes')?'checked':'' }} id="form-check-radio-info">
                                <label class="form-check-label" for="form-check-radio-info">
                                    Yes
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">House Number/Name and
                                    Street:</label>
                                <input type="text" name="current_house_number" value="{{ (!empty($app_data_2->current_house_number))?$app_data_2->current_house_number:old('current_house_number') }}" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Address Line
                                    2:</label>
                                <input type="text" name="current_address_line_2" value="{{ (!empty($app_data_2->current_address_line_2))?$app_data_2->current_address_line_2:old('current_address_line_2') }}" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">City/Town:</label>
                                <input name="current_city" value="{{ (!empty($app_data_2->current_city))?$app_data_2->current_city:old('current_city') }}" type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">County/State/Province:</label>
                                <input name="current_state" value="{{ (!empty($app_data_2->current_state))?$app_data_2->current_state:old('current_state') }}" type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Postal Code:</label>
                                <input name="current_postal_code" value="{{ (!empty($app_data_2->current_postal_code))?$app_data_2->current_postal_code:old('current_postal_code') }}" type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Country of permanent
                                residence:</label>
                                <select name="current_country" id="inputState" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($country_of_birth as $country2)
                                        <option {{ (!empty($app_data_2->current_country) && $app_data_2->current_country==$country2)?'selected':'' }} value="{{ $country2 }}">{{ $country2 }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="text-center">Next of Kin</h5>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Name:</label>
                                <input name="kin_name" value="{{ (!empty($app_data_2->kin_name))?$app_data_2->kin_name:old('kin_name') }}" type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Relation:</label>
                                <input name="kin_relation" value="{{ (!empty($app_data_2->kin_relation))?$app_data_2->kin_relation:old('kin_relation') }}" type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Email:</label>
                                <input name="kin_email" value="{{ (!empty($app_data_2->kin_email))?$app_data_2->kin_email:old('kin_email') }}" type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Phone No:</label>
                                <input name="kin_phone" value="{{ (!empty($app_data_2->kin_phone))?$app_data_2->kin_phone:old('kin_phone') }}" type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="button-action mt-3">
                            <a href="{{ URL::to('application-create/'.$application_id) }}" class="btn btn-secondary btn-prev me-3">Prev</a>
                            <button class="btn btn-secondary btn-nxt">Next</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

@stop
