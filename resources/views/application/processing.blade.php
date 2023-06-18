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
                                                        <div class="media-body"><h6 class="tx-inverse">{{ (!empty($note->user->name))?$note->user->name:'' }}<a onclick="deleteMainNote(2)" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a></h6><p class="mg-b-0">{{ (!empty($note->note))?$note->note:'' }}</p><small class="text-left"> Created : {{ date('F d Y H:i:s',strtotime($note->created_at)) }}</small></div>
                                                    </div>
                                                </div><hr>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="card-body custom-card-body">
                                            <form method="post" action="{{ URL::to('note-create-of-application-details') }}" >
                                                @csrf
                                                <div class="col col-md-12 p-0">
                                                    <div class="form-group lead-drawer-form">
                                                        <input type="hidden" value="{{ (!empty($application_info->id))?$application_info->id:'' }}" name="note_application_id" />
                                                        <textarea name="note" cols="30" rows="3" placeholder="Type Lead Notes here..." class="form-control"></textarea>
                                                        @if ($errors->has('note'))
                                                            <span class="text-danger">{{ $errors->first('note') }}</span>
                                                        @endif
                                                        <!---->
                                                    </div><button class="btn badge badge-info btn-sm">Save
                                                        <!---->
                                                    </button>
                                                </div>
                                                <hr>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <div class="card no-outer-spacing">
                                <div id="headingThree3" class="card-header">
                                    <section class="mb-0 mt-0">
                                        <h5>Meeting</h5>
                                    </section>
                                </div>
                                <div>
                                    <div class="card-body custom-card-body p-0">
                                        <div class="col-col-md-12"><button class="btn btn-secondary meeting-button"> Make a
                                                Meeting <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-calendar">
                                                    <rect x="3" y="4" width="18" height="18"
                                                        rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                </svg></button></div><br>
                                        <!---->
                                        <div class="col col-md-12 p-0">
                                            <div id="tableSimple" class="col-lg-12 col-12 p-0"><label
                                                    style="font-size: 12px;">Meeting schedule</label>
                                                <div class="table-responsive meeting-table">
                                                    <table id="manage_app_process" class="table-bordered mb-4 table">
                                                        <thead>
                                                            <tr>
                                                                <th>Date Time</th>
                                                                <th>Done</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div data-v-b64104d7="" id="confirmationModal" class="modal confirmation-custom fade"
                                            tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
                                            aria-hidden="true">
                                            <div data-v-b64104d7="" class="modal-dialog" role="document">
                                                <div data-v-b64104d7="" class="modal-content">
                                                    <div data-v-b64104d7="" class="modal-header">
                                                        <h5 data-v-b64104d7="" id="confirmationModalLabel" class="modal-title">
                                                            Confirmation</h5><button data-v-b64104d7="" type="button"
                                                            class="close" data-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div data-v-b64104d7="" class="modal-body"><strong data-v-b64104d7=""
                                                            class="modal-text">Have you Complete The Meeting ?</strong></div>
                                                    <div data-v-b64104d7="" class="modal-footer d-flex justify-content-center">
                                                        <button data-v-b64104d7="" class="btn btn-sm" data-dismiss="modal"><i
                                                                data-v-b64104d7="" class="flaticon-cancel-12"></i> No
                                                        </button><button data-v-b64104d7="" type="button"
                                                            class="btn btn-warning btn-sm">Yes</button></div>
                                                </div>
                                            </div>
                                        </div>
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
                            <div class="col col-md-12"></div>
                            <h5 class="pb-2">University Information</h5>
                            <div class="table-responsive">
                                <table class="table-bordered mb-4 table">
                                    <thead>
                                        <tr>
                                            <th>Institute Name</th>
                                            <th>Course Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Bangor University</td>
                                            <td>BSc (Hons) Pharmacology</td>
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
                                <div class="application-follow-up-wrap">
                                    <div class="card-body custom-card-body p-0">
                                        <form>
                                            <div class="col col-md-12 p-0">
                                                <div class="form-group lead-drawer-form"><label>Follow up Date</label>

                                                </div>
                                                <div class="form-group lead-drawer-form">
                                                    <textarea name="follow_up" cols="30" rows="3" placeholder="Follow up notes..." class="form-control"></textarea>
                                                    <!---->
                                                </div><button class="btn badge badge-info btn-sm">Save
                                                    <!---->
                                                </button>
                                            </div>
                                            <hr>
                                            <div class="col col-md-12 p-0">
                                                <ul class="list-group list-group-media drawer-follow-up-list"></ul>
                                            </div>
                                        </form><br>
                                        <div class="row">
                                            <div class="col col-md-12">
                                                <div class="lms-pagination">
                                                    <div data-v-1ef4d76c="" class="flex justify-center custom-pagination">
                                                        <ul data-v-1ef4d76c="" class="link-list">
                                                            <li data-v-1ef4d76c=""
                                                                class="flex border-r border-gray-200 last:border-r-0 dark:border-slate-500">
                                                                <a data-v-1ef4d76c="" aria-current="page"
                                                                    href="/application-lead-info/bhe-140581#"
                                                                    class="router-link-active router-link-exact-active link link-disabled">«
                                                                    Previous</a></li>
                                                            <li data-v-1ef4d76c=""
                                                                class="flex border-r border-gray-200 last:border-r-0 dark:border-slate-500">
                                                                <a data-v-1ef4d76c="" aria-current="page"
                                                                    href="/application-lead-info/bhe-140581?page=1"
                                                                    class="router-link-active router-link-exact-active link hover:bg-gray-200 dark:hover:bg-blue-500 dark:hover:text-white link-active">1</a>
                                                            </li>
                                                            <li data-v-1ef4d76c=""
                                                                class="flex border-r border-gray-200 last:border-r-0 dark:border-slate-500">
                                                                <a data-v-1ef4d76c="" aria-current="page"
                                                                    href="/application-lead-info/bhe-140581#"
                                                                    class="router-link-active router-link-exact-active link link-disabled">Next
                                                                    »</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div data-v-787d8446="" id="followupConfirmationModal" class="modal confirmation-custom fade"
                                    tabindex="-1" role="dialog" aria-labelledby="followupConfirmationModalLabel"
                                    aria-hidden="true">
                                    <div data-v-787d8446="" class="modal-dialog" role="document">
                                        <div data-v-787d8446="" class="modal-content">
                                            <div data-v-787d8446="" class="modal-header">
                                                <h5 data-v-787d8446="" id="followupConfirmationModalLabel" class="modal-title">
                                                    Confirmation</h5><button data-v-787d8446="" type="button" class="close"
                                                    data-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div data-v-787d8446="" class="modal-body"><strong data-v-787d8446=""
                                                    class="modal-text">Have you Complete The Follow up ?</strong></div>
                                            <div data-v-787d8446="" class="modal-footer d-flex justify-content-center"><button
                                                    data-v-787d8446="" class="btn btn-sm" data-dismiss="modal"><i
                                                        data-v-787d8446="" class="flaticon-cancel-12"></i> No </button><button
                                                    data-v-787d8446="" type="button" class="btn btn-warning btn-sm">Yes</button>
                                            </div>
                                        </div>
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
@stop
