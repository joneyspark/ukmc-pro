@extends('adminpanel')
@section('admin')
<!-- Modal -->
<style>
    #download_doc{
        display: none;
    }
</style>
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
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Subject:</label>
                            <input type="text" name="subject" class="form-control" rows="2">
                            @if ($errors->has('subject'))
                                <span class="text-danger">{{ $errors->first('subject') }}</span>
                            @endif
                        </div>
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
{{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <select name="document_type" id="document_type" class="form-select" onchange="getTitle()">
                        <option value="">Choose...</option>
                        <option value="Passport">Passport</option>
                        <option value="Proof of Address">Proof of Address</option>
                        <option value="Residency">Residency</option>
                        <option value="SOP">SOP</option>
                        <option value="Qualification transcript">Qualification transcript</option>
                        <option value="Additional Documents">Additional Documents</option>
                        <option value="Other">Other</option>
                        </select>
                    @endif
                    @if($application_data->is_academic==2)
                    <select name="document_type" id="document_type" class="form-select" onchange="getTitle()">
                        <option value="">Choose...</option>
                        <option value="Passport">Passport</option>
                        <option value="SOP">SOP</option>
                        <option value="Residency">Residency</option>
                        <option value="Proof of Address">Proof of Address</option>
                        <option value="CV">CV</option>
                        <option value="Essay">Essay</option>
                        <option value="Additional Documents">Additional Documents</option>
                        <option value="Other">Other</option>
                        </select>
                    @endif
                    @if ($errors->has('document_type'))
                        <span class="text-danger">{{ $errors->first('document_type') }}</span>
                    @endif
                </div>
                <div id="show_title" class="col form-group mb-4">
                    <input name="title" placeholder="Title" type="text" class="form-control" id="exampleFormControlFile1">
                </div>
                <div class="col form-group mb-4">
                    <label for="verticalFormStepform-name">Upload Date:</label>
                    <input name="create_date" type="datetime-local" class="form-control" id="exampleFormControlFile1">
                </div>
                @if(Auth::check())
                    @if(Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->role=='adminManager' || Auth::user()->role=='interviewer')
                    <div class="col form-group mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_view" value="1" id="flexRadioDefault1" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                                View By All
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_view" value="2" id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                View By UKMC
                            </label>
                        </div>
                    </div>
                    @endif
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
        </div>
    </div>
</div> --}}
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
                <input type="hidden" name="document_id" id="document_id" value="" />
                <div class="col form-group mb-4">
                    <label for="verticalFormStepform-name">Browse Document:</label>
                    <input name="doc" type="file" class="form-control-file" id="exampleFormControlFile1">
                    <a id="download_doc" href="">Download Document</a>
                </div>
                <div class="col form-group mb-4">
                    <label for="verticalFormStepform-name">Document Type:</label>
                    @if($application_data->is_academic==1)
                    <select name="document_type" id="get_document_type" class="form-select" onchange="getTitle()">
                        <option value="">Choose...</option>
                        <option value="Passport">Passport</option>
                        <option value="Proof of Address">Proof of Address</option>
                        <option value="Residency">Residency</option>
                        <option value="SOP">SOP</option>
                        <option value="Qualification transcript">Qualification transcript</option>
                        <option value="Additional Documents">Additional Documents</option>
                        <option value="Other">Other</option>
                        </select>
                    @endif
                    @if($application_data->is_academic==2)
                    <select name="document_type" id="get_document_type" class="form-select" onchange="getTitle()">
                        <option value="">Choose...</option>
                        <option value="Passport">Passport</option>
                        <option value="SOP">SOP</option>
                        <option value="Residency">Residency</option>
                        <option value="Proof of Address">Proof of Address</option>
                        <option value="CV">CV</option>
                        <option value="Essay">Essay</option>
                        <option value="Additional Documents">Additional Documents</option>
                        <option value="Other">Other</option>
                        </select>
                    @endif
                    @if ($errors->has('document_type'))
                        <span class="text-danger">{{ $errors->first('document_type') }}</span>
                    @endif
                </div>
                <div id="show_title" class="col form-group mb-4">
                    <input name="title" placeholder="Title" type="text" class="form-control" id="get_title">
                </div>
                <div class="col form-group mb-4">
                    <label for="verticalFormStepform-name">Upload Date:</label>
                    <input name="create_date" type="datetime-local" class="form-control" id="create_date">
                </div>
                @if(Auth::check())
                    @if(Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->role=='adminManager' || Auth::user()->role=='interviewer')
                    <div class="col form-group mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_view" id="is_view" value="1" id="flexRadioDefault1" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                                View By All
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_view" id="is_view" value="2" id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                View By UKMC
                            </label>
                        </div>
                    </div>
                    @endif
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
        </div>
    </div>
