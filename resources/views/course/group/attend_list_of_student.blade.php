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
                                    <li class="breadcrumb-item"><a href="#">Group</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Attendence List Of Applicant</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="pt-3">Filter :- <span style="color: #f84538; font-size: 14px;">{{ $attend_list->total() }} Attendence found, Showing {{ $attend_list->firstItem() }} - {{ $attend_list->lastItem() }} of {{ $attend_list->total() }} results</span></h5>
        <div class="widget-content widget-content-area">
            <form method="get" action="">
                 <div class="row">
                     <div class="row">
                        <div class="col-6">
                            <select name="application_status" class="form-control">
                                <option value="">--Select--</option>
                                <option {{ (!empty($get_application_status) && $get_application_status==1)?'selected':'' }} value="1">Present</option>
                                <option {{ (!empty($get_application_status) && $get_application_status==2)?'selected':'' }} value="2">Absent</option>
                                <option {{ (!empty($get_application_status) && $get_application_status==3)?'selected':'' }} value="3">Authorised Absent</option>
                            </select>
                        </div>
                        <div class="col">
                           <input type="submit" value="Filter" name="time" class="btn btn-warning">
                        </div>

                        <div class="col">
                           <a href="{{ URL::to('attendence-groups') }}" class="btn btn-primary">Back</a>
                        </div>
                     </div>

                 </div>
            </form>
        </div>

        <h5 class="pt-3">All Attendence List Here</h5>

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Application ID</th>
                                    <th>Name</th>
                                    {{-- <th>Email</th>
                                    <th>Phone</th> --}}
                                    <th>Intake</th>
                                    <th>Group Name</th>
                                    <th>Course</th>
                                    <th>Subject</th>

                                    <th>Subject Module</th>
                                    <th>Class Date</th>
                                    <th>Application Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attend_list as $row)

                                <tr>

                                    <td>{{ (!empty($row->application->id))?$row->application->id:'' }}</td>
                                    <td>{{ (!empty($row->application->name))?$row->application->name:'' }}</td>
                                    {{-- <td>{{ (!empty($row->application->email)?$row->application->email:'') }}</td>
                                    <td>{{ (!empty($row->application->phone)?$row->application->phone:'') }}</td> --}}
                                    <td>{{ (!empty($row->intake_date))?date('F Y',strtotime($row->intake_date)):'' }}</td>
                                    <td>{{ (!empty($row->group->title))?$row->group->title:'' }}</td>
                                    <td>{{ (!empty($row->course->course_name)?$row->course->course_name:'') }}</td>
                                    <td>{{ (!empty($row->subject->title))?$row->subject->title:'' }}</td>
                                    <td>{{ (!empty($row->class_schedule->title)?$row->class_schedule->title:'') }}</td>
                                    <td>
                                        {{ (!empty($row->class_schedule->subject_schedule->schedule_date))?$row->class_schedule->subject_schedule->schedule_date:'' }} <span>( {{ (!empty($row->class_schedule->subject_schedule->time_from))?$row->class_schedule->subject_schedule->time_from:'' }} - {{ (!empty($row->class_schedule->subject_schedule->time_to))?$row->class_schedule->subject_schedule->time_to:'' }} )</span><br>
                                        <span>{{ (!empty($row->class_schedule->created_at))?date('F d Y',strtotime($row->class_schedule->created_at)):'' }}</span>
                                    </td>
                                    <td>
                                        @if ($row->application_status==1)
                                            <span class="badge badge-success">Present</span>
                                            @elseif($row->application_status==2)
                                            <span class="badge badge-danger">Absent</span>
                                            @elseif($row->application_status==3)
                                            <span class="badge badge-primary">Authorised Absent</span>
                                            @else
                                        @endif
                                    </td>
                                    {{-- <td style="display: flex;" class="flex space-x-2">
                                        <a href="{{ URL::to('application/'.$row->application_data->id.'/details') }}" class="ml-2 badge badge-danger">
                                            <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-view-list" viewBox="0 0 16 16">
                                                <path d="M3 4.5h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2m0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1zM1 2a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 2m0 12a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 14"/>
                                              </svg>
                                        </a>
                                        <a onclick="getApplicationData1('{{ (!empty($row->application_data->id))?$row->application_data->id:'' }}')" style="margin-left: 3px;" data-bs-toggle="modal" data-bs-target="#assignToGroupModal1" class="badge badge-primary dropdown-item ml-2" href="javascript://">
                                            <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-plus" viewBox="0 0 16 16">
                                                <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7"/>
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                            </svg>
                                        </a>
                                    </td> --}}
                                </tr>
                                @empty
                                    <tr>
                                        No Data Found
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                        <div style="text-align: center;" class="pagination-custom_solid">
                            {{ $attend_list->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <h5 class="pt-3">All Authorised Absent List</h5>
        <div class="row layout-top-spacing">
            <div class="col-xl-8 col-lg-8 col-sm-8  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Application ID</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Reason</th>
                                    <th>File</th>
                                    <th>Force Complete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($absent_list as $val)

                                <tr>

                                    <td>{{ (!empty($val->application_id)?$val->application_id:'') }}</td>
                                    <td>{{ (!empty($val->from_date)?date('F d Y',strtotime($val->from_date)):'') }}</td>
                                    <td>{{ (!empty($val->to_date)?date('F d Y',strtotime($val->to_date)):'') }}</td>
                                    <td>{{ (!empty($val->reason)?$val->reason:'') }}</td>
                                    <td>
                                        @if(!empty($val->file))
                                            <a href="{{ asset($val->file) }}" download>Download</a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                            <div class="input-checkbox">
                                                <span class="switch-chk-label label-left">On</span>
                                                <input {{ ($val->status==1)?'checked':'' }} data-action="{{ URL::to('authorised-absent-status-change') }}" data-id="{{ $val->id }}" class="authorised-attendence-status-change switch-input" type="checkbox"
                                                        role="switch" id="form-custom-switch-inner-text">
                                                <span class="switch-chk-label label-right">Off</span>
                                            </div>
                                        </div>
                                    </td>


                                </tr>
                                @empty
                                    <tr>
                                        No Data Found
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>

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
    .assignToDisplay1{
        display: none;
    }
    .assignToBtn1{
        color: #f7bd1a !important;
        margin-left: 14px;
        font-size: 15px !important;
    }
</style>
<script src="{{ asset('web/js/jquery.js') }}"></script>

<script>
    $(function(){
        $('.authorised-attendence-status-change').change(function(){
            var status = $(this).prop('checked') == true ? 1 : 0;
            var absent_id = $(this).data('id');
            var url = $(this).data('action');
                $.post(url,
                {
                    absent_id: absent_id,
                    status: status
                },
                function(data, status){
                    console.log(data);
                    if(data['result']['key']===101){
                        iziToast.show({
                            title: 'Status',
                            message: data['result']['val'],
                            position: 'topRight',
                            timeout: 8000,
                            color: 'red',
                            balloon: true,
                            close: true,
                            progressBarColor: 'yellow',
                        });
                    }
                    if(data['result']['key']===200){
                        iziToast.show({
                            title: 'Status',
                            message: data['result']['val'],
                            position: 'topRight',
                            timeout: 8000,
                            color: 'green',
                            balloon: true,
                            close: true,
                            progressBarColor: 'yellow',
                        });
                    }
                    //alert("Data: " + data + "\nStatus: " + status);
                });

        });
    });
</script>

@stop
