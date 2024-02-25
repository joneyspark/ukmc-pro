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
                                    <li class="breadcrumb-item active" aria-current="page">Create Course Group</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="p-3">Create Course Group</h5>
        <div class="widget-content widget-content-area">
            <form method="post" action="{{ URL::to('course/group-data-post') }}" enctype="multipart/form-data">
                @csrf
                 <div class="row mb-3">
                     <div class="col-7">
                         <input type="hidden" name="intake_id" value="{{ (!empty($intake_id))?$intake_id:'' }}" />
                         <input type="hidden" name="group_id" value="{{ (!empty($group_data->id))?$group_data->id:'' }}" />
                         <input type="text" name="title" value="{{ (!empty($group_data->title))?$group_data->title:'' }}" class="form-control" placeholder="Group Title">
                         @if($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                         @endif
                     </div>
                     <div class="col">
                        <input type="submit" class="btn btn-primary">
                        <a class="btn btn-danger float-first" href="{{ URL::to('course-intake-group-list/'.$intake_id) }}">Back To Group List</a>
                     </div>
                 </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('web/js/jquery.js') }}"></script>
<script>
    $(function(){
       $('.subject-status-change').change(function(){
           var status = $(this).prop('checked') == true ? 0 : 1;
           var subject_id = $(this).data('id');
           var url = $(this).data('action');
               $.post(url,
               {
                   subject_id: subject_id,
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
        function get_another_intake_data(){
            var intake_id = $('#intake_id').val();
            $('#current_intake').val(intake_id);
				$.get("{{ URL::to('get-intake-list') }}/"+intake_id,function(data,status){
					if(data['result']['key']===101){
						alert(data['result']['val']);
					}
					if(data['result']['key']===200){
						console.log(data['result']['val']);
						$('#another_intake').html(data['result']['val']);
					}
				});
        }
   </script>
   @if($errors->has('assign_to_admission_manager_id') || $errors->has('assign_to_manager_id'))
   <script>
       $(document).ready(function() {
           $('#assignToModal1').modal('show');
       });
   </script>
   @endif
@stop