</div>
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
                    <button type="button" class="step-trigger" role="tab" aria-selected="false">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">Step Two</span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#verticalFormStep-three">
                    <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Three</span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <div id="verticalFormStep-two" class="content fade dstepper-block active" role="tabpanel">
                    <form class="row g-3">
                        <h5 class="text-center">Documents Upload</h5>
                        <hr>
                        <div class="col-9">
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
                            <label for="verticalFormInputAddress" class="form-label">Upload Files (Note: Please Upload jpg,jpeg,png and PDF file Format)</label><br>
                            <button type="button" class="btn btn-primary mr-2 _effect--ripple waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Upload File
                              </button>
                        </div>

                        <div class="col-12">
                            <label for="verticalFormInputAddress" class="form-label">Attached Files</label>
                            <div class="table">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Filename</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Uploaded on</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($application_documents as $doc)
                                        <tr>
                                            <td>{{ $doc->document_type }}</td>
                                            <td>{{ (!empty($doc->title))?$doc->title:'' }}</td>
                                            <td>
                                                @if(!empty($doc->create_date))
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                <span class="table-inner-text">{{ date('F d Y',strtotime($doc->create_date)) }}</span>
                                                @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                <span class="table-inner-text">{{ date('F d Y',strtotime($doc->created_at)) }}</span>
                                                @endif
                                                
                                            </td>
                                            <td>
                                                @php
                                                    $allowedRoles = ['agent', 'student'];
                                                    $isAdmin = in_array(Auth::user()->role, ['admin', 'manager', 'adminManager', 'interviewer']);
                                                @endphp

                                                @if(in_array(Auth::user()->role, $allowedRoles) && $doc->is_view == 1)
                                                    <a target="_blank" href="{{ asset($doc->doc) }}">
                                                        <span class="badge badge-light-success">Preview</span>
                                                    </a>
                                                @elseif($isAdmin)
                                                    <a target="_blank" href="{{ asset($doc->doc) }}">
                                                        <span class="badge badge-light-success">Preview</span>
                                                    </a>
                                                @else
                                                    <a href="#">
                                                        <span class="badge badge-light-warning">Only Admin View</span>
                                                    </a>
                                                @endif
                                                @if(Auth::check() && Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->id==$doc->user_id)
                                                <a onclick="getDocumentData('{{ $doc->id }}')" data-bs-toggle="modal" data-bs-target="#exampleModal11" href="javascript://" >
                                                    <span class="badge badge-light-warning">Edit</span>
                                                </a>
                                                <a href="javascript:void(0)" onclick="if(confirm('Are you sure to Delete this Document File?')) location.href='{{ URL::to('delete-application-doc-file/'.$doc->id) }}'; return false;">
                                                    <span class="badge badge-light-danger">Delete</span>
                                                </a>
                                                
                                                @endif

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
                    @if(Auth::user())

                        <div class="row">
                            <h5>Requested Document</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <td class="col-3">Subject</td>
                                    <td class="col-4">Note</td>
                                    <td>Request By</td>
                                    <td>Status</td>
                                    @if(Auth::user()->role=='agent' || Auth::user()->role=='student')
                                    <td>Action</td>
                                    @endif
                                </tr>
                                @foreach($requested_documents as $drow)
                                <tr>
                                    <td>{{ (!empty($drow->subject))?$drow->subject:'NIL' }}</td>
                                    <td>{{ (!empty($drow->message))?$drow->message:'' }}</td>
                                    <td>
                                        {{ (!empty($drow->document_by->name))?$drow->document_by->name:'' }}
                                    </td>
                                    <td>
                                        @if($drow->status==0)
                                        <span class="badge badge-warning">Pending</span>
                                        @else
                                        <span class="badge badge-success">Complete</span>
                                        @endif
                                    </td>
                                    @if(Auth::user()->role=='agent' || Auth::user()->role=='student')
                                    <td>
                                        <a href="javascript:void(0)" onclick="if(confirm('Are you sure to Confirm this Document Data?')) location.href='{{ URL::to('confirm-request-document/'.$drow->id) }}'; return false;"><span class="badge badge-light-warning">Confirm</span></a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </table>
                        </div>

                    @endif
                    <!-- request document see by admin -->


                    <!-- academic or nonacademic check -->
                    @if($application_data->is_academic==1)
                    <div class="row">
                        <h5>Create</h5>
                        <form method="post" action="{{ URL::to('qualification-post') }}" enctype="multipart/form-data" class="form">
                            @csrf
                            <div class="row">
                                <input type="hidden" id="get_application_id" name="get_application_id" value="{{ (!empty($application_id))?$application_id:'' }}" />
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Name of Qualifications:</label>
                                    <input class="form-control" type="text" id="name_of_qualification" name="name_of_qualification" value="" />
                                    @if ($errors->has('name_of_qualification'))
                                        <span class="text-danger">{{ $errors->first('name_of_qualification') }}</span>
                                    @endif
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Name of Institution:</label>
                                    <input class="form-control" type="text" id="name_of_institute" name="name_of_institute" value="" />
                                    @if ($errors->has('name_of_institute'))
                                        <span class="text-danger">{{ $errors->first('name_of_institute') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Awarding Organization:</label>
                                    <input class="form-control" type="text" id="awarding_organization" name="awarding_organization" value="" />
                                    @if ($errors->has('awarding_organization'))
                                        <span class="text-danger">{{ $errors->first('awarding_organization') }}</span>
                                    @endif
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Grade:</label>
                                    <input class="form-control" type="text" id="grade" name="grade" value="" />
                                    @if ($errors->has('grade'))
                                        <span class="text-danger">{{ $errors->first('grade') }}</span>
                                    @endif
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Year of Completion:</label>
                                    <input class="form-control" type="datetime-local" id="year_of_completion" name="year_of_completion" value="" />
                                    @if ($errors->has('year_of_completion'))
                                        <span class="text-danger">{{ $errors->first('year_of_completion') }}</span>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary btn-nxt">Submit</button>
                        </form><hr>
                        <h5>Qualification List</h5>
                        <table class="table table-bordered">
                            <tr>
                                <td>Name of Qualifications</td>
                                <td>Name of Institution</td>
                                <td>Awarding Organization</td>
                                <td>Grade</td>
                                <td>Year of Completion</td>
                            </tr>

                            @forelse ($qualification_list as $qlist)
                            <tr>
                                <td>{{ $qlist->name_of_qualification }}</td>
                                <td>{{ $qlist->name_of_institute }}</td>
                                <td>{{ $qlist->awarding_organization }}</td>
                                <td>{{ $qlist->grade }}</td>
                                <td>{{ $qlist->year_of_completion }}</td>
                            </tr>
                            @empty

                            @endforelse


                        </table>
                    </div>
                    @endif
                    @if($application_data->is_academic==2)
                    <div class="row">
                        <h5>Job Create</h5>
                        <form method="post" action="{{ URL::to('experience-post') }}" class="form">
                            @csrf
                            <div class="row">
                                <input type="hidden" id="get_application_id" name="get_application_id" value="{{ (!empty($application_id))?$application_id:'' }}" />
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Job Title:</label>
                                    <input class="form-control" type="text" id="job_title" name="job_title" value="" />
                                    @if ($errors->has('job_title'))
                                        <span class="text-danger">{{ $errors->first('job_title') }}</span>
                                    @endif
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Employer Name:</label>
                                    <input class="form-control" type="text" id="employer_name" name="employer_name" value="" />
                                    @if ($errors->has('employer_name'))
                                        <span class="text-danger">{{ $errors->first('employer_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Email:</label>
                                    <input class="form-control" type="text" id="email" name="email" value="" />
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Phone:</label>
                                    <input class="form-control" type="text" id="phone" name="phone" value="" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Start Date:</label>
                                    <input class="form-control" type="datetime-local" id="start_date" name="start_date" value="" />
                                    @if ($errors->has('start_date'))
                                        <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                    @endif
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">End Date:</label>
                                    <input class="form-control" type="datetime-local" id="end_date" name="end_date" value="" />
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Continue:</label>
                                    <input class="form-check-input checkbox_child" name="continue" value="continue" type="checkbox">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary btn-nxt">Submit</button>
                        </form><hr>
                        <h5>Experience List</h5>
                        <table class="table table-bordered">
                            <tr>
                                <td>Job Title</td>
                                <td>Employer Name</td>
                                <td>Email</td>
                                <td>Phone</td>
                                <td>Start Date</td>
                                <td>End Date</td>
                            </tr>
                            @forelse ($job_list as $jlist)
                            <tr>
                                <td>{{ $jlist->job_title }}</td>
                                <td>{{ $jlist->employer_name }}</td>
                                <td>{{ $jlist->email }}</td>
                                <td>{{ $jlist->phone }}</td>
                                <td>{{ $jlist->start_date }}</td>
                                <td>{{ (!empty($jlist->end_date))?$jlist->end_date:$jlist->continue }}</td>
                            </tr>
                            @empty

                            @endforelse
                        </table>
                    </div><hr>
                    @endif
                    <div class="row">
                        <h5>SOP Create</h5>
                        <form method="post" action="{{ URL::to('sop-data-post') }}" class="form">
                            @csrf
                            <div class="row">
                                <input type="hidden" id="sop_application_id" name="sop_application_id" value="{{ (!empty($application_id))?$application_id:'' }}" />
                                <input type="hidden" id="sop_id" name="sop_id" value="{{ (!empty($application_data->sop->id))?$application_data->sop->id:'' }}" />
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">SOP: (Upto 500 words). Yearning for an exceptional SOP that captures my true essence. </label>
                                    <textarea name="sop_data" class="form-control" rows="8">{{ (!empty($application_data->sop->sop_data))?$application_data->sop->sop_data:'' }}</textarea>
                                    @if ($errors->has('sop_data'))
                                        <span class="text-danger">{{ $errors->first('sop_data') }}</span>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary btn-nxt">Submit</button>
                            @if(Auth::check())
                                @if(Auth::user()->role=='adminManager' || Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->role=='interviewer')
                                    @if(!empty($application_data->sop->id))
                                        <a href="{{ URL::to('sop-plagiarism-check/'.$application_data->sop->id) }}" class="btn btn-danger btn-nxt">SOP Plagiarism Check</a>
                                    @endif
                                @endif
                            @endif

                        </form>
                        @if(Auth::check())
                            @if(Auth::user()->role=='adminManager' || Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->role=='interviewer')
                            <hr>
                            <h5>SOP Plagiarism Result</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <td>Total Queries</td>
                                    <td>Plag Percent</td>
                                    <td>Paraphrase Percent</td>
                                    <td>Unique Percent</td>
                                </tr>
                                <tr>
                                    <td>{{ (!empty($application_data->sop->total_queries))?$application_data->sop->total_queries:'0' }}</td>
                                    <td>{{ (!empty($application_data->sop->plag_percent))?$application_data->sop->plag_percent.'%':'0%' }}</td>
                                    <td>{{ (!empty($application_data->sop->paraphrase_percent))?$application_data->sop->paraphrase_percent.'%':'0%' }}</td>
                                    <td>{{ (!empty($application_data->sop->unique_percent))?$application_data->sop->unique_percent.'%':'0% Unique' }}</td>
                                </tr>

                            </table>
                            @endif
                        @endif
                    </div>
                    <div class="row"><hr>
                        <form method="post" action="{{ URL::to('step-2-post') }}" class="form">
                            @csrf
                            <div class="row">
                                <input type="hidden" id="get_application_id" name="get_application_id" value="{{ (!empty($application_id))?$application_id:'' }}" />
                                <input type="hidden" id="get_application_id" name="application_step2_id" value="{{ (!empty($application_step2_data->id))?$application_step2_data->id:'' }}" />
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Disabilities</label><br>
                                    <div class="form-check form-check-primary form-check-inline">
                                        <input class="form-check-input" type="radio" {{ (!empty($application_step2_data->disabilities) && $application_step2_data->disabilities=='no')?'checked':'' }} name="disabilities" value="no" id="form-check-radio-primary">
                                        <label class="form-check-label" for="form-check-radio-primary">
                                            No
                                        </label>
                                    </div>
                                    <div class="form-check form-check-info form-check-inline">
                                        <input class="form-check-input" type="radio" value="yes" name="disabilities" {{ (!empty($application_step2_data->disabilities) && $application_step2_data->disabilities=='yes')?'checked':'' }} id="form-check-radio-info">
                                        <label class="form-check-label" for="form-check-radio-info">
                                            Yes
                                        </label>
                                    </div>
                                    @if ($errors->has('disabilities'))
                                        <span class="text-danger">{{ $errors->first('disabilities') }}</span>
                                    @endif
                                </div>
                                <div class="col form-group mb-4">
                                    <label for="verticalFormStepform-name">Criminal Convictions</label><br>
                                    <div class="form-check form-check-primary form-check-inline">
                                        <input class="form-check-input" type="radio" {{ (!empty($application_step2_data->criminal_convictions) && $application_step2_data->criminal_convictions=='no')?'checked':'' }} name="criminal_convictions" value="no" id="form-check-radio-primary">
                                        <label class="form-check-label" for="form-check-radio-primary">
                                            No
                                        </label>
                                    </div>
                                    <div class="form-check form-check-info form-check-inline">
                                        <input class="form-check-input" type="radio" value="yes" name="criminal_convictions" {{ (!empty($application_step2_data->criminal_convictions) && $application_step2_data->criminal_convictions=='yes')?'checked':'' }} id="form-check-radio-info">
                                        <label class="form-check-label" for="form-check-radio-info">
                                            Yes
                                        </label>
                                    </div>
                                    @if ($errors->has('criminal_convictions'))
                                        <span class="text-danger">{{ $errors->first('criminal_convictions') }}</span>
                                    @endif
                                </div>

                            </div>
                            @if(Auth::check())
                            @if(Auth::user()->role=='student')
                                @if(!empty($application_data) && $application_data->application_status_id==1)
                                <a href="{{ URL::to('student-portal') }}" class="btn btn-secondary btn-nxt">My Applications</a>
                                @else
                                <div class="button-action mt-3">
                                    <a href="{{ URL::to('application-create/'.$application_id) }}" class="btn btn-secondary btn-prev me-3">Prev</a>
                                    <button type="submit" class="btn btn-secondary btn-nxt">Next</button>
                                </div>
                                @endif
                            @endif
                            @if(Auth::user()->role=='agent')
                                @if(!empty($application_data) && $application_data->application_status_id==1)
                                <a href="{{ URL::to('agent-applications') }}" class="btn btn-secondary btn-nxt">Agent Applications</a>
                                @else
                                <div class="button-action mt-3">
                                    <a href="{{ URL::to('application-create/'.$application_id) }}" class="btn btn-secondary btn-prev me-3">Prev</a>
                                    <button type="submit" class="btn btn-secondary btn-nxt">Next</button>
                                </div>
                                @endif
                            @endif
                            @if(Auth::user()->role=='subAgent')
                            <div class="button-action mt-3">
                                <a href="{{ URL::to('application-create/'.$application_id) }}" class="btn btn-secondary btn-prev me-3">Prev</a>
                                <button type="submit" class="btn btn-secondary btn-nxt">Next</button>
                            </div>
                            @endif
                            @if(Auth::user()->role=='adminManager' || Auth::user()->role=='admin' || Auth::user()->role=='manager')
                            <div class="button-action mt-3">
                                <a href="{{ URL::to('application-create/'.$application_id) }}" class="btn btn-secondary btn-prev me-3">Prev</a>
                                <button type="submit" class="btn btn-secondary btn-nxt">Next</button>
                                <a data-bs-toggle="modal" data-bs-target="#inputFormModal" class="btn btn-warning btn-nxt">Request For Document</a>
                            </div>
                            @endif

                            @if(Auth::user()->role=='student')
                            <div class="button-action mt-3">
                                <a href="{{ URL::to('application-create/'.$application_id) }}" class="btn btn-secondary btn-prev me-3">Prev</a>
                                <button type="submit" class="btn btn-secondary btn-nxt">Next</button>
                            </div>
                            @endif
                            @endif
                            @if(!Auth::check())
                            <div class="button-action mt-3">
                                <a href="{{ URL::to('application-create/'.$application_id) }}" class="btn btn-secondary btn-prev me-3">Prev</a>
                                <button type="submit" class="btn btn-secondary btn-nxt">Next</button>
                            </div>
                            @endif
                        </form><hr>
                    </div>
                </div><br>
            </div>
        </div>
    </div>

</div>
<style>
    .table td{
        white-space: break-spaces !important;
        padding: 3px 2px 2px 12px !important;
    }
    #show_title{
        display:none;
    }
</style>
<script src="{{ asset('web/js/jquery.js') }}"></script>
@if($errors->any())
    @if($errors->has('document_type') || $errors->has('doc'))
    <script>
        $(document).ready(function() {
            $('#exampleModal').modal('show');
        });
    </script>
    @endif
    @if($errors->has('subject') || $errors->has('message'))
    <script>
        $(document).ready(function() {
            $('#inputFormModal').modal('show');
        });
    </script>
    @endif
@endif
<script>
    function getTitle(){
        var getData = $('#document_type').val();
        if(getData=="Other"){
            $('#show_title').show();
        }else{
            $('#show_title').hide();
        }
    }
</script>
<script>
    function getDocumentData(id){
        if(id===null){
            return false;
        }
        $.get('{{ URL::to('get-document-data') }}/'+id,function(data,status){
            if(data['result']['key']===200){
                $('#exampleModal').modal('show');
                $('#document_id').val(data['result']['val']['id']);
                $('#get_document_type option').each(function() {
                    if ($(this).val() === data['result']['val']['document_type']) {
                        $(this).prop('selected', true);
                    }
                });
                
            }
            console.log(data['result']['val']);
        });
    }
</script>
@stop
