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
                                <input value="{{ (!empty($app_data->ni_number))?$app_data->ni_number:old('ni_number') }}" type="text" name="ni_number" class="form-control" id="verticalFormStepform-name">
                                @if ($errors->has('ni_number'))
                                    <span class="text-danger">{{ $errors->first('ni_number') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">NI Number:</label>
                                <input value="{{ (!empty($app_data->ni_number))?$app_data->ni_number:old('ni_number') }}" type="text" name="ni_number" class="form-control" id="verticalFormStepform-name">
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
                            <h5 class="text-center">Term Time Address</h5>
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
                            <div class="col-6 form-group mb-4">
                                <label for="verticalFormStepform-name">Nationality*:</label>
                                <select name="nationality" id="nationality" class="form-select" onchange="change_nationality()">
                                    <option value="">Choose...</option>
                                    <option value="UK National">UK National</option>
                                    <option value="Other">Other Nationality</option>
                                </select>
                                @if ($errors->has('nationality'))
                                    <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                @endif
                            </div>
                        </div>
                        <div id="national-other-id" class="national-other-select">
                            <div class="row">
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
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Visa Category:</label>
                                    <div class="input-group mb-3">
                                        <select name="visa_category" id="visa_category" class="form-select">
                                            <option value="">Choose...</option>
                                            @foreach ($visa_category as $vrow)
                                                <option {{ (!empty($app_data_1->visa_category) && $app_data_1->visa_category==$vrow)?'selected':'' }} value="{{ $vrow }}">{{ $vrow }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Date Entry Of UK:</label>
                                    <input name="date_entry_of_uk" value="{{ (!empty($app_data_2->date_entry_of_uk))?$app_data_2->date_entry_of_uk:old('date_entry_of_uk') }}" type="datetime-local" class="form-control" id="verticalFormStepform-name">
                                    @if ($errors->has('date_entry_of_uk'))
                                        <span class="text-danger">{{ $errors->first('date_entry_of_uk') }}</span>
                                    @endif
                                </div>
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Select Campus:</label>
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
                            @if(!empty($app_data->course_id))
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Course:</label>
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
                                <label for="verticalFormStepform-name">Course:</label>
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
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Course fee
                                    (GBP) Per Year (Local):</label>
                                <input type="text" value="{{ (!empty($app_data->local_course_fee))?$app_data->local_course_fee:old('local_course_fee') }}" class="course-fee-local-data form-control" id="local_course_fee" name="local_course_fee" placeholder="">
                                @if ($errors->has('local_course_fee'))
                                    <span class="text-danger">{{ $errors->first('local_course_fee') }}</span>
                                @endif
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Course fee
                                    (GBP) Per Year (International):</label>
                                <input value="{{ (!empty($app_data->international_course_fee))?$app_data->international_course_fee:old('international_course_fee') }}" type="text" class="form-control" id="course_fee_international" name="international_course_fee" placeholder="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label style="display: flex;" for="verticalFormStepform-name">Intake: <div id="course_intake"></div></label>
                                <select name="intake" id="inputState" class="form-select">
                                    <option value="">Choose...</option>
                                    @foreach ($intakes as $irow)
                                    <option {{ (!empty($app_data->intake) && $app_data->intake==$irow['val'])?'selected':'' }} value="{{ $irow['val'] }}">{{ $irow['string'] }}</option>
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
                                    <option {{ (!empty($app_data->delivery_pattern) && $app_data->delivery_pattern==$pattern['id'])?'selected':'' }} value="{{ $pattern['id'] }}">{{ $pattern['val'] }}</option>
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
<style>
    .national-other-select{
        display: none;
    }
</style>
@stop
