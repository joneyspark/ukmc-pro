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
                                <li class="breadcrumb-item active" aria-current="page">Create Step 4</li>
                            </ol>
                        </nav>

                    </div>
                </div>
            </header>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade inputForm-modal" id="inputFormModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-header" id="inputFormModalLabel">
                <h5 class="modal-title"><b>Request Documents</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
            </div>
            <form method="post" action="{{ URL::to('request-document-message') }}" class="mt-0">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="set_application_id" value="{{ (!empty($application_id))?$application_id:'' }}" />
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Request Document Note:</label>
                                <textarea name="message" class="form-control" rows="2"></textarea>
                                @if ($errors->has('message'))
                                    <span class="text-danger">{{ $errors->first('message') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-no-effect">Submit</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ URL::to('step-4-post') }}" enctype="multipart/form-data">
                    @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Documents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg> ... </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="application_id" value="{{ (!empty($application_id))?$application_id:'' }}" />
                    <div class="col form-group mb-4">
                        <label for="verticalFormStepform-name">Browse Document:</label>
                        <input name="doc" type="file" class="form-control-file" id="exampleFormControlFile1">
                        @if ($errors->has('doc'))
                            <span class="text-danger">{{ $errors->first('doc') }}</span>
                        @endif
                    </div>
                    <div class="col form-group mb-4">
                        <label for="verticalFormStepform-name">Document Type:</label>
                        @if($application_data->is_academic==1)
                        <select name="document_type" id="inputState" class="form-select">
                            <option value="">Choose...</option>
                            <option value="Passport">Passport</option>
                            <option value="Proof of Address">Proof of Address</option>
                            <option value="Residency">Residency</option>
                            <option value="SOP">SOP</option>
                            <option value="Qualification transcript">Qualification transcript</option>
                            <option value="Work reference letter">Work reference letter</option>
                            </select>
                        @endif
                        @if($application_data->is_academic==2)
                        <select name="document_type" id="inputState" class="form-select">
                            <option value="">Choose...</option>
                            <option value="CV">CV</option>
                            <option value="Essay">Essay</option>
                            </select>
                        @endif
                        @if ($errors->has('document_type'))
                            <span class="text-danger">{{ $errors->first('document_type') }}</span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
            </div>
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
                            <div class="col form-group mb-4">
                                <input type="hidden" id="get_application_id" name="get_application_id" value="{{ (!empty($application_id))?$application_id:'' }}" />
                                <label for="verticalFormStepform-name">Level Of Education:</label>
                                <select name="level_of_education" id="level_of_education" class="form-select" onchange="getAcademicData()">
                                <option {{ (!empty($application_data->is_academic) && $application_data->is_academic==1)?'selected':'' }} value="1">Academic Route (Level 3 Diploma/Equivalent Qualification)</option>
                                <option {{ (!empty($application_data->is_academic) && $application_data->is_academic==2)?'selected':'' }} value="2">Non-Academic Route (Minimum 2 years work Experience)</option>
                                </select>

                            </div>
                            <div class="col form-group mb-4">
                                <label for="verticalFormStepform-name">Academic or Non-Academic:</label>
                                <select disabled name="document_type" id="inputState" class="form-select">
                                <option value="">Choose...</option>
                                <option {{ (!empty($application_data->is_academic) && $application_data->is_academic==1)?'selected':'' }} value="1">Academic</option>
                                <option {{ (!empty($application_data->is_academic) && $application_data->is_academic==2)?'selected':'' }} value="2">Non-Academic</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="verticalFormInputAddress" class="form-label">Upload Files</label><br>
                            <button type="button" class="btn btn-primary mr-2 _effect--ripple waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Upload File
                              </button>
                        </div>

                        <div class="col-12">
                            <label for="verticalFormInputAddress" class="form-label">Attached Files</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Filename</th>
                                            <th scope="col">Uploaded on</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($application_documents as $doc)
                                        <tr>
                                            <td>{{ $doc->document_type }}</td>
                                            <td>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                <span class="table-inner-text">{{ date('F d Y',strtotime($doc->created_at)) }}</span>
                                            </td>
                                            <td>
                                                <a download href="{{ asset($doc->doc) }}"><span class="badge badge-light-success">Download</span></a>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>No Data Found</tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    @if(Auth::user()->role=='agent' && count($requested_documents) > 0)
                    <div class="row">
                        <h5>Requested Document</h5>
                        <table class="table table-responsive">
                            <tr>
                                <td>Title</td>
                                <td>Request By</td>
                                <td>Action</td>
                            </tr>
                            @foreach($requested_documents as $drow)
                            <tr>
                                <td>{{ (!empty($drow->message))?$drow->message:'' }}</td>
                                <td>{{ (!empty($drow->document_by->name))?$drow->document_by->name:'' }}</td>
                                <td>
                                    <a href="javascript:void(0)" onclick="if(confirm('Are you sure to Confirm this Document Data?')) location.href='{{ URL::to('confirm-request-document/'.$drow->id) }}'; return false;"><span class="badge badge-light-warning">Confirm</span></a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif
                    <!-- academic or nonacademic check -->
                    @if($application_data->is_academic==1)
                    <div class="row">
                        <h5>Create</h5>
                        <form class="form">
                            <div class="row">
                                <input type="hidden" id="get_application_id" name="get_application_id" value="{{ (!empty($application_id))?$application_id:'' }}" />
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Name of Qualifications:</label>
                                    <input class="form-control" type="text" id="get_application_id" name="name_of_qualification" value="" />
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Name of Institution:</label>
                                    <input class="form-control" type="text" id="get_application_id" name="name_of_institution" value="" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Awarding Organization:</label>
                                    <input class="form-control" type="text" id="get_application_id" name="awarding_organization" value="" />
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Grade:</label>
                                    <input class="form-control" type="text" id="grade" name="grade" value="" />
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Year of Completion:</label>
                                    <input class="form-control" type="datetime-local" id="year_of_completion" name="year_of_completion" value="" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary btn-nxt">Submit</button>
                        </form><hr>
                        <h5>Qualification List</h5>
                        <table class="table table-responsive">
                            <tr>
                                <td>Name of Qualifications</td>
                                <td>Name of Institution</td>
                                <td>Awarding Organization</td>
                                <td>Grade</td>
                                <td>Year of Completion</td>
                            </tr>
                            
                        </table>
                    </div>
                    @endif
                    @if($application_data->is_academic==2)
                    <div class="row">
                        <h5>Job Create</h5>
                        <form class="form">
                            <div class="row">
                                <input type="hidden" id="get_application_id" name="get_application_id" value="{{ (!empty($application_id))?$application_id:'' }}" />
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Job Title:</label>
                                    <input class="form-control" type="text" id="job_title" name="job_title" value="" />
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Employer Name:</label>
                                    <input class="form-control" type="text" id="employer_name" name="employer_name" value="" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Start Date:</label>
                                    <input class="form-control" type="datetime-local" id="start_date" name="start_date" value="" />
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">End Date:</label>
                                    <input class="form-control" type="datetime-local" id="end_date" name="end_date" value="" />
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Year of Completion:</label>
                                    <input class="form-control" type="datetime-local" id="year_of_completion" name="year_of_completion" value="" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary btn-nxt">Submit</button>
                        </form><hr>
                        <h5>Qualification List</h5>
                        <table class="table table-responsive">
                            <tr>
                                <td>Name of Qualifications</td>
                                <td>Name of Institution</td>
                                <td>Awarding Organization</td>
                                <td>Grade</td>
                                <td>Year of Completion</td>
                            </tr>
                            
                        </table>
                    </div>
                    @endif
                    @if(Auth::user()->role=='student')
                        @if(!empty($application_data) && $application_data->application_status_id==1)
                        <a href="{{ URL::to('student-portal') }}" class="btn btn-secondary btn-nxt">My Applications</a>
                        @else
                        <div class="button-action mt-3">
                            <a href="{{ URL::to('application-create/'.$application_id.'/step-3') }}" class="btn btn-secondary btn-prev me-3">Prev</a>
                            @if($document_count > 1)
                            <a href="{{ URL::to('application-create/'.$application_id.'/step-5') }}" class="btn btn-secondary btn-nxt">Next</a>
                            @else
                            <button disabled class="btn btn-secondary btn-nxt">Next</button>
                            @endif
                        </div>
                        @endif
                    @endif
                    @if(Auth::user()->role=='agent')
                        @if(!empty($application_data) && $application_data->application_status_id==1)
                        <a href="{{ URL::to('agent-applications') }}" class="btn btn-secondary btn-nxt">Agent Applications</a>
                        @else
                        <div class="button-action mt-3">
                            <a href="{{ URL::to('application-create/'.$application_id.'/step-3') }}" class="btn btn-secondary btn-prev me-3">Prev</a>
                            @if($document_count > 1)
                            <a href="{{ URL::to('application-create/'.$application_id.'/step-5') }}" class="btn btn-secondary btn-nxt">Next</a>
                            @else
                            <button disabled class="btn btn-secondary btn-nxt">Next</button>
                            @endif
                        </div>
                        @endif
                    @endif
                    @if(Auth::user()->role=='adminManager' || Auth::user()->role=='admin')
                    <div class="button-action mt-3">
                        <a href="{{ URL::to('application-create/'.$application_id.'/step-3') }}" class="btn btn-secondary btn-prev me-3">Prev</a>
                        @if($document_count > 1)
                        <a href="{{ URL::to('application-create/'.$application_id.'/step-5') }}" class="btn btn-secondary btn-nxt">Next</a>
                        @else
                        <button disabled class="btn btn-secondary btn-nxt">Next</button>
                        @endif
                        <a data-bs-toggle="modal" data-bs-target="#inputFormModal" class="btn btn-warning btn-nxt">Request For Document</a>
                    </div>
                    @endif

                    @if(Auth::user()->role=='student')
                    <div class="button-action mt-3">
                        <a href="{{ URL::to('application-create/'.$application_id.'/step-3') }}" class="btn btn-secondary btn-prev me-3">Prev</a>
                        @if($document_count > 2)
                        <a href="{{ URL::to('application-create/'.$application_id.'/step-5') }}" class="btn btn-secondary btn-nxt">Next</a>
                        @else
                        <button disabled class="btn btn-secondary btn-nxt">Next</button>
                        @endif
                    </div>
                    @endif

                </div><br>
            </div>
        </div>
    </div>

</div>
@if($errors->any())
<script src="{{ asset('web/js/jquery.js') }}"></script>
    @if($errors->has('document_type') || $errors->has('doc'))
    <script>
        $(document).ready(function() {
            $('#exampleModal').modal('show');
        });
    </script>
    @endif
    @if($errors->has('message'))
    <script>
        $(document).ready(function() {
            $('#inputFormModal').modal('show');
        });
    </script>
    @endif
@endif
@stop
