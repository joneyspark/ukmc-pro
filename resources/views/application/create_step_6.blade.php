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
                <div class="step crossed" data-target="#verticalFormStep-two">
                    <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">Step Two</span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step crossed" data-target="#verticalFormStep-three">
                    <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Three</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step crossed" data-target="#verticalFormStep-four">
                    <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">4</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Four</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step crossed" data-target="#verticalFormStep-five">
                    <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">5</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Five</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step active" data-target="#verticalFormStep-Six">
                    <button type="button" class="step-trigger active" role="tab">
                        <span class="bs-stepper-circle">6</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Final Step</span>
                        </span>
                    </button>
                </div>
            </div>

            <div class="bs-stepper-content">
                <div id="verticalFormStep-Six" class="content fade dstepper-block active" role="tabpanel">
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
