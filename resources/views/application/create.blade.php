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

        <div class="d-none" id="wizard_Default">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Default</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="bs-stepper stepper-form-one">
                        <div class="bs-stepper-header" role="tablist">
                            <div class="step" data-target="#defaultStep-one">
                                <button type="button" class="step-trigger" role="tab">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label">Step One</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#defaultStep-two">
                                <button type="button" class="step-trigger" role="tab">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label">Step Two</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#defaultStep-three">
                                <button type="button" class="step-trigger" role="tab">
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Step Three</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <div id="defaultStep-one" class="content" role="tabpanel">
                                <form>
                                    <div class="form-group mb-4">
                                        <label for="defaultForm-name">Name</label>
                                        <input type="text" class="form-control" id="defaultForm-name">
                                    </div>
                                </form>

                                <div class="button-action mt-5">
                                    <button class="btn btn-secondary btn-prev me-3" disabled>Prev</button>
                                    <button class="btn btn-secondary btn-nxt">Next</button>
                                </div>
                            </div>
                            <div id="defaultStep-two" class="content" role="tabpanel">
                                <form>
                                    <div class="form-group mb-4">
                                        <label for="defaultEmailAddress">Email Address</label>
                                        <input type="email" class="form-control" id="defaultEmailAddress">
                                    </div>
                                </form>

                                <div class="button-action mt-5">
                                    <button class="btn btn-secondary btn-prev me-3">Prev</button>
                                    <button class="btn btn-secondary btn-nxt">Next</button>
                                </div>
                            </div>
                            <div id="defaultStep-three" class="content" role="tabpanel">
                                <form class="row g-3">
                                    <div class="col-12">
                                        <label for="defaultInputAddress" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="defaultInputAddress" placeholder="1234 Main St">
                                    </div>
                                    <div class="col-12">
                                        <label for="defaultInputAddress2" class="form-label">Address
                                            2</label>
                                        <input type="text" class="form-control" id="defaultInputAddress2" placeholder="Apartment, studio, or floor">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="defaultInputCity" class="form-label">City</label>
                                        <input type="text" class="form-control" id="defaultInputCity">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="defaultInputState" class="form-label">State</label>
                                        <select id="defaultInputState" class="form-select">
                                            <option selected="">Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="defaultInputZip" class="form-label">Zip</label>
                                        <input type="text" class="form-control" id="defaultInputZip">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="defaultGridCheck">
                                            <label class="form-check-label" for="defaultGridCheck">
                                                Check me out
                                            </label>
                                        </div>
                                    </div>
                                </form>

                                <div class="button-action mt-3">
                                    <button class="btn btn-secondary btn-prev me-3">Prev</button>
                                    <button class="btn btn-success me-3">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container bs-stepper stepper-form-vertical vertical linear mt-3">
            <div class="bs-stepper-header" role="tablist">
                <div class="step" data-target="#verticalFormStep-one">
                    <button type="button" class="step-trigger" role="tab">
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
                <div id="verticalFormStep-one" class="content" role="tabpanel">
                    <h5 class="text-center">Applicant and Course Detail</h5>
                    <hr>
                    <form>
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">Agent/ Referrel:</label>
                            <input type="text" class="form-control" id="verticalFormStepform-name" placeholder="Agent/ Referrel name">
                        </div>
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">Will Applicant fees be
                                funded by the Student Loan Company / Student Finance
                                England?</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                                <label class="custom-control-label" for="customRadioInline1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
                                <label class="custom-control-label" for="customRadioInline2">No</label>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="verticalFormStepform-name">Select one category that
                                best describes your current residential status:</label>
                            <select id="inputState" class="form-select">
                                <option selected>Choose...</option>
                                <option>UK Citizen</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Programme
                                    Group:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>Undergraduate</option>
                                    <option>Postgraduate</option>
                                </select>
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Intake:</label>
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
                                <label for="verticalFormStepform-name">Course level:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>6</option>
                                </select>
                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Entry level:</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>4</option>
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
                <div id="verticalFormStep-two" class="content" role="tabpanel">
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
                <div id="verticalFormStep-three" class="content" role="tabpanel">
                    <form class=" row g-3">
                        <h5 class="text-center">Personal Statement</h5>
                        <hr>
                        <div class="col-12">
                            <p class="text-white">A personal statement should be included here. It should be approximately 500 words. You should state why you want to undertake this course, any relevant experience, skills and attributes, and your
                                long term plans. 1 Words</p>
                            <textarea class="text-justify form-control" rows="2" cols="20" disabled="disabled" style="height: 350px; width: 100%;">  I have always believed that successful business quests are what take huma lives further and I have constantly observed this at my Managers. I have observed them manage people, make intelligent decisions and work hard to ensure that the business runs good. It has constantly motivated and intrigued me to grow and become a businesswoman myself. I also understand that the world of business management is markedly dynamic and volatile. With the conviction and willingness to toil hard to reach my career goal, I seek admission to the under graduate program in business management from the University , I have always been a hard-working student who never discounted away from carrying out my academic obligations.

                            I was very responsible for my academic performance and as such, I have always paid attention to my classes , done my homework and never flinched away from submitting my projects, and I am passing these values to my children as well. Anglia ruskin university is a very well reputed university with experienced and highly skilled staffs, which I believe will let me grow professionally and as a person. The diverse cultural exposure and the facilities of the universities is highly talked about. I have finished my diploma de Baccalaureate from Romania, which is my highest qualification currently and now I want to step higher and learn about the business world in a global and international perspective. I was always surrounded by businesspeople, which nurtured in me the entrepreneurial spirit.

                            The way I saw all these people making quick decisions, spoke to their partners and business associates , interacted with customers and clients and managed the business successfully always surprised me. This taught me to dream big and want to incept a business myself. This is what persuaded me to take International business management as a course so that I can leverage my honed managerial, communication, interpersonal and people skills to drive great success to my business when I incept the same. In order to understand more about the course, I have carried out a range of researches online which helped me realize that the course is carefully prepared to mold any aspiring student into an ardent management professional.

                            The course offers the aspirants with impeccable insights to various managerial subjects such as human resource development, principles of management, organization behavior, marketing management, managerial accounting and managerial statistics and mathematics. I am convinced that the course will definitely transform me into a capable and dynamic management professional in not time, which can help me further to follow my dream or even in a better job position achievement.
                                        </textarea>
                            <p class="text-danger">Statements will be scrutinised for plagiarism and if found plagiarised, your application may be delayed or rejected.</p>
                        </div>
                        <div class="col-12">

                        </div>
                    </form>

                    <div class="button-action mt-3">
                        <button class="btn btn-secondary btn-prev me-3">Prev</button>
                        <button class="btn btn-secondary btn-nxt">Next</button>
                    </div>
                </div>
                <div id="verticalFormStep-four" class="content" role="tabpanel">
                    <form class="row g-3">
                        <h5 class="text-center">Documents Upload</h5>
                        <hr>
                        <div class="col-12">
                            <label for="verticalFormInputAddress" class="form-label">Upload Files</label><br>
                            <button type="button" class="btn btn-primary mr-2 _effect--ripple waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Upload File
                              </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Upload Documents</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg> ... </svg>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col form-group mb-4">
                                            <label for="verticalFormStepform-name">Browse Document:</label>
                                            <input type="file" class="form-control-file" id="exampleFormControlFile1">
                                        </div>
                                        <div class="col form-group mb-4">
                                            <label for="verticalFormStepform-name">Document Type:</label>
                                            <select id="inputState" class="form-select">
                                                <option selected>Choose...</option>
                                            <option>C.V.</option>
                                            <option>English language certificate</option>
                                            <option>Highest qualification certificate</option>
                                            <option>Highest qualification transcript</option>
                                            <option>Leave to remain</option>
                                            <option>Passport</option>
                                            <option>Personal statement	</option>
                                            <option>Qualification certificate</option>
                                            <option>Qualification certificate and Transcript</option>
                                            <option>Qualification transcript</option>
                                            <option>Work reference letter</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                        <button type="button" class="btn btn-primary">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="verticalFormInputAddress" class="form-label">Attached Files</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Filename</th>
                                            <th scope="col">Detail</th>
                                            <th scope="col">Uploaded on</th>
                                            <th scope="col">File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Bachelor certificate.pdf</td>
                                            <td>Academic Certificate</td>
                                            <td>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                <span class="table-inner-text">25 Apr 2023</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-success">Open</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>

                    <div class="button-action mt-3">
                        <button class="btn btn-secondary btn-prev me-3">Prev</button>
                        <button class="btn btn-secondary btn-nxt">Next</button>
                    </div>
                </div>
                <div id="verticalFormStep-five" class="container content" role="tabpanel">
                    <h5 class="text-center mb-3">Submit Application</h5>
                    <div class="container bg-dark py-5 px-5 rounded">

                        <div id="MainContent_DV_FundedBy" class="row mb-4 px-5">
                            <div class="col">Will your fees be funded by the Student Loan Company / Student Finance England?
                                :
                            </div>
                            <div class="col"><span id="MainContent_lbl_FundedBy">Yes</span></div>
                        </div>
                        <div id="MainContent_DV_ResidentCat" class="row mb-4 px-5">
                            <div class="col">Residency Status : </div>
                            <div class="col">
                                <span id="MainContent_lbl_ResidentCat">UK Citizen - England</span>

                            </div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">EU Settlement Code : </div>
                            <div class="col"><span id="MainContent_lbl_EUSettlementCode"></span></div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Programme Group :</div>
                            <div class="col">
                                <span id="MainContent_lbl_CourseGroup">Undergraduate</span>

                            </div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Course :</div>
                            <div class="col">
                                <span id="MainContent_lbl_Course">BSc (Hons) International Business Management with Foundation
                                    Year</span>

                            </div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Intake :</div>
                            <div class="col">
                                <span id="MainContent_lbl_Intake">September 2023</span>

                            </div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Delivery Pattern :</div>
                            <div class="col">
                                <span id="MainContent_lbl_DeliveryPattern">Standard</span>

                            </div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">This programme will run on one of the following site(s) :</div>
                            <div id="MainContent_dv_sites" class="col">
                                <ul>
                                    <li>East India Building - ARU London, Import Building, 2 Clove Crescent, Poplar, London, E14
                                        2BE
                                    </li>
                                    <li>East India Building - ARU London, Export Building, 2 Clove Crescent, Poplar, London, E14
                                        2BE
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Course Level :</div>
                            <div class="col">
                                <span id="MainContent_lbl_CourseLevel">6</span>


                            </div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Entry Level :</div>
                            <div class="col">
                                <span id="MainContent_lbl_EntryLevel">4</span>

                            </div>
                        </div>

                        <div class="row mb-4 px-5">
                            <div class="col">Course fee (GBP) :</div>
                            <div class="col"><span id="MainContent_lbl_CourseFee">37000</span></div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">First year fee (GBP) :</div>
                            <div class="col"><span id="MainContent_lbl_FirstYearFee">9250</span></div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Title :</div>
                            <div class="col"><span id="MainContent_lbl_Title">Mr</span></div>
                        </div>

                        <div class="row mb-4 px-5">
                            <div class="col">Forename 1 :</div>
                            <div class="col"><span id="MainContent_lbl_FirstName">Nathaniel</span></div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Forename 2 :</div>
                            <div class="col"><span id="MainContent_lbl_Forename2">Adam</span></div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Forename 3 :</div>
                            <div class="col"><span id="MainContent_lbl_Forename3">Peter</span></div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Preferred first name :</div>
                            <div class="col"><span id="MainContent_lbl_PreferredFirstName">Nathaniel</span></div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Surname/family name :</div>
                            <div class="col"><span id="MainContent_lbl_LastName">PERKINS</span></div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Previous surname/family name at 16th birthday :</div>
                            <div class="col"><span id="MainContent_lbl_PreviousSurname"></span></div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Gender :</div>
                            <div class="col">
                                <span id="MainContent_lbl_Gender" class="LCAlblBox">Male</span>

                            </div>
                        </div>
                        <div id="MainContent_dv_email" class="row mb-4 px-5">
                            <div class="col">Email :</div>
                            <div class="col"><span id="MainContent_lbl_Email">nathamkins@gmail.com</span></div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Are you applying for advance entry (APL) :</div>
                            <div class="col"><span id="MainContent_lbl_AplyforExemption">No</span></div>
                        </div>
                        <div id="MainContent_dv_HowHearAboutUS" class="row mb-4 px-5">
                            <div class="col">How did you hear about us? :</div>
                            <div class="col"><span id="MainContent_lbl_HowHearAboutUS">No</span></div>
                        </div>
                    </div>
                    <h5 class="text-center py-3 p-3" id="MainContent_DV_HPersonalInfo">Personal Info</h5>
                    <div class="container bg-dark py-5 px-5 rounded">
                        <div id="MainContent_dv_MobileNo" class="row mb-4 px-5">
                            <div class="col">Mobile No. :</div>
                            <div class="col"><span id="MainContent_lbl_MobileNo">07424377725</span></div>
                        </div>
                        <div id="MainContent_dv_Nationality" class="row mb-4 px-5">
                            <div class="col">Nationality :</div>
                            <div class="col">
                                <span id="MainContent_lbl_Nationality">UK National</span>


                            </div>
                        </div>
                        <div id="MainContent_dv_DualNationality" class="row mb-4 px-5">
                            <div class="col">Dual Nationality :</div>
                            <div class="col">
                                <span id="MainContent_lbl_DualNationality"></span>

                            </div>
                        </div>

                        <div id="MainContent_dv_CountryOfBirth" class="row mb-4 px-5">
                            <div class="col">Country of Birth :</div>
                            <div class="col"><span id="MainContent_lbl_CountryOfBirth">United Kingdom</span>
                            </div>
                        </div>
                        <div id="MainContent_dv_EthnicOriginID" class="row mb-4 px-5">
                            <div class="col">Ethnic Origin :</div>
                            <div class="col">
                                <span id="MainContent_lbl_EthnicOriginID">Other</span>

                            </div>
                        </div>
                        <div id="MainContent_dv_DOB" class="row mb-4 px-5">
                            <div class="col">Date of Birth :</div>
                            <div class="col"><span id="MainContent_lbl_DOB">18/09/1994</span></div>
                        </div>
                        <div id="MainContent_dv_HIghestQualificationFrom" class="row mb-4 px-5">
                            <div class="col">Highest qualification on entry :</div>
                            <div class="col"><span id="MainContent_lbl_HIghestQualificationFrom">UK</span></div>
                        </div>
                        <div id="MainContent_dv_HIghestQualification" class="row mb-4 px-5">
                            <div class="col">Your Highest Qualification :</div>
                            <div class="col">
                                <span id="MainContent_lbl_HIghestQualification">Level 3 Certificate</span>

                            </div>
                        </div>
                        <div id="MainContent_dv_LastEducationalInstitution" class="row mb-4 px-5">
                            <div class="col">Your last institution :</div>
                            <div class="col">
                                <span id="MainContent_lbl_LastEducationalInstitution">UK independent school</span>

                            </div>
                        </div>
                        <div id="MainContent_dv_WhichUKInstitute" class="row mb-4 px-5">
                            <div class="col">Institution Name :</div>
                            <div class="col">
                                <span id="MainContent_lbl_WhichUKInstitute"> </span>

                            </div>
                        </div>
                        <div id="MainContent_dv_HESA_ID" class="row mb-4 px-5">
                            <div class="col">HESA reference number :</div>
                            <div class="col"><span id="MainContent_lbl_HESA_ID"></span></div>
                        </div>
                        <div id="MainContent_dv_ULN" class="row mb-4 px-5">
                            <div class="col">Unique Learner Number (ULN) :</div>
                            <div class="col"><span id="MainContent_lbl_ULN"></span></div>
                        </div>
                        <div id="MainContent_dv_QualificationOnEntry" class="row mb-4 px-5">
                            <div class="col">Name of qualification :</div>
                            <div class="col">
                                <span id="MainContent_lbl_QualificationOnEntry">Other UK qualification at Level 3</span>

                            </div>
                        </div>
                        <div id="MainContent_dv_QualificationYear" class="row mb-4 px-5">
                            <div class="col">Year achieved/obtained :</div>
                            <div class="col"><span id="MainContent_lbl_QualificationYear">2020</span></div>
                        </div>
                        <div id="MainContent_dv_QualificationSubject" class="row mb-4 px-5">
                            <div class="col">Subject :</div>
                            <div class="col"><span id="MainContent_lbl_QualificationSubject">Electrical Maintenance.
                                </span>
                            </div>
                        </div>
                        <div id="MainContent_dv_QualificationGrade" class="row mb-4 px-5">
                            <div class="col">Grade :</div>
                            <div class="col"><span id="MainContent_lbl_QualificationGrade">Pass</span></div>
                        </div>
                        <div id="MainContent_dv_PassportNo" class="row mb-4 px-5">
                            <div class="col">Passport No. :</div>
                            <div class="col"><span id="MainContent_lbl_PassportNo"></span></div>
                        </div>
                        <div id="MainContent_dv_PassportExpiree" class="row mb-4 px-5">
                            <div class="col">Passport Expiry. :</div>
                            <div class="col"><span id="MainContent_lbl_PassportExpiree"></span></div>
                        </div>
                        <div id="MainContent_dv_PassportPlaceIssuance" class="row mb-4 px-5">
                            <div class="col">Passport Place of Issuance :</div>
                            <div class="col"><span id="MainContent_lbl_PassportPlaceIssuance">UK</span></div>
                        </div>
                        <div class="row mb-4 px-5">
                            <div class="col">Care Leaver :</div>
                            <div class="col">
                                <span id="MainContent_lbl_CareLeaver">Not a care leaver</span>

                            </div>
                        </div>
                        <div id="MainContent_dv_Disablity" class="row mb-4 px-5">
                            <div class="col">Disability/special needs :</div>
                            <div class="col">
                                <span id="MainContent_lbl_Disablity">No disability</span>

                            </div>
                        </div>
                        <div id="MainContent_dv_AlradyINUK" class="row mb-4 px-5">
                            <div class="col">Currently Living in UK :</div>
                            <div class="col"><span id="MainContent_lbl_AlradyINUK"></span></div>
                        </div>
                    </div>
                    <h5 class="text-center py-3" id="MainContent_dv_HPerm">Permanent Home Address</h5>
                    <div class="container bg-dark py-5 px-5 rounded">
                        <div id="MainContent_dv_PermAdd1" class="row mb-4 px-5">
                            <div class="col">House Number/Name and Street :</div>
                            <div class="col"><span id="MainContent_lbl_PermAdd1">22A Kent House</span></div>
                        </div>
                        <div id="MainContent_dv_PermAdd2" class="row mb-4 px-5">
                            <div class="col">Address Line 2 :</div>
                            <div class="col"><span id="MainContent_lbl_PermAdd2"></span></div>
                        </div>

                        <div id="MainContent_dv_PermCity" class="row mb-4 px-5">
                            <div class="col">City/Town :</div>
                            <div class="col"><span id="MainContent_lbl_PermCity">London</span></div>
                        </div>
                        <div id="MainContent_dv_PermCounty" class="row mb-4 px-5">
                            <div class="col">County/State/Province :</div>
                            <div class="col"><span id="MainContent_lbl_PermCounty">London</span></div>
                        </div>
                        <div id="MainContent_dv_PermPostalCode" class="row mb-4 px-5">
                            <div class="col">Postal Code :</div>
                            <div class="col"><span id="MainContent_lbl_PermPostalCode">SE15EQ</span></div>
                        </div>
                        <div id="MainContent_dv_PerCountry" class="row mb-4 px-5">
                            <div class="col">Country :</div>
                            <div class="col">
                                <span id="MainContent_lbl_PerCountry">United Kingdom</span>

                            </div>
                        </div>
                        <div id="MainContent_dv_PermPhoneNo" class="row mb-4 px-5">
                            <div class="col">Phone No. :</div>
                            <div class="col"><span id="MainContent_lbl_PermPhoneNo"></span></div>
                        </div>
                        <div id="MainContent_dv_Domicile" class="row mb-4 px-5">
                            <div class="col">Country of permanent residence :</div>
                            <div class="col"><span id="MainContent_lbl_Domicile">United Kingdom</span></div>

                        </div>
                    </div>

                    <h5 class="text-center py-3" id="MainContent_dv_HCor">Current Address</h5>
                    <div class="container bg-dark py-5 px-5 rounded">
                        <div id="MainContent_dv_CorAdd1" class="row mb-4 px-5">
                            <div class="col">House Number/Name and Street :</div>
                            <div class="col"><span id="MainContent_lbl_CorAdd1">22A Kent House</span></div>
                        </div>
                        <div id="MainContent_dv_CorAdd2" class="row mb-4 px-5">
                            <div class="col">Address Line 2 :</div>
                            <div class="col"><span id="MainContent_lbl_CorAdd2"></span></div>
                        </div>

                        <div id="MainContent_dv_CorCity" class="row mb-4 px-5">
                            <div class="col">City/Town :</div>
                            <div class="col"><span id="MainContent_lbl_CorCity">London</span></div>
                        </div>
                        <div id="MainContent_dv_CorCounty" class="row mb-4 px-5">
                            <div class="col">County/State/Province :</div>
                            <div class="col"><span id="MainContent_lbl_CorCounty">London</span></div>
                        </div>
                        <div id="MainContent_dv_CorPostalCode" class="row mb-4 px-5">
                            <div class="col">Postal Code :</div>
                            <div class="col"><span id="MainContent_lbl_CorPostalCode">SE15EQ</span></div>
                        </div>
                        <div id="MainContent_dv_CorCountry" class="row mb-4 px-5">
                            <div class="col">Country :</div>
                            <div class="col">
                                <span id="MainContent_lbl_CorCountry">United Kingdom</span>

                            </div>
                        </div>
                        <div id="MainContent_dv_CorPhoneNo" class="row mb-4 px-5">
                            <div class="col">Phone No. :</div>
                            <div class="col"><span id="MainContent_lbl_CorPhoneNo"></span></div>
                        </div>
                    </div>
                    <h5 class="text-center py-3" id="MainContent_dv_NextToKin">Next of Kin</h5>
                    <div class="container bg-dark py-5 px-5 rounded">
                        <div id="MainContent_dv_NextToKinName" class="row mb-4 px-5">
                            <div class="col">Name :</div>
                            <div class="col"><span id="MainContent_lbl_NextToKinName"></span></div>
                        </div>
                        <div id="MainContent_dv_NextToKinRelation" class="row mb-4 px-5">
                            <div class="col">Relation :</div>
                            <div class="col"><span id="MainContent_lbl_NextToKinRelation"></span></div>
                        </div>
                        <div id="MainContent_dv_NextToKinHPhoneNo" class="row mb-4 px-5">
                            <div class="col">Phone No :</div>
                            <div class="col"><span id="MainContent_lbl_NextToKinHPhoneNo"></span></div>
                        </div>
                        <div id="MainContent_dv_NextToKinEmail" class="row mb-4 px-5">
                            <div class="col">Email :</div>
                            <div class="col"><span id="MainContent_lbl_NextToKinEmail"></span></div>
                        </div>
                    </div>
                    <h5 class="text-center py-3" id="MainContent_dv_HPersonalStatement">Personal Statement</h5>
                    <div class="container bg-dark py-5 px-5 rounded">
                        <div id="MainContent_dv_PersonalStatement" class="row mb-4 px-5">
                            <div class="col"><span id="MainContent_lbl_Other_PersonalStatement"> As someone with a Level 3
                                    Certificate in Electrical Maintenance, I have gained a valuable foundation of technical
                                    knowledge and practical skills that I believe will be highly relevant to my studies in BSc
                                    (Hons) International Business Management at ARU London. Through my education and work
                                    experience, I have developed a range of transferable skills that I believe will enable me to
                                    succeed in a variety of professional settings.My interest in business and management has
                                    grown
                                    over time, and I am excited about the opportunity to explore this field in greater depth
                                    through
                                    my studies at ARU London. I am particularly interested in international business, as I
                                    believe
                                    that the global economy presents a wealth of opportunities and challenges that will require
                                    a
                                    deep understanding of different cultures, customs, and business practices.In addition to my
                                    technical knowledge and practical skills, I have also developed a range of soft skills that
                                    I
                                    believe will be highly relevant to my studies in International Business Management. These
                                    include effective communication, problem-solving, and teamwork. As an electrical maintenance
                                    technician, I was required to work closely with clients, suppliers, and colleagues to ensure
                                    that projects were completed on time and to a high standard of quality. This experience has
                                    taught me how to effectively communicate with a diverse range of stakeholders and to build
                                    strong relationships based on trust and mutual respect.Furthermore, my work in electrical
                                    maintenance has taught me how to solve complex problems, think critically, and adapt to
                                    changing
                                    situations. These skills will be highly valuable in a business context, where I will need to
                                    identify and address complex challenges effectively.Overall, I am excited about the
                                    opportunity
                                    to apply my technical knowledge and practical skills, as well as my soft skills in
                                    communication, problem-solving, and teamwork, to my studies in International Business
                                    Management
                                    at ARU London. I am confident that my passion for business and management, coupled with my
                                    diverse range of skills and experiences, will enable me to make meaningful contributions to
                                    the
                                    program and achieve success in my future career. I look forward to the challenges and
                                    opportunities that lie ahead, and I am committed to working hard to achieve my goals.</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center py-3" id="MainContent_dv_AttachedFiles">Attached Files</h5>
                    <div class="container bg-dark py-5 px-5 rounded">
                        <div id="MainContent_dv_GridView4" class="row mb-4 px-5">
                            <div class="col">
                                <div class="text-white">
                                    <table class="text-white table" cellspacing="0" rules="all" border="1"
                                        id="MainContent_GridView4" style="border-collapse:collapse;">
                                        <tbody class="text-center">
                                            <tr class="">
                                                <th class="LCAHidden" scope="col">ID</th>
                                                <th class="LCAHidden" scope="col">Applicant ID</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Detail</th>
                                                <th scope="col">Uploaded On</th>
                                            </tr>
                                            <tr>
                                                <td class="LCAHidden">775331</td>
                                                <td class="LCAHidden">13257442</td>
                                                <td>001_level 3.pdf</td>
                                                <td>&nbsp;</td>
                                                <td>10/05/2023 16:37:06</td>
                                            </tr>
                                            <tr>
                                                <td class="LCAHidden">775333</td>
                                                <td class="LCAHidden">13257442</td>
                                                <td>002_NathanielPeterCV.pdf</td>
                                                <td>&nbsp;</td>
                                                <td>10/05/2023 16:37:15</td>
                                            </tr>
                                            <tr>
                                                <td class="LCAHidden">775335</td>
                                                <td class="LCAHidden">13257442</td>
                                                <td>003_passport.jpg</td>
                                                <td>&nbsp;</td>
                                                <td>10/05/2023 16:37:46</td>
                                            </tr>
                                            <tr>
                                                <td class="LCAHidden">775337</td>
                                                <td class="LCAHidden">13257442</td>
                                                <td>004_ARUApplication.pdf</td>
                                                <td>Submited Application</td>
                                                <td>10/05/2023 16:39:38</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center py-3" id="MainContent_dv_HDeclaration_Text">Declaration<span style="color: Red;">
                            *</span></h5>
                    <div class="container bg-dark py-5 px-5 rounded ">
                        <div id="MainContent_dv_Declaration_Text" class="row mb-4 px-5">
                            <div class="col">
                                <p id="MainContent_Declaration_Text" class="text-white">
                                    I agree to <span id="MainContent_UniLongName">Anglia Ruskin University London</span> (<span
                                        id="MainContent_UniAbbriv1">ARUL</span>) processing personal data contained in this
                                    form or
                                    other data
                                    which <span id="MainContent_UniAbbriv2">ARUL</span> may obtain from other people. I agree
                                    to
                                    the processing of such data for any purposes connected with my
                                    studies or my health and safety whilst on the premises or for any legitimate reason
                                    including
                                    communication with me
                                    following the completion of my studies. In addition, I agree to <span
                                        id="MainContent_UniAbbriv3">ARUL</span> processing personal data described as Special
                                    Category Data as defined under the General Data Protection Regulation, such processing to be
                                    undertaken for any
                                    purposes as indicated in the declaration above. In addition to the Privacy Notice linked to
                                    this
                                    form please also
                                    see our Corporate Privacy Policy on our website -
                                    <a href="https://www.anglia.ac.uk/privacy-and-cookies" target="_blank">
                                        <font style="color: Blue; text-decoration: underline;">
                                            https://www.anglia.ac.uk/privacy-and-cookies</font>
                                    </a>.
                                </p>
                            </div>
                        </div>
                        <div id="MainContent_dv_Declaration_cb1_IAcceptStatement" class="row mb-4 px-5 ">
                            <div class="col">
                                <span class="aspNetDisabled" style="margin: 0;">
                                <input class="checkbox "
                                    id="MainContent_Declaration_cb1_IAcceptStatement" type="checkbox"
                                    name="ctl00$MainContent$Declaration_cb1_IAcceptStatement" checked="checked"
                                    disabled="disabled">
                                    <label class="text-white" for="MainContent_Declaration_cb1_IAcceptStatement">I
                                    understand
                                    and accept this statement</label>
                                </span>
                            </div>
                        </div>
                        <div id="MainContent_dv_Declaration_cb2_ICertifyInfoTrue" class="row mb-4 px-5 chkICertifyInfoTrue">
                            <div class="col"><span class="aspNetDisabled" style="margin: 0;"><input class="checkbox"
                                        id="MainContent_Declaration_cb2_ICertifyInfoTrue" type="checkbox"
                                        name="ctl00$MainContent$Declaration_cb2_ICertifyInfoTrue" checked="checked"
                                        disabled="disabled">
                                        <label class="text-white" for="MainContent_Declaration_cb2_ICertifyInfoTrue">I
                                        confirm
                                        that the information I have provided on this application is true, complete and
                                        accurate</label></span></div>
                        </div>
                        <div id="MainContent_dv_Declaration_cb3_ICertifyQualification"
                            class="row mb-4 px-5 chkICertifyQualification">
                            <div class="col"><span class="aspNetDisabled" style="margin: 0;"><input class="checkbox"
                                        id="MainContent_Declaration_cb3_ICertifyQualification" type="checkbox"
                                        name="ctl00$MainContent$Declaration_cb3_ICertifyQualification" checked="checked"
                                        disabled="disabled">
                                        <label class="text-white" for="MainContent_Declaration_cb3_ICertifyQualification">I
                                        confirm that have I have declared all previous study and have listed my highest
                                        qualification</label></span></div>
                        </div>
                        <div id="MainContent_DV_Signed" class="row mb-4 px-5">
                            <div class="col">Signed And Submitted By :</div>
                            <div class="col"><span id="MainContent_lbl_Signed">Nathaniel</span></div>
                        </div>
                        <div id="MainContent_Div1" class="row mb-4 px-5">
                            <div class="col">Dated :</div>
                            <div class="col"><span id="MainContent_lbl_Dated">10/05/2023 16:39:36</span></div>
                        </div>
                    </div>

                    <div class="button-action mt-3 ms-3">
                        <button class="btn btn-secondary btn-prev me-3">Back</button>
                        <button class="btn btn-success btn-nxt me-3">Submit</button>
                        <button class="btn btn-warning">Download PDF</button>
                    </div>
                </div>
                <div id="verticalFormStep-Six" class="content" role="tabpanel">
                    <h5 class="text-center">Interview / ELPT</h5>
                    <form class="row g-3">
                        <div class="col-6">
                            <label for="verticalFormInputAddress" class="form-label">Inteview Date :</label>
                            <input type="date" class="form-control" id="verticalFormInputAddress">
                        </div>
                        <div class="col-6">
                            <label for="verticalFormInputAddress2" class="form-label">Interview Time :</label>
                            <input type="time" class="form-control" id="verticalFormInputAddress2" placeholder="Apartment, studio, or floor">
                        </div>
                        <div class="col-md-6">
                            <label for="verticalFormStepInputCity" class="form-label">Results :</label>
                            <input type="text" class="form-control" id="verticalFormStepInputCity">
                        </div>
                        <div class="col-md-6">
                            <label for="verticalFormStepInputState" class="form-label">No Show :</label>
                            <select id="verticalFormStepInputState" class="form-select">
                                <option selected="">Choose...</option>
                                <option>No</option>
                                <option>Yes</option>
                            </select>
                        </div>
                    </form>

                    <div class="button-action mt-3">
                        <button class="btn btn-secondary btn-prev me-3">Prev</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@stop
