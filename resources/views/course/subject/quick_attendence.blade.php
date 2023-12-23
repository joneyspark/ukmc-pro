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
                                    <li class="breadcrumb-item"><a href="#">Course</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Class Schedule List</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="p-3">Class Schedule List</h5>
        <div class="widget-content widget-content-area">
            <form method="get">
                 <div class="row mb-4">
                     <div class="col-4">
                        <select name="course_id" id="course_id" class="form-control" onchange="getScheduleData()">
                            <option value="">Select Course</option>
                            @foreach ($course_list as $row)
                            <option {{ (!empty($get_course_id) && $get_course_id==$row->id)?'selected':'' }} value="{{ $row->id }}">{{ $row->course_name }}</option>
                            @endforeach
                        </select>
                     </div>
                     <div class="col-3">
                        <select name="intake_id" id="intake_id" class="form-control" onchange="getScheduleData()">
                            <option value="">--Select Intake--</option>
                            @forelse ($intake_list as $row1)
                            <option {{ (!empty($get_intake_id) && $get_intake_id==$row1->id)?'selected':'' }} value="{{ $row1->id }}">{{ $row1->title }}</option>
                            @empty

                            @endforelse
                        </select>
                     </div>
                     <div class="col-3">
                        <select name="subject_id" id="subject_id" class="form-control" onchange="getScheduleData()">
                            <option value="">--Select Subject--</option>
                            @forelse ($subject_list as $row2)
                            <option {{ (!empty($get_subject_id) && $get_subject_id==$row2->id)?'selected':'' }} value="{{ $row2->id }}">{{ $row2->title }}</option>
                            @empty

                            @endforelse
                        </select>
                     </div>
                     <div class="col-2">
                        <a href="{{ URL::to('reset-schedule-list') }}" class="btn btn-danger">Reset</a>
                     </div>
                 </div>
            </form>
        </div>
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div id="tabledata" class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Course Name</th>
                                    <th scope="col">Intake</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Class Schedule Date</th>
                                    <th scope="col">Class Time</th>
                                    <th scope="col">Is Done</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schedule_list as $course)
                                <tr>
                                    <td>{{ (!empty($course->id))?$course->id:'' }}</td>
                                    <td style="white-space: break-spaces !important;">{{ (!empty($course->course->course_name))?$course->course->course_name:'' }}</td>
                                    <td>{{ (!empty($course->intake->title))?$course->intake->title:'' }}</td>
                                    <td>{{ (!empty($course->subject->title))?$course->subject->title:'' }}</td>
                                    <td>{{ (!empty($course->intake_date))?date('F d Y',strtotime($course->intake_date)):'' }}</td>
                                    <td>{{ (!empty($course->time_from))?$course->time_from:'' }} - {{ (!empty($course->time_to))?$course->time_to:'' }}</td>
                                    <td>
                                        <div class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                            <div class="input-checkbox">
                                                <span class="switch-chk-label label-left">On</span>
                                                <input {{ ($course->is_done==1)?'checked':'' }} data-action="{{ URL::to('schedule-status-change') }}" data-id="{{ $course->id }}" class="schedule-status-change switch-input" type="checkbox"
                                                        role="switch" id="form-custom-switch-inner-text">
                                                <span class="switch-chk-label label-right">Off</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="flex space-x-2">
                                        <a target="_blank" href="{{ URL::to('subject/schedule-details/'.$course->id) }}" class="badge badge-pill bg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        </a>
                                        <a href="{{ URL::to('subject/attendance/'.$course->id) }}" class="badge badge-pill bg-danger">
                                            <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8.636 12.5a.5.5 0 0 1-.5.5H1.5A1.5 1.5 0 0 1 0 11.5v-10A1.5 1.5 0 0 1 1.5 0h10A1.5 1.5 0 0 1 13 1.5v6.636a.5.5 0 0 1-1 0V1.5a.5.5 0 0 0-.5-.5h-10a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h6.636a.5.5 0 0 1 .5.5z"></path>
                                                <path fill-rule="evenodd" d="M16 15.5a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1 0-1h3.793L6.146 6.854a.5.5 0 1 1 .708-.708L15 14.293V10.5a.5.5 0 0 1 1 0v5z"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>No Data Found</tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div style="text-align: center;" class="pagination-custom_solid">
                            {!! $schedule_list->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('web/js/jquery.js') }}"></script>
<script>
    function getScheduleData(){
        var course_id = $('#course_id').val();
        var intake_id = $('#intake_id').val();
        var subject_id = $('#subject_id').val();
        window.location = "{{ URL::to('class/schedule/quick-attendence?course_id=') }}" + course_id + "&intake_id=" + intake_id + "&subject_id=" + subject_id;
    }
</script>
<script>
    $(function(){
       $('.schedule-status-change').change(function(){
           var is_done = $(this).prop('checked') == true ? 1 : 0;
           var schedule_id = $(this).data('id');
           var url = $(this).data('action');
               $.post(url,
               {
                   schedule_id: schedule_id,
                   is_done: is_done
               },
               function(data, status){
                   console.log(data);
                   if(data['result']['key']===101){
                       iziToast.show({
                           title: 'Info',
                           message: data['result']['val'],
                           position: 'topRight',
                           timeout: 8000,
                           color: 'red',
                           balloon: true,
                           close: true,
                           progressBarColor: 'yellow',
                       });
                       setTimeout(function () {
                           location.reload(true);
                       }, 2000);
                   }
                   if(data['result']['key']===200){
                       iziToast.show({
                           title: 'Info',
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
