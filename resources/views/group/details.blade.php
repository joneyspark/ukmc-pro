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
                                    <a href="{{ URL::to('make-class-schedule-for-attendence/'.$trow->id) }}" class="badge badge-pill bg-secondary">
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
        <h5 class="pt-3">All Group Here</h5>
        <div class="row layout-top-spacing">

            <div class="col-xl-7 col-lg-7 col-sm-7 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Group ID</th>
                                    <th>Title</th>
                                    <th>No Of Student</th>
                                    <th>Is Complete</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            
                        </table>
                        
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-sm-5 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    
                    <nav class="breadcrumb-style-three  mb-3" aria-label="breadcrumb">
                        <span class="">Hello this is subject</span>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Library</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol>
                    </nav>
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
@stop
