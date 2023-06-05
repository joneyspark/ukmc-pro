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
    <div class="row" id="cancel-row">
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
                    <form>
                        @if(Auth::check() && Auth::user()->role=='admin')
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">Agent/Company/Referral:</label>
                            <select id="company_id" class="form-select">
                                <option selected>Choose...</option>
                                @foreach ($a_company_data as $crow)
                                <option value="{{ $crow->id }}">{{ $crow->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">Will Applicant fees be
                                funded by the Student Loan Company / Student Finance
                                England?</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="is_applicant_fees_be_funded" value="yes" class="custom-control-input">
                                <label class="custom-control-label" for="customRadioInline1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="is_applicant_fees_be_funded" value="no" class="custom-control-input">
                                <label class="custom-control-label" for="customRadioInline2">No</label>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">Select one category that
                                best describes your current residential status:</label>
                            <select id="inputState" name="residential_status" class="form-select">
                                <option selected>Choose...</option>
                                <option value="UK Citizen">UK Citizen</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Select Campus1:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    @foreach ($a_campuses_data as $cdata)
                                    <option value="{{ $cdata->id }}">{{ $cdata->campus_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Course1:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    
                                    
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Select Campus2:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    @foreach ($a_campuses_data as $cdata)
                                    <option value="{{ $cdata->id }}">{{ $cdata->campus_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Course2:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>May 2023</option>
                                    <option>Sep 2023</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Programme:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>BSc (Hons) Business</option>
                                    <option>MSc in Computer Science</option>
                                </select>
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Intake:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    @foreach ($intakes as $irow)
                                    <option value="{{ $irow['val'] }}">{{ $irow['string'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Course level:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>6</option>
                                </select>
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Delivery
                                    Pattern:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>Evening and Weekend</option>
                                    <option>Standard</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Course fee
                                    (GBP):</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name" placeholder="">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">First year fee
                                    (GBP):</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name" placeholder="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 form-group mb-4">
                                <label for="verticalFormStepform-name">Title:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>Mr</option>
                                    <option>Mrs</option>
                                    <option>Miss</option>
                                    <option>Ms</option>
                                </select>
                            </div>
                            <div class="col-5 form-group mb-4">
                                <label for="verticalFormStepform-name">First name:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name" placeholder="">
                            </div>
                            <div class="col-5 form-group mb-4">
                                <label for="verticalFormStepform-name">Last name:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name" placeholder="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Gender:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Date of
                                    Birth:</label>
                                <input type="date" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Email:</label>
                                <input type="email" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Confirm
                                    Email:</label>
                                <input type="email" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Are you applying for
                                    advanced entry (APL):</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="customCheck1">
                                    <label class="form-check-label" for="customCheck1">Accreditation of prior learning
                                        (APL) relates to learning from the past that can be
                                        credited against your desired qualification</label>
                                </div>
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Are you applying for
                                    advanced entry (APL):</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>Website</option>
                                    <option>Facebook</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="button-action mt-3">
                        <button class="btn btn-secondary btn-prev me-3" disabled>Prev</button>
                        <button class="btn btn-secondary btn-nxt">Next</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@stop
