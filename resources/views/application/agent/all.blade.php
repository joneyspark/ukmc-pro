@extends('adminpanel')
@section('admin')
<div class="modal fade inputForm-modal" id="inputFormModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Notes</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <div class="mt-0">
            <form id="agent-note-formid" method="post">
                <div class="modal-body">
                    <div id="agent-note-data">

                    </div>
                    <div class="form-group">
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Note:</label>
                                <input type="hidden" value="" name="note_application_id" id="note_application_id" />
                                <textarea name="application_note" id="application_note" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</a>
                    <button id="agent-btn-note-submit" class="btn btn-primary mt-2 mb-2 btn-no-effect" >Submit</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
<div class="modal fade inputForm-modal" id="transModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Transfer Application To Another Sub Agent</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <div class="mt-0">
            <form action="{{ URL::to('transfer-application-to-another-sub-agent') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Sub Agent List:</label>
                                <input type="hidden" name="application_id" id="application_id" />
                                <select name="sub_agent_id" class="form-control">
                                    <option value="">--Select Sub Agent--</option>
                                    @forelse ($sub_agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                    @empty

                                    @endforelse
                                </select>
                                @if ($errors->has('sub_agent_id'))
                                    <span class="text-danger">{{ $errors->first('sub_agent_id') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-no-effect" >Submit</button>
                </div>
            </form>
        </div>
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
                                    <li class="breadcrumb-item active" aria-current="page">All</li>
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
                       <div class="col-3">
                           <select id="campus" name="campus" class="form-control" onchange="getAgentApplicationData()">
                               <option value="">--Campus--</option>
                               @if(count($campuses) > 0)
                               @foreach ($campuses as $campus1)
                               <option {{ (!empty($get_campus) && $get_campus==$campus1->id)?'selected':'' }} value="{{ $campus1->id }}">{{ $campus1->campus_name }}</option>
                               @endforeach
                               @endif
                           </select>
                        </div>


                        <div class="col-3">
                           <select id="status" name="status" class="form-control" onchange="getAgentApplicationData()">
                               <option value="">Select Status</option>
                               @if(count($statuses) > 0)
                               @foreach ($statuses as $status)
                               <option {{ (!empty($get_status) && $get_status==$status->id)?'selected':'' }} value="{{ $status->id }}">{{ $status->title }}</option>
                               @endforeach
                               @endif
                           </select>
                        </div>
                        <div class="col-3">
                           <select id="interview_status" name="interview_status" class="form-control" onchange="getAgentApplicationData()">
                               <option value="">Interview Status</option>
                               @if(count($interview_statuses) > 0)
                               @foreach ($interview_statuses as $istatus)
                               <option {{ (!empty($get_interview_status) && $get_interview_status==$istatus->id)?'selected':'' }} value="{{ $istatus->id }}">{{ $istatus->title }}</option>
                               @endforeach
                               @endif
                           </select>
                        </div>

                        <div class="col-3">
                            <select id="intake" name="intake" class="form-control" onchange="getAgentApplicationData()">
                                <option value="">Select Intake</option>
                                @if(count($intakes) > 0)
                                @foreach ($intakes as $intake)
                                <option {{ (!empty($get_intake) && $get_intake==$intake)?'selected':'' }} value="{{ $intake }}">{{ date('F y',strtotime($intake)) }}</option>
                                @endforeach
                                @endif
                            </select>
                         </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <select id="sub_agent_id" name="sub_agent_id" class="form-control" onchange="getAgentApplicationData()">
                                <option value="">Sub Agents</option>
                                @if(count($sub_agents) > 0)
                                @foreach ($sub_agents as $sub_agent)
                                <option {{ (!empty($get_sub_agent_id) && $get_sub_agent_id==$sub_agent->id)?'selected':'' }} value="{{ $sub_agent->id }}">{{ $sub_agent->name }}</option>
                                @endforeach
                                @endif
                            </select>
                         </div>
                        <div class="col-2">
                            <input value="{{ (!empty($get_from_date))?$get_from_date:'' }}" name="from_date" id="from_date" type="date" class="form-control" placeholder="From Date" onchange="getAgentApplicationData()">
                        </div>
                        <div class="col-2">
                            <input value="{{ (!empty($get_to_date))?$get_to_date:'' }}" name="to_date" id="to_date" type="date" class="form-control" placeholder="To Date" onchange="getAgentApplicationData()">
                        </div>
                        <div class="col-4">
                            <input value="{{ (!empty($search))?$search:'' }}" name="q" id="q" type="text" class="form-control" placeholder="Enter ID,Name,Email,Phone">
                        </div>
                        <div class="col-1">
                           <input type="submit" value="Filter" name="time" class="btn btn-warning">
                        </div>
                        <div class="col-1">
                           <a href="{{ URL::to('reset-agent-application-search') }}" class="btn btn-danger">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <h5 class="pt-3">All Application Here</h5>
        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Application ID</th>
                                    <th>Name</th>
                                    <th>Campus</th>
                                    <th>Is SubAgent Application</th>
                                    <th>SubAgent Name</th>
                                    <th>Create date</th>
                                    <th>Intake</th>
                                    <th>Make Note</th>
                                    <th>Application Status</th>
                                    <th>Interview Status</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($agent_applications as $row)
                                <tr class="{{ (!empty($get_application_id) && $get_application_id==$row->id)?'tr-bg':'' }}">
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
                                    <td>
                                        @if($row->sub_agent->role=="subAgent")
                                        <span>Yes</span>
                                        @else
                                        <span>No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->sub_agent->role=="subAgent")
                                        <span>{{ $row->sub_agent->name }}</span>
                                        @endif
                                    </td>
                                    <td>{{ date('F d Y',strtotime($row->created_at)) }}</td>
                                    <td>
                                        {{ date('F Y',strtotime($row->intake)) }}
                                    </td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#inputFormModal" href="javascript:void(0);" class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Write Note" onclick="writeNote('{{ $row->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                        </a>
                                    </td>
                                    <td>
                                        @if(!in_array(2,explode(",",$row->steps)))
                                        <span class="badge badge-warning">Document Missing</span>
                                        @elseif(!in_array(3,explode(",",$row->steps)))
                                        <span class="badge badge-warning">Application Not Submitted</span>
                                        @else
                                        <span class="badge badge-success">Application Submitted</span>
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
                                    <td>
                                        @if($row->application_status_id==1)
                                        <a href="{{ URL::to('agent-applications/'.$row->id.'/details') }}" class="badge badge-pill bg-primary">
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
                                            @else

                                            @endif

                                        @endif
                                        <a title="Document Upload" href="{{ URL::to('application-create/'.$row->id.'/step-2') }}" class="badge badge-pill bg-warning">
                                            <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-diff" viewBox="0 0 16 16">
                                                <path d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4zm-2.5 6.5A.5.5 0 0 1 6 10h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                                            </svg>
                                        </a>
                                        @if($row->sub_agent->role != "subAgent")
                                        <a data-bs-toggle="modal" data-bs-target="#transModal" href="javascript:void(0);" class="badge badge-pill bg-danger" onclick="transferAppication({{ $row->id }})">
                                            <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-app-indicator" viewBox="0 0 16 16">
                                                <path d="M5.5 2A3.5 3.5 0 0 0 2 5.5v5A3.5 3.5 0 0 0 5.5 14h5a3.5 3.5 0 0 0 3.5-3.5V8a.5.5 0 0 1 1 0v2.5a4.5 4.5 0 0 1-4.5 4.5h-5A4.5 4.5 0 0 1 1 10.5v-5A4.5 4.5 0 0 1 5.5 1H8a.5.5 0 0 1 0 1z"/>
                                                <path d="M16 3a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                            </svg>
                                        </a>
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
                            {{ $agent_applications->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<style>
    .form-control{
        padding: 0.45rem 1rem !important;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{{-- <script src="{{ asset('web/js/jquery.js') }}"></script> --}}
<script>
    //search agent application data
    function getAgentApplicationData(){
        var campus = $('#campus').val();
        var status = $('#status').val();
        var intake = $('#intake').val();
        var interview_status = $('#interview_status').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var sub_agent_id = $('#sub_agent_id').val();
        window.location = "{{ URL::to('agent-applications?campus=') }}" + campus + "&status=" + status + "&intake=" + intake + "&interview_status=" + interview_status + "&from_date=" + from_date + "&to_date=" + to_date "&sub_agent_id=" + sub_agent_id;
    }

</script>
@if($errors->has('application_note'))
<script>
    $(document).ready(function() {
        $('#inputFormModal').modal('show');
    });
</script>
@endif

@if($errors->has('sub_agent_id'))
<script>
$(document).ready(function() {
    $('#transModal').modal('show');
});
</script>

@endif
@stop
