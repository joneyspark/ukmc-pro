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
                    <form>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepEmailAddress">Mobile No.
                                    :</label>
                                <input type="text" class="form-control" id="verticalFormStepEmailAddress" placeholder="">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Nationality:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>Bangladeshi</option>
                                    <option>British</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Other
                                    Nationality:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                    </div>
                                    <select id="inputState" class="form-select">
                                        <option selected>Choose...</option>
                                        <option>Bangladeshi</option>
                                        <option>British</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepEmailAddress">Ethnic
                                    Origin:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>Black</option>
                                    <option>White</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Country of
                                    Birth:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>Bangladesh</option>
                                    <option>London</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">Highest qualification on
                                entry:</label>
                            <div class="div">
                                <div class="form-check form-check-primary form-check-inline">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="form-check-radio-primary" checked="">
                                    <label class="form-check-label" for="form-check-radio-primary">
                                        UK
                                    </label>
                                </div>

                                <div class="form-check form-check-info form-check-inline">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="form-check-radio-info">
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
                                highest qualification from the list:</label>
                            <select id="inputState" class="form-select">
                                <option selected>Choose...</option>
                                <option value="1">Qualification below GCSE</option>
                                <option value="2">GCSE or Level 2 qualification</option>
                                <option value="3">Level 3 Diploma</option>
                                <option value="4">Level 3 Certificate</option>
                                <option value="5">Level 3 Award</option>
                                <option value="6">A/AS Level(s)</option>
                                <option value="7">Scottish Baccalaureate</option>
                                <option value="8">Scottish Highers/Advanced Highers</option>
                                <option selected="selected" value="9">International
                                    Baccalaureate (IB) Diploma</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">When you start this
                                course what will the last institution you attended
                                be?</label>
                            <select id="inputState" class="form-select">
                                <option selected>Choose...</option>
                                <option value="1">Any Non UK Institution</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">Unique Learner Number
                                (ULN):</label>
                            <input type="text" class="form-control" id="verticalFormStepform-name">
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Name of
                                    qualification:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Year
                                    achieved/obtained:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Subject:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Grade:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Passport No:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Passport Expiry
                                    :</label>
                                <input type="date" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Passport Place of
                                    Issuance:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Have you spent any
                                    time in public care up to the age of 18? </label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Disability/special
                                    needs</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="text-center">Permanent home address</h5>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">House Number/Name and
                                    Street:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Address Line
                                    2:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">City/Town:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">County/State/Province:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Postal Code:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Country of permanent
                                    residence:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
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
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="form-check-radio-primary" checked="">
                                <label class="form-check-label" for="form-check-radio-primary">
                                    No
                                </label>
                            </div>
                            <div class="form-check form-check-info form-check-inline">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="form-check-radio-info">
                                <label class="form-check-label" for="form-check-radio-info">
                                    Yes
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">House Number/Name and
                                    Street:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Address Line
                                    2:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">City/Town:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">County/State/Province:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Postal Code:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Country of permanent
                                    residence:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="text-center">Next of Kin</h5>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Name:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Relation:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Email:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Phone No:</label>
                                <input type="text" class="form-control" id="verticalFormStepform-name">
                            </div>
                        </div>
                    </form>

                    <div class="button-action mt-3">
                        <button class="btn btn-secondary btn-prev me-3">Prev</button>
                        <button class="btn btn-secondary btn-nxt">Next</button>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

@stop
