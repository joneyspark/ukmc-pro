@extends('adminpanel')
@section('admin')
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
                                    <li class="breadcrumb-item"><a href="#">Subject</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Student Attendance list</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="p-3">Student Attendance list</h5>

        <div class="row">
            @forelse ($applicants as $row)
            <div class="col-3 mt-3">
                <input type="hidden" id="application_id{{ $row->id }}" name="application_id" value="{{ (!empty($row->id))?$row->id:'' }}" />
                <input type="hidden" id="schedule_id{{ $row->id }}" name="schedule_id" value="{{ (!empty($schedule_id))?$schedule_id:'' }}" />
                <div class="card style-2 mb-md-0 mb-4">
                    <div class="text-end">
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                    </div>
                    <div class="text-center">
                        <img src="https://bheuni.io/front/img/teams/tanvir.png" class="card-img-top rounded-circle" alt="..." style="width: 120px">
                    </div>
                    <h6 class="text-center pt-3">{{ (!empty($row->name))?$row->name:'' }}</h6>
                    <p class="text-center">{{ (!empty($row->id))?$row->id:'' }}</p>
                    <div class="card-body px-0 pb-0 d-flex justify-content-between">
                        @if(!empty($row->applicant_attendence))
                            @if($row->applicant_attendence->application_status==1)
                                <a onclick="presentCall({{ $row->id }})" id="present_id{{ $row->id }}" class="btn btn-success" href="javascript://"><h4>P</h4></a>
                            @else
                                <a onclick="presentCall({{ $row->id }})" id="present_id{{ $row->id }}" class="btn btn-outline-success" href="javascript://"><h4>P</h4></a>
                            @endif
                            @if($row->applicant_attendence->application_status==2)
                                <a onclick="absentCall({{ $row->id }})" id="absent_id{{ $row->id }}" class="btn btn-danger" href="javascript://"><h4>A</h4></a>
                            @else
                                <a onclick="absentCall({{ $row->id }})" id="absent_id{{ $row->id }}" class="btn btn-outline-danger" href="javascript://"><h4>A</h4></a>
                            @endif
                            @if($row->applicant_attendence->application_status==3)
                                <a onclick="leaveCall({{ $row->id }})" id="leave_id{{ $row->id }}" class="btn btn-warning" href="javascript://"><h4>L</h4></a>
                            @else
                                <a onclick="leaveCall({{ $row->id }})" id="leave_id{{ $row->id }}" class="btn btn-outline-warning" id="leave_id{{ $row->id }}" href="javascript://"><h4>L</h4></a>
                            @endif
                        @else
                            <a onclick="presentCall({{ $row->id }})" id="present_id{{ $row->id }}" class="btn btn-outline-success" href="javascript://"><h4>P</h4></a>
                            <a onclick="absentCall({{ $row->id }})" id="absent_id{{ $row->id }}" class="btn btn-outline-danger" href="javascript://"><h4>A</h4></a>
                            <a onclick="leaveCall({{ $row->id }})" id="leave_id{{ $row->id }}" class="btn btn-outline-warning" href="javascript://"><h4>L</h4></a>
                        @endif

                    </div>
                </div>
            </div>
            @empty

            @endforelse
        </div>
    </div>
</div>

@stop
