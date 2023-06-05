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
                <div class="step active" data-target="#verticalFormStep-four">
                    <button type="button" class="step-trigger active" role="tab">
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
                <div id="verticalFormStep-four" class="content fade dstepper-block active" role="tabpanel">
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
            </div>

        </div>
    </div>

</div>

@stop
