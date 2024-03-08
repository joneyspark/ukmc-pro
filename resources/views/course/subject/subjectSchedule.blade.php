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
                                    <li class="breadcrumb-item active" aria-current="page">Class Schedule</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="p-3">Subject Schedule List</h5>
        <div class="widget-content widget-content-area">
            <form method="post" action="{{ URL::to('course/subject/subject-schedule-data-post') }}" enctype="multipart/form-data">
                @csrf
                 <div class="row mb-4">
                     <div class="col-4">
                        <input type="text" name="title" value="{{ (!empty($subject_schedule_data->title))?$subject_schedule_data->title:'' }}" class="form-control" placeholder="Schedule Title">
                     </div>
                     <div class="col-4">
                         <input type="hidden" name="course_id" value="{{ (!empty($course_subject->course_id))?$course_subject->course_id:'' }}" />
                         <input type="hidden" name="subject_id" value="{{ (!empty($course_subject->id))?$course_subject->id:'' }}" />
                         <input type="hidden" name="subject_schedule_id" value="{{ (!empty($subject_schedule_data->id))?$subject_schedule_data->id:'' }}" />
                         <select name="schedule_date" class="form-control">
                            <option value="">--Select Days--</option>
                            @foreach ($days_list as $list)
                            <option {{ (!empty($subject_schedule_data->schedule_date) && $subject_schedule_data->schedule_date==$list)?'selected':'' }} value="{{ $list }}">{{ $list }}</option>
                            @endforeach
                         </select>
                     </div>
                 </div>
                 <div class="row mb-4">
                    <div style="display: flex;" class="col-3">
                        Time From: <input type="time" name="time_from" value="{{ (!empty($subject_schedule_data->time_from))?$subject_schedule_data->time_from:'' }}" class="form-control" placeholder="Schedule Title">
                    </div>
                    <div style="display: flex;" class="col-3">
                        Time To: <input type="time" name="time_to" value="{{ (!empty($subject_schedule_data->time_to))?$subject_schedule_data->time_to:'' }}" class="form-control" placeholder="Schedule Title">
                    </div>
                    <div class="col">
                        <input type="submit" class="btn btn-primary">
                     </div>
                 </div>

            </form>
        </div>
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <table id="zero-config" class="table dt-table-hover text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Schedule Title</th>
                                <th>Schedule Date</th>
                                <th>Class Schedule Time</th>
                                <th class="no-content">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subject_schedule_list as $row)
                            <tr class="">
                                <td>{{ (!empty($row->id))?$row->id:'' }}</td>
                                <td>{{ (!empty($row->title))?$row->title:'' }}</td>
                                <td>{{ (!empty($row->schedule_date))?$row->schedule_date:'' }}</td>
                                <th>{{ (!empty($row->time_from))?$row->time_from:'' }} - {{ (!empty($row->time_to))?$row->time_to:'' }}</th>
                                <td>
                                    <!--<a target="_blank" href="" class="badge badge-pill bg-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>-->
                                    <a href="{{ URL::to('subject/schedule/'.$main_subject_id.'/'.'edit/'.$row->id) }}" class="badge badge-pill bg-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
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

    </div>
</div>
<script src="{{ asset('web/js/jquery.js') }}"></script>
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
