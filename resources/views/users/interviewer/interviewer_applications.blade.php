@extends('adminpanel')
@section('admin')

@if(Auth::user()->role=='admin' || Auth::user()->role=='manager')
<div class="modal fade inputForm-modal" id="assignToInterviewerModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Assign To Interviewer</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <div class="mt-0">
            <form action="{{ URL::to('application_assign_to_other_interviewer') }}" id="" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Assign To User:</label>
                                <input type="hidden" name="current_assign_id" id="current_assign_id" value="{{ $interviewer_id }}" />
                                <input type="hidden" name="assign_interviewer_application_ids" id="assign_interviewer_application_ids" />
                                <select name="assign_to_interviewer_id" id="assign_to_interviewer_id" class="form-select">
                                    <option value="" selected>Choose...</option>
                                    @foreach ($interviewer_list as $iurow)
                                    <option value="{{ $iurow->id }}">{{ $iurow->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('assign_to_interviewer_id'))
                                    <span class="text-danger">{{ $errors->first('assign_to_interviewer_id') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</a>
                    <button id="btn-note-submit" class="btn btn-primary mt-2 mb-2 btn-no-effect" >Submit</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endif
<div class="modal fade inputForm-modal" id="inputFormModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Notes</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <div class="mt-0">
            <form id="note-formid" method="post">
                <div class="modal-body">
                    <div id="note-data">

                    </div>
                    <div class="form-group">
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Note:</label>
                                <input type="hidden" name="note_application_id" id="note_application_id" />
                                <textarea name="application_note" id="application_note" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</a>
                    <button id="btn-note-submit" class="btn btn-primary mt-2 mb-2 btn-no-effect" >Submit</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
<div class="modal fade inputForm-modal" id="inputFormModal1" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Follow Up</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <form id="followup-form" method="post" action="#" class="mt-0">
            <div class="modal-body">
                <div id="followupnote-data">

                </div>
                <div class="form-group">
                    <div class="col">
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Note:</label>
                            <input type="hidden" name="followup_application_id" id="followup_application_id" />
                            <textarea name="application_followup" id="application_followup" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Followup Date:</label>
                            <input name="followup_date" id="followup_date" type="datetime-local" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</a>
                <button id="btn-followup-submit" class="btn btn-primary mt-2 mb-2 btn-no-effect">Submit</button>
            </div>
        </form>
      </div>
    </div>
</div>
<div class="modal fade inputForm-modal" id="inputFormModal2" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Meetings</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <form id="meeting-form" enctype="multipart/form-data" class="mt-0">
            <div class="modal-body">
                <div id="meetingnote-data">

                </div>
                <div class="form-group">
                    <div class="col">
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Note:</label>
                            <input type="hidden" value="{{ URL::to('application-meeting-note-post') }}" id="meeting_url" />
                            <input type="hidden" name="meeting_application_id" id="meeting_application_id" />
                            <textarea id="application_meeting" name="application_meeting" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Meeting Date:</label>
                            <input name="meeting_date" id="meeting_date" type="datetime-local" class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Meeting Doc File:</label>
                            <input name="meeting_doc" id="meeting_doc" type="file" class="form-control" />
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</a>
                <button id="btn-meeting-submit" class="btn btn-primary mt-2 mb-2 btn-no-effect">Submit</button>
            </div>
        </form>
      </div>
    </div>
</div>
<div class="layout-px-spacing">
    <div class="middle-content container-xxl p-0">
        <div class="secondary-nav">
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
        <h5 class="pt-3">Filter</h5>
        <div class="widget-content widget-content-area">
            <form method="get" action="">
                 <div class="row">
                     <div class="row mb-2">
                        <div class="col-4">
                            <select id="campus" name="campus" class="form-control" onchange="getInterviewerApplicationData({{ $interviewer_id }})">
                                <option value="">Select Campus</option>
                                @if(count($campuses) > 0)
                                @foreach ($campuses as $campus1)
                                <option {{ (!empty($get_campus) && $get_campus==$campus1->id)?'selected':'' }} value="{{ $campus1->id }}">{{ $campus1->campus_name }}</option>
                                @endforeach
                                @endif
                            </select>
                         </div>
                         <div class="col-4">
                            <select id="agent" name="agent" class="form-control" onchange="getInterviewerApplicationData({{ $interviewer_id }})">
                                <option value="">Select Agent</option>
                                @if(count($agents) > 0)
                                @foreach ($agents as $agent1)
                                <option {{ (!empty($get_agent) && $get_agent==$agent1->id)?'selected':'' }} value="{{ $agent1->id }}">{{ $agent1->company_name }}</option>
                                @endforeach
                                @endif
                            </select>
                         </div>
                         <div class="col-4">
                            <select id="officer" name="officer" class="form-control" onchange="getInterviewerApplicationData({{ $interviewer_id }})">
                                <option value="">Select Admission Manager</option>
                                @if(count($officers) > 0)
                                @foreach ($officers as $officer)
                                <option {{ (!empty($get_officer) && $get_officer==$officer->id)?'selected':'' }} value="{{ $officer->id }}">{{ $officer->name }}</option>
                                @endforeach
                                @endif
                            </select>
                         </div>
                     </div>
                     <div class="row">
                        <div class="col-3">
                            <select id="status" name="status" class="form-control" onchange="getInterviewerApplicationData({{ $interviewer_id }})">
                                <option value="">Select Status</option>
                                @if(count($statuses) > 0)
                                @foreach ($statuses as $status)
                                <option {{ (!empty($get_status) && $get_status==$status->id)?'selected':'' }} value="{{ $status->id }}">{{ $status->title }}</option>
                                @endforeach
                                @endif
                            </select>
                         </div>
                         <div class="col-2">
                            <select id="intake" name="intake" class="form-control" onchange="getInterviewerApplicationData({{ $interviewer_id }})">
                                <option value="">Select Intake</option>
                                @if(count($intakes) > 0)
                                @foreach ($intakes as $intake)
                                <option {{ (!empty($get_intake) && $get_intake==$intake)?'selected':'' }} value="{{ $intake }}">{{ date('F y',strtotime($intake)) }}</option>
                                @endforeach
                                @endif
                            </select>
                         </div>
                         <div class="col-5">
                             <input value="{{ (!empty($search))?$search:'' }}" name="q" id="q" type="text" class="form-control" placeholder="Enter Name,Email,Phone">
                         </div>
                         <div class="col-1">
                            <input type="submit" value="Filter" name="time" class="btn btn-warning">
                         </div>
                         <div class="col-1">
                            <a href="{{ URL::to('reset-interviewer-application-search-list') }}" class="btn btn-danger">Reset</a>
                         </div>
                     </div>


                 </div>
            </form>
        </div>

        <h5 class="pt-3">All Application Here</h5>

        <div class="row layout-top-spacing">

            @if(Auth::user()->role=='manager' || Auth::user()->role=='admin')
            <a data-bs-toggle="modal" data-bs-target="#assignToInterviewerModal" class="assignToDisplay2 assignToBtn2 dropdown-item" href="#">Assign To Interviewer</a>
            @endif

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="checkbox-area" scope="col">

                                    </th>
                                    <th>Application ID</th>
                                    <th>Name</th>
                                    <th>Campus</th>
                                    <th>Create date</th>
                                    <th>Follow Up</th>
                                    <th>Intake</th>

                                    <th>Interviewer</th>
                                    <th>Interview Status</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($application_list as $row)
                                <tr>
                                    <td>
                                        @if($row->interviewer_id == $interviewer_id)
                                        <div class="form-check form-check-primary">
                                            <input value="{{ (!empty($row->id)?$row->id:'') }}" class="assigntointerviewer{{ $row->id }} assign-to-interviewer form-check-input striped_child" type="checkbox">
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{ (!empty($row->id)?$row->id:'') }}</td>
                                    <td>
                                        <div class="media">
                                            <div class="avatar me-2">
                                                <img alt="avatar" src="{{ asset('web/avatar/user.png') }}" class="rounded-circle" />
                                            </div>
                                            <div class="media-body align-self-center">
                                                <h6 class="mb-0">{{ (!empty($row->name))?$row->name:'' }}</h6>
                                                <span>{{ (!empty($row->email))?$row->email:'' }}</span><br>
                                                <span>{{ (!empty($row->phone))?$row->phone:'' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ (!empty($row->campus->campus_name)?$row->campus->campus_name:'') }}</td>
                                    <td>{{ date('F d Y',strtotime($row->created_at)) }}</td>
                                    <td>
                                        @if(Auth::user()->role=='admin' || Auth::user()->id==$row->manager_id || Auth::user()->id==$row->admission_officer_id)
                                        <div class="is-action{{ $row->id }} dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink6" style="">
                                                <a data-bs-toggle="modal" data-bs-target="#inputFormModal" class="dropdown-item" onclick="get_application_notes({{ $row->id }})" href="#">Notes</a>
                                                <a data-bs-toggle="modal" data-bs-target="#inputFormModal1" class="dropdown-item" onclick="get_application_followups({{ $row->id }})" href="javascript:void(0);">Follow Up</a>
                                                <a data-bs-toggle="modal" data-bs-target="#inputFormModal2" class="dropdown-item" onclick="get_application_meetings({{ $row->id }})" href="javascript:void(0);">Meeting</a>
                                            </div>
                                        </div>
                                        @else
                                        <div class="is-action-data is-action{{ $row->id }} dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink6" style="">
                                                <a data-bs-toggle="modal" data-bs-target="#inputFormModal" class="dropdown-item" href="#">Notes</a>
                                                <a data-bs-toggle="modal" data-bs-target="#inputFormModal1" class="dropdown-item" href="javascript:void(0);">Follow Up</a>
                                                <a data-bs-toggle="modal" data-bs-target="#inputFormModal2" class="dropdown-item" href="javascript:void(0);">Meeting</a>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        {{ date('F Y',strtotime($row->intake)) }}
                                    </td>
                                    <td>
                                        @if($row->interviewer_id > 0)
                                        <span>
                                            {{ (!empty($row->interviewer->name))?$row->interviewer->name:'' }}
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                    @if(count($interview_statuses) > 0)
                                        @foreach ($interview_statuses as $isrow)
                                            @if($row->interview_status==$isrow->id)
                                            <span class="shadow-none badge badge-success">{{ $isrow->title }}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                    </td>

                                    <td>
                                        @if (count($statuses) > 0)
                                            @foreach ($statuses as $srow)
                                                @if($row->status==$srow->id)
                                                <span class="shadow-none badge badge-danger">{{ $srow->title }}</span>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="flex space-x-2">
                                        @if($row->application_status_id==1)
                                        <a href="{{ URL::to('application/'.$row->id.'/details') }}" class="badge badge-pill bg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        </a>
                                        @else
                                            @if(!in_array(2,explode(",",$row->steps)))
                                            <a href="{{ URL::to('application-create/'.$row->id.'/step-2') }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            @elseif(!in_array(3,explode(",",$row->steps)))
                                            <a href="{{ URL::to('application-create/'.$row->id.'/step-3') }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            @elseif(!in_array(4,explode(",",$row->steps)))
                                            <a href="{{ URL::to('application-create/'.$row->id.'/step-4') }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            @elseif(!in_array(5,explode(",",$row->steps)))
                                            <a href="{{ URL::to('application-create/'.$row->id.'/step-5') }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            @else

                                            @endif

                                        @endif
                                        @if(Auth::user()->role=='admin' || Auth::user()->id==$row->manager_id || Auth::user()->id==$row->admission_officer_id)
                                        <span>
                                            <a href="{{ URL::to('application/'.$row->id.'/processing') }}" class="badge badge-pill bg-secondary">
                                                <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.75 5H8.25C7.55964 5 7 5.58763 7 6.3125V19L12 15.5L17 19V6.3125C17 5.58763 16.4404 5 15.75 5Z" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </a>
                                            <a href="{{ URL::to('application-create/'.$row->id) }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                        </span>
                                        @else
                                        <span class="action-spn{{ $row->id }} is-action-data">

                                            <a href="{{ URL::to('application-create/'.$row->id) }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                        </span>
                                        @endif

                                    </td>

                                </tr>
                                @empty
                                    <tr>
                                        No Data Found
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                        <div style="text-align: center;" class="pagination-custom_solid">
                            {{ $application_list->links() }}
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
    .assignToDisplay2{
        display: none;
    }
    .assignToBtn{
        color: #f7bd1a !important;
        margin-left: 14px;
        font-size: 15px !important;
    }
    .assignToBtn1{
        color: #f7bd1a !important;
        margin-left: 14px;
        font-size: 15px !important;
    }
    .assignToBtn2{
        color: #f7bd1a !important;
        margin-left: 14px;
        font-size: 15px !important;
    }
</style>
<script src="{{ asset('web/js/jquery.js') }}"></script>
@if(Auth::user()->role=='manager' || Auth::user()->role=='admin')
    <script>
        var selectedValues = [];
        $('.assign-to-interviewer').on('change', function() {
        if ($(this).is(':checked')) {
            var value = $(this).val();
            selectedValues.push(value);
            $('.assignToDisplay2').show();
            $('#assign_interviewer_application_ids').val(selectedValues);
        } else {
            var valueIndex = selectedValues.indexOf($(this).val());
            if (valueIndex !== -1) {
                selectedValues.splice(valueIndex, 1);
            }
            if(selectedValues.length === 0){
                $('.assignToDisplay2').hide();
            }
            $('#assign_interviewer_application_ids').val(selectedValues);
        }

        var selectedValue = selectedValues.join(',');
        console.log(selectedValue);
        // Perform any further actions with the selected values
    });
    </script>
    @if($errors->has('assign_to_interviewer_id'))
    <script>
        $(document).ready(function() {
            $('#assignToInterviewerModal').modal('show');
        });
    </script>
    @endif
@endif

<script>

    function getInterviewerApplicationData(id){
        if(id===null){
            return false;
        }
        var campus = $('#campus').val();
        var agent = $('#agent').val();
        var officer = $('#officer').val();
        var status = $('#status').val();
        var intake = $('#intake').val();
        window.location = "{{ URL::to('get-interviewer-application') }}/"+id+"?campus=" + campus + "&agent=" + agent + "&officer=" + officer + "&status=" + status + "&intake=" + intake;
    }
</script>
@stop
