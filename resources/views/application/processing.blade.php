@extends('adminpanel')
@section('admin')
<div class="layout-px-spacing">
    <div class="middle-content container-xxl p-0">
        <div class="row secondary-nav">
            <div class="breadcrumbs-container" data-page-heading="Analytics">
                <header class="header navbar navbar-expand-sm">
                    <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-menu">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </a>
                    <div class="d-flex breadcrumb-content">
                        <div class="page-header">
                            <div class="page-title">
                            </div>
                            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Application</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Pending Applications</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="row">
                        <div class="col col-md-6 mb-4">
                            <h5 class="pb-2">Personal Information</h5>
                            <div class="table-responsive">
                                <table class="table-bordered mb-4 table">
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>{{ (!empty($application_info->name))?$application_info->name:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>{{ (!empty($application_info->phone))?$application_info->phone:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ (!empty($application_info->email))?$application_info->email:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nationality</td>
                                            <td>{{ (!empty($application_info->step2Data->nationality))?$application_info->step2Data->nationality:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Other Nationality</td>
                                            <td>{{ (!empty($application_info->step2Data->other_nationality))?$application_info->step2Data->other_nationality:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Date of Birth</td>
                                            <td>{{ (!empty($application_info->date_of_birth))?$application_info->date_of_birth:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Passport No</td>
                                            <td>{{ (!empty($application_info->step2Data->passport_no))?$application_info->step2Data->passport_no:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Living Country</td>
                                            <td>{{ (!empty($application_info->step2Data->current_country))?$application_info->step2Data->current_country:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Living State</td>
                                            <td>{{ (!empty($application_info->step2Data->current_state))?$application_info->step2Data->current_state:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Living City</td>
                                            <td>{{ (!empty($application_info->step2Data->current_city))?$application_info->step2Data->current_city:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Zip Code</td>
                                            <td>{{ (!empty($application_info->step2Data->current_postal_code))?$application_info->step2Data->current_postal_code:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Living Address Details</td>
                                            <td>{{ (!empty($application_info->step2Data->current_address_line_2))?$application_info->step2Data->current_address_line_2:'' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="card no-outer-spacing no-border-custom" theme-mode-data="false">
                                    <div class="card-header">
                                        <section class="mb-0 mt-0">
                                            <div role="menu" class="" data-toggle="">Lead Notes</div>
                                        </section>
                                    </div>
                                    <div id="" class="" aria-labelledby="headingTwo2" data-parent="#withoutSpacing">
                                        <div id="note-data">
                                            @if(count($application_info->notes) > 0)
                                                @foreach ($application_info->notes as $note)
                                                <div class="row col-md-12 mt-3" id="">
                                                    <div style="margin-left:7px;" class="media custom-media-img">
                                                        <div style="margin-left: 2px;" class="ml-2">
                                                            <img alt="avatar" src="{{ asset($note->user->photo) }}" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">
                                                        </div>
                                                        <div class="media-body"><h6 class="tx-inverse">{{ (!empty($note->user->name))?$note->user->name:'' }}<a onclick="deleteMainNote({{ $note->id }})" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a></h6><p class="mg-b-0">{{ (!empty($note->note))?$note->note:'' }}</p><small class="text-left"> Created : {{ date('F d Y H:i:s',strtotime($note->created_at)) }}</small></div>
                                                    </div>
                                                </div><hr>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="card-body custom-card-body">
                                            <form id="note-formid" method="post">
                                                <div class="col col-md-12 p-0">
                                                    <div class="form-group lead-drawer-form">
                                                        <input type="hidden" value="{{ (!empty($application_info->id))?$application_info->id:'' }}" name="note_application_id" id="note_application_id" />
                                                        <textarea name="application_note" id="application_note" class="form-control" rows="2"></textarea>
                                                        <!---->
                                                    </div><button id="btn-note-submit" class="btn badge badge-info btn-sm _effect--ripple waves-effect waves-light" >Save</button>
                                                </div>
                                                <hr>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <div class="card no-outer-spacing no-border-custom">
                                <div class="card-header">
                                    <section class="mb-0 mt-0">
                                        <div role="menu" class="" data-toggle="">Meeting</div>
                                    </section>
                                </div>
                                <div id="" class="" aria-labelledby="headingTwo2" data-parent="#withoutSpacing">
                                    <div id="meetingnote-data">
                                        @if(count($application_info->meetings) > 0)
                                            @foreach ($application_info->meetings as $note)
                                            <div class="row col-md-12 mt-3" id="">
                                                <div style="margin-left:7px;" class="media custom-media-img">
                                                    <div style="margin-left: 2px;" class="ml-2">
                                                        <img alt="avatar" src="{{ asset($note->user->photo) }}" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="tx-inverse">{{ (!empty($note->user->name))?$note->user->name:'' }}
                                                            <a onclick="deleteMeetingNote({{ $note->id }})" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                                                            <a id="meeting_waiting{{ $note->id }}" onclick="isMeetingComplete({{ $note->id }})" style="float:right; color:#ada310; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></a>
                                                            <a id="meeting_complete{{ $note->id }}" onclick="isMeetingComplete({{ $note->id }})" style="float:right; color:#1f6b08; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></a>
                                                        </h6>
                                                        <p class="mg-b-0">{{ (!empty($note->meeting_notes))?$note->meeting_notes:'' }}</p>
                                                        <small class="text-left"> Meeting Date : <span class="badge badge-warning">June 29 2023 18:33:00</span></small><br>
                                                        <small class="text-left"> Created : {{ date('F d Y H:i:s',strtotime($note->created_at)) }}</small></div>
                                                </div>
                                            </div><hr>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="card-body custom-card-body">
                                        <form id="meeting-form" method="post">
                                            <div class="col col-md-12 p-0">
                                                <div class="form-group lead-drawer-form">
                                                    <input type="hidden" value="{{ (!empty($application_info->id))?$application_info->id:'' }}" name="meeting_application_id" id="meeting_application_id" />
                                                    <textarea id="application_meeting" name="application_meeting" class="form-control" rows="2"></textarea>
                                                </div><br>
                                                <div class="col col-md-12 p-0">
                                                    <input name="meeting_date" id="meeting_date" type="datetime-local" class="form-control" />
                                                </div>
                                                <button id="btn-meeting-submit" class="btn badge badge-info btn-sm _effect--ripple waves-effect waves-light" >Save</button>
                                            </div>
                                            <hr>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6 mb-4">
                            <h5 class="pb-2">Admission Information</h5>
                            <div class="table-responsive">
                                <table class="table-bordered mb-4 table">
                                    <tbody>
                                        <tr>
                                            <td>Campus/University</td>
                                            <td>{{ (!empty($application_info->campus->campus_name))?$application_info->campus->campus_name:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Course Category</td>
                                            <td>{{ (!empty($application_info->course->category->title))?$application_info->course->category->title:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Course Level</td>
                                            <td>{{ (!empty($application_info->course->course_level->title))?$application_info->course->course_level->title:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Current Course</td>
                                            <td>{{ (!empty($application_info->course->course_name))?$application_info->course->course_name:'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Course Fee</td>
                                            <td>
                                                <span>Local: {{ (!empty($application_info->course->course_fee))?$application_info->course->course_fee:'' }}</span><br>
                                                <span>International: {{ (!empty($application_info->course->international_course_fee))?$application_info->course->international_course_fee:'' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Course Duration</td>
                                            <td>
                                                {{ (!empty($application_info->course->course_duration))?$application_info->course->course_duration:'' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Intake Year</td>
                                            <td>{{ (!empty($application_info->intake))? date('F y',strtotime($application_info->intake)):'' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card no-outer-spacing no-border-custom">
                                <div class="card-header">
                                    <section class="mb-0 mt-0">
                                        <h5>Follow up</h5>
                                    </section>
                                </div>
                                <div id="" class="" aria-labelledby="headingTwo2" data-parent="#withoutSpacing">
                                    <div id="followupnote-data">
                                        @if(count($application_info->followups) > 0)
                                            @foreach ($application_info->followups as $note)
                                            <div class="row col-md-12 mt-3" id="">
                                                <div style="margin-left:7px;" class="media custom-media-img">
                                                    <div style="margin-left: 2px;" class="ml-2">
                                                        <img alt="avatar" src="{{ asset($note->user->photo) }}" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="tx-inverse">{{ (!empty($note->user->name))?$note->user->name:'' }}<a onclick="deleteFollowupNote({{ $note->id }})" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a></h6>
                                                        <p class="mg-b-0">{{ (!empty($note->follow_up))?$note->follow_up:'' }}</p>
                                                        <small class="text-left"> Meeting Date : <span class="badge badge-warning">{{ date('F d Y H:i:s',strtotime($note->follow_up_date_time)) }}</span></small><br>
                                                        <small class="text-left"> Created : {{ date('F d Y H:i:s',strtotime($note->created_at)) }}</small></div>
                                                </div>
                                            </div><hr>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="card-body custom-card-body">
                                        <form id="followup-form" method="post">
                                            <div class="col col-md-12 p-0">
                                                <div class="form-group lead-drawer-form">
                                                    <input type="hidden" value="{{ (!empty($application_info->id))?$application_info->id:'' }}" name="followup_application_id" id="followup_application_id" />
                                                    <textarea name="application_followup" id="application_followup" class="form-control" rows="2"></textarea>
                                                </div><br>
                                                <div class="col col-md-12 p-0">
                                                    <input name="followup_date" id="followup_date" type="datetime-local" class="form-control" />
                                                </div>
                                                <button id="btn-followup-submit" class="btn badge badge-info btn-sm _effect--ripple waves-effect waves-light" >Save</button>
                                            </div>
                                            <hr>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-12 mb-4">
                            <h5 class="pb-2">Application Document</h5>
                            <p>No File Uploaded Yet</p>
                            <ul class="documents-files"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .is-action-data{
        display: none;
    }
    .is-action-data-show{
        display: block;
    }
    .error{
        color: #a90606 !important;
    }
    .custom-media-margin{
        margin: 9px !important;
    }
</style>
@stop
