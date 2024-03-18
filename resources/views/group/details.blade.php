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
                                    <li class="breadcrumb-item"><a href="#">Attendence</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">List Of Group</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="pt-3">Filter</h5>
        <div class="widget-content widget-content-area">
            <div class="row">
                <div class="col-md-12">
                    <h5>Today is <span class="btn btn-primary">{{ $current_date }}</span></h5>
                    <span>Create Class Schedule Based On The Subject Schedule</span>
                    <input type="hidden" id="group_id" name="group_id" value="{{ (!empty($group_data->id))?$group_data->id:'' }}" />
                    <table class="table table-bordered table-responsive">
                        <tr>
                            <th>Course</th>
                            <th>Subject</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                        @forelse ($today_schedules as $trow)
                            <tr>
                                <td>{{ (!empty($trow->course->course_name))?$trow->course->course_name:'' }}</td>
                                <td>{{ (!empty($trow->subject->title))?$trow->subject->title:'' }}</td>
                                <td>{{ (!empty($trow->title))?$trow->title:'' }}</td>
                                <td>{{ (!empty($trow->schedule_date))?$trow->schedule_date:'' }}</td>
                                <td>{{ (!empty($trow->time_from))?$trow->time_from:'' }} - {{ (!empty($trow->time_to))?$trow->time_to:'' }}</td>
                                <td>
                                    <a href="javascript://" onclick="mainFunc({{ $trow->id }})" class="badge badge-pill bg-secondary">
                                        <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8.636 12.5a.5.5 0 0 1-.5.5H1.5A1.5 1.5 0 0 1 0 11.5v-10A1.5 1.5 0 0 1 1.5 0h10A1.5 1.5 0 0 1 13 1.5v6.636a.5.5 0 0 1-1 0V1.5a.5.5 0 0 0-.5-.5h-10a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h6.636a.5.5 0 0 1 .5.5z"/>
                                            <path fill-rule="evenodd" d="M16 15.5a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1 0-1h3.793L6.146 6.854a.5.5 0 1 1 .708-.708L15 14.293V10.5a.5.5 0 0 1 1 0v5z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty

                        @endforelse

                    </table>
                </div>
            </div>
        </div>
        <h5 class="pt-3">Attendence Schedule Here</h5>
        <div class="row layout-top-spacing">

            <div class="col-xl-7 col-lg-7 col-sm-7 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Schedule Create Date</th>
                                    <th>Schedule Day</th>
                                    <th>Schedule Time</th>
                                    <th>Is Complete</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($class_schedule_list as $srow)
                                <tr>
                                    <td>{{ (!empty($srow->title))?$srow->title:'' }}</td>
                                    <td>{{ (!empty($srow->schedule_date))?date('F d Y',strtotime($srow->schedule_date)):'' }}</td>
                                    <td>{{ (!empty($srow->subject_schedule->schedule_date))?$srow->subject_schedule->schedule_date:'' }}</td>
                                    <td>{{ (!empty($srow->time_from))?$srow->time_from:'' }} - {{ (!empty($srow->time_to))?$srow->time_to:'' }}</td>
                                    <td>
                                        <div
                                            class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                            <div class="input-checkbox">
                                                <span class="switch-chk-label label-left">Yes</span>
                                                <input {{ ($srow->is_done==1)?'checked':'' }} data-action="{{ URL::to('group-is-done-status-change') }}" data-id="{{ $srow->id }}" class="group-is-done-status-change switch-input" type="checkbox"
                                                                            role="switch" id="form-custom-switch-inner-text">
                                                <span class="switch-chk-label label-right">No</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ URL::to('group-attendence/'.$srow->id) }}" class="badge badge-pill bg-warning">
                                            <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8.636 12.5a.5.5 0 0 1-.5.5H1.5A1.5 1.5 0 0 1 0 11.5v-10A1.5 1.5 0 0 1 1.5 0h10A1.5 1.5 0 0 1 13 1.5v6.636a.5.5 0 0 1-1 0V1.5a.5.5 0 0 0-.5-.5h-10a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h6.636a.5.5 0 0 1 .5.5z"/>
                                                <path fill-rule="evenodd" d="M16 15.5a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1 0-1h3.793L6.146 6.854a.5.5 0 1 1 .708-.708L15 14.293V10.5a.5.5 0 0 1 1 0v5z"/>
                                            </svg>
                                        </a>
                                        <a target="_blank" href="{{ URL::to('subject/schedule-details/'.$srow->id) }}" class="badge badge-pill bg-danger">
                                            <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                                <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                                                <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                                                <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
                                              </svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-sm-5 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    @forelse($course_data->course_subjects as $key => $subject)
                    <nav class="breadcrumb-style-three  mb-3" aria-label="breadcrumb">
                        <span class="">{{ (!empty($subject->title))?$subject->title:'' }}</span>
                        @php
                            $sehedule_list = App\Models\Course\SubjectSchedule::where('subject_id',$subject->id)->orderBy('id','desc')->get();
                        @endphp
                        @foreach($sehedule_list as $key => $srow)
                        <ol class="breadcrumb mt-2">
                            <li class="breadcrumb-item">{{ (!empty($srow->title))?$srow->title:'' }}</li>
                            <li class="breadcrumb-item">{{ (!empty($srow->schedule_date))?$srow->schedule_date:'' }}</li>
                            <li class="breadcrumb-item active" aria-current="page">{{ (!empty($srow->time_from))?$srow->time_from:'' }} - {{ (!empty($srow->time_to))?$srow->time_to:'' }}</a></li>
                            <li class="breadcrumb-item">
                                <a class="badge badge-pill bg-secondary" onclick="subFunc({{ $srow->id }})" href="javascript://">
                                    <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8.636 12.5a.5.5 0 0 1-.5.5H1.5A1.5 1.5 0 0 1 0 11.5v-10A1.5 1.5 0 0 1 1.5 0h10A1.5 1.5 0 0 1 13 1.5v6.636a.5.5 0 0 1-1 0V1.5a.5.5 0 0 0-.5-.5h-10a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h6.636a.5.5 0 0 1 .5.5z"/>
                                        <path fill-rule="evenodd" d="M16 15.5a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1 0-1h3.793L6.146 6.854a.5.5 0 1 1 .708-.708L15 14.293V10.5a.5.5 0 0 1 1 0v5z"/>
                                    </svg>
                                </a>
                            </li>
                        </ol>
                        @endforeach
                    </nav>
                    @empty

                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>
