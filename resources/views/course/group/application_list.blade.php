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
                                    <li class="breadcrumb-item"><a href="#">Application</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="pt-3">Filter :- <span style="color: #f84538; font-size: 14px;">{{ $application_list->total() }} Application found, Showing {{ $application_list->firstItem() }} - {{ $application_list->lastItem() }} of {{ $application_list->total() }} results</span></h5>
        <div class="widget-content widget-content-area">
            <form method="get" action="">
                 <div class="row">
                     <div class="row">
                        <div class="col-3">
                            <input value="{{ (!empty($get_title))?$get_title:'' }}" name="title" id="title" type="text" class="form-control" placeholder="Enter ID,Name,Email,Phone">
                        </div>
                        <div class="col">
                           <input type="submit" value="Filter" name="time" class="btn btn-warning">
                        </div>
                        <div class="col">
                           <a href="{{ URL::to('reset-application-search/'.$group_id) }}" class="btn btn-danger">Reset</a>
                        </div>
                     </div>

                 </div>
            </form>
        </div>

        <h5 class="pt-3">All Application Here</h5>

        <div class="row layout-top-spacing">
            @if(Auth::user()->role=='manager')
            <a data-bs-toggle="modal" data-bs-target="#assignToModal" class="assignToDisplay assignToBtn dropdown-item" href="#">Assign To</a>
            @endif
            @if(Auth::user()->role=='admin')
            <a data-bs-toggle="modal" data-bs-target="#assignToModal1" class="assignToDisplay1 assignToBtn1 dropdown-item" href="#">Assign To</a>
            @endif

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
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Level Of Education</th>
                                    <th>Nationality</th>
                                    @if(!empty($get_other_nationality) && $get_other_nationality=='Other')
                                    <th>Other Nationality</th>
                                    @endif
                                    <th>Disability</th>
                                    <th>Campus</th>
                                    <th>Course</th>
                                    <th>Create date</th>
                                    <th>Follow Up</th>
                                    <th>Intake</th>
                                    <th>Assign</th>
                                    <th>Interviewer</th>
                                    <th>Interview Status</th>
                                    <th>Status</th>
                                    <th>Application Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($application_list as $row)
                                <tr>
                                    <td>
                                        @if($row->admission_officer_id == 0)
                                        <div class="form-check form-check-primary">
                                            <input value="{{ (!empty($row->id)?$row->id:'') }}" class="assignto{{ $row->id }} form-check-input assign-to-adminmanager striped_child" type="checkbox">
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
                                                <span>{{ (!empty($row->gender))?$row->gender :'' }} </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ (!empty($row->email))?$row->email:'' }}</span>
                                    </td>
                                    <td>
                                        <span>{{ (!empty($row->phone))?$row->phone:'' }}</span>
                                    </td>

                                    <td>
                                        @if($row->is_academic==1)
                                        <span>Academic</span>
                                        @else
                                        <span>Non-Academic</span>
                                        @endif
                                    </td>
                                    <td>{{ (!empty($row->nationality))?$row->nationality :'' }}</td>
                                    @if(!empty($get_other_nationality) && $get_other_nationality=='Other')
                                        <td>{{ (!empty($row->other_nationality))?$row->other_nationality :'' }}</td>
                                    @endif
                                    <td>{{ (!empty($row->step2Data->disabilities))?$row->step2Data->disabilities :'' }}</td>
                                    <td>{{ (!empty($row->campus->campus_name)?$row->campus->campus_name:'') }}</td>
                                    <td>{{ (!empty($row->course->course_name)?$row->course->course_name:'') }}</td>
                                    <td>{{ date('F d Y',strtotime($row->created_at)) }}</td>
                                    <td>
                                        @if(Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->id==$row->admission_officer_id)
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
                                        @if(Auth::user()->role=='adminManager')
                                            @if($row->admission_officer_id==0 || $row->admission_officer_id==Auth::user()->id)
                                            <div
                                                class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                                <div class="input-checkbox">
                                                    <span class="switch-chk-label label-left">On</span>
                                                    <input {{ ($row->admission_officer_id==Auth::user()->id)?'checked':'' }} data-action="{{ URL::to('application/assign-to-me') }}" data-id="{{ $row->id }}" class="assign-to-me-status switch-input" type="checkbox"
                                                                                role="switch" id="form-custom-switch-inner-text">
                                                    <span class="switch-chk-label label-right">Off</span>
                                                </div>
                                            </div>
                                            @else
                                            <span>
                                                {{ (!empty($row->assign->name))?$row->assign->name:'' }}
                                            </span>
                                            @endif
                                        @endif
                                        @if(Auth::user()->role=='admin')
                                        <span>
                                            {{ (!empty($row->assign->name))?$row->assign->name:'' }}
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->interviewer_id > 0)
                                        <span>
                                            {{ (!empty($row->interviewer->name))?$row->interviewer->name:'' }}
                                        </span>
                                        @else
                                        <div class="form-check form-check-primary">
                                            <input value="{{ (!empty($row->id)?$row->id:'') }}" class="assigntointerviewer{{ $row->id }} assign-to-interviewer form-check-input striped_child" type="checkbox">
                                        </div>
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
                                        @if(!in_array(2,explode(",",$row->steps)))
                                        <span class="badge badge-warning">Document Missing</span>
                                        @elseif(!in_array(3,explode(",",$row->steps)))
                                        <span class="badge badge-warning">Application Not Submitted</span>
                                        @else
                                        <span class="badge badge-success">Application Ready</span>
                                        @endif
                                    </td>
                                    <td class="flex space-x-2">
                                        @if($row->application_status_id==1)
                                        <a href="{{ URL::to('application/'.$row->id.'/details') }}" class="badge badge-pill bg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        </a>
                                        @else
                                            @if(!in_array(2,explode(",",$row->steps)))
                                            <a href="{{ URL::to('application-create/'.$row->id.'/step-2') }}" class="badge badge-pill bg-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            @elseif(!in_array(3,explode(",",$row->steps)))
                                            <a href="{{ URL::to('application-create/'.$row->id.'/step-3') }}" class="badge badge-pill bg-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            @else

                                            @endif

                                        @endif
                                        @if(Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->id==$row->admission_officer_id)
                                        <span>
                                            @if($row->application_status_id==1)
                                            <a href="{{ URL::to('application/'.$row->id.'/processing') }}" class="badge badge-pill bg-secondary">
                                                <svg style="color: white;" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.75 5H8.25C7.55964 5 7 5.58763 7 6.3125V19L12 15.5L17 19V6.3125C17 5.58763 16.4404 5 15.75 5Z" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </a>
                                            <a href="{{ URL::to('application-create/'.$row->id) }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>

                                            @endif
                                        </span>
                                        @else
                                        <span class="action-spn{{ $row->id }} is-action-data">

                                            <a href="{{ URL::to('application-create/'.$row->id) }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                        </span>
                                        @endif

                                        @if(Auth::user()->role=='admin')
                                        <a onclick="if(confirm('Are you sure to Delete this Application?')) location.href='{{ URL::to('delete-application/'.$row->id) }}'; return false;" href="javascript:void(0)" class="">
                                            <span class="badge badge-pill badge-danger custom-btn-branch me-1">
                                                <svg style="color: rgb(245, 229, 229);" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2  delete-multiple"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </span>
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
    .assignToDisplay{
        display: none;
    }
    .assignToDisplay1{
        display: none;
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
    .form-control{
        padding: 0.45rem 1rem !important;
        font-size: 13px !important;
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
@if(Auth::user()->role=='manager')
    <script>
        var selectedValues = [];
        $('.assign-to-adminmanager').on('change', function() {
        if ($(this).is(':checked')) {
            var value = $(this).val();
            selectedValues.push(value);
            $('.assignToDisplay').show();
            $('#assign_application_ids').val(selectedValues);
        } else {
            var valueIndex = selectedValues.indexOf($(this).val());
            if (valueIndex !== -1) {
                selectedValues.splice(valueIndex, 1);
            }
            if(selectedValues.length === 0){
                $('.assignToDisplay').hide();
            }
            $('#assign_application_ids').val(selectedValues);
        }

        var selectedValue = selectedValues.join(',');
        console.log(selectedValue);
        // Perform any further actions with the selected values
    });
    </script>
    @if($errors->has('assign_to_user_id'))
    <script>
        $(document).ready(function() {
            $('#assignToModal').modal('show');
        });
    </script>
    @endif
@endif

@if(Auth::user()->role=='admin')
    <script>
        var selectedValues = [];
        $('.assign-to-adminmanager').on('change', function() {
        if ($(this).is(':checked')) {
            var value = $(this).val();
            selectedValues.push(value);
            $('.assignToDisplay1').show();
            $('#assign_application_ids').val(selectedValues);
        } else {
            var valueIndex = selectedValues.indexOf($(this).val());
            if (valueIndex !== -1) {
                selectedValues.splice(valueIndex, 1);
            }
            if(selectedValues.length === 0){
                $('.assignToDisplay1').hide();
            }
            $('#assign_application_ids').val(selectedValues);
        }

        var selectedValue = selectedValues.join(',');
        console.log(selectedValue);
        // Perform any further actions with the selected values
    });
    </script>
    @if($errors->has('assign_to_admission_manager_id') || $errors->has('assign_to_manager_id'))
    <script>
        $(document).ready(function() {
            $('#assignToModal1').modal('show');
        });
    </script>
    @endif
    <script>
        function getAdmissionOfficer(){
            var getId = $('#assign_to_manager_id').val();
            $.get('{{ URL::to('get-admission-officer-by-manager') }}/'+getId,function(data,status){
                if(data['result']['key']===200){
                    console.log(data['result']['val']);
                    $('#assign_to_admission_manager_id').html(data['result']['val']);
                }
            });
        }
    </script>
@endif

@stop