<script src="{{ asset('web/js/jquery.js') }}"></script>
<script>
    function getIntakeData(){
        var getId = $('#course_id').val();
        $.get('{{ URL::to('get-intake-data') }}/'+getId,function(data,status){
            if(data['result']['key']===200){
                console.log(data['result']['val']);
                $('#get_intake_data').html(data['result']['val']);
            }
        });
    }
</script>
<script>
    $(function(){
       $('.group-data-status-change1').change(function(){
           var status = $(this).prop('checked') == true ? 0 : 1;
           var group_id = $(this).data('id');
           var url = $(this).data('action');
               $.post(url,
               {
                   group_id: group_id,
                   status: status
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
   <script>
    function mainFunc(x){
        if(confirm('Are You Sure To Create New Class Schedule For Attendence?')){
            var subject_schedule_id = x;
            var group_id = $('#group_id').val();
            console.log(x);
            console.log($('#group_id').val());
            window.location = "{{ URL::to('make-class-schedules?subject_schedule_id=') }}" + subject_schedule_id + "&group_id=" + group_id;
        }
    }
    function subFunc(x){
        if(confirm('Are You Sure To Create New Class Schedule For Attendence?')){
            var subject_schedule_id = x;
            var group_id = $('#group_id').val();
            console.log(x);
            console.log($('#group_id').val());
            window.location = "{{ URL::to('make-class-schedules?subject_schedule_id=') }}" + subject_schedule_id + "&group_id=" + group_id;
        }
    }
   </script>
   <script>
    $(function(){
       $('.group-is-done-status-change').change(function(){
           var status = $(this).prop('checked') == true ? 0 : 1;
           var class_schedule_id = $(this).data('id');
           var url = $(this).data('action');
               $.post(url,
               {
                   class_schedule_id: class_schedule_id,
                   status: status
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
