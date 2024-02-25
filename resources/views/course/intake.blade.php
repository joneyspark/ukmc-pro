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
                                    <li class="breadcrumb-item active" aria-current="page">Course Intake</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="p-3">Course Intake List</h5>
        <div class="widget-content widget-content-area">
            <form method="post" action="{{ URL::to('course/intake/data-post') }}" enctype="multipart/form-data">
                @csrf
                 <div class="row mb-4">
                     <div class="col-3">
                         <input type="hidden" value="{{ (!empty($intake_data->id))?$intake_data->id:'' }}" name="intake_id" />
                         <input type="hidden" value="{{ (!empty($course_id))?$course_id:'' }}" name="course_id" />
                         <input type="text" name="title" value="{{ (!empty($intake_data->title))?$intake_data->title:old('title') }}" class="form-control" placeholder="Course Intake Name">
                         @if($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                         @endif
                     </div>
                     <div class="col-3">
                         <select name="intake_date" class="form-control">
                            <option value="">--Select--</option>
                            @foreach ($intake_list as $row)
                            <option {{ (!empty($intake_data->intake_date) && $intake_data->intake_date==$row->value)?'selected':'' }} value="{{ $row->value }}">{{ date('F Y',strtotime($row->title)) }}</option>
                            @endforeach
                         </select>
                         @if($errors->has('intake_date'))
                            <span class="text-danger">{{ $errors->first('intake_date') }}</span>
                         @endif
                     </div>
                     <div class="col-4">
                        <input type="text" name="description" value="{{ (!empty($intake_data->description))?$intake_data->description:old('description') }}" class="form-control" placeholder="Course Short Description">
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
                                <th>Intake Title</th>
                                <th>Intake</th>
                                <th>Intake Description</th>
                                <th>Status</th>
                                <th class="no-content">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($intakes as $row)
                            <tr class="">
                                <td>{{ $row->id }}</td>
                                <td>{{ (!empty($row->title))?$row->title:'' }}</td>
                                <td>{{ (!empty($row->intake_date))?$row->intake_date:'' }}</td>
                                <td>{{ (!empty($row->description))?$row->description:'' }}</td>
                                <td>
                                    <div class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                        <div class="input-checkbox">
                                            <span class="switch-chk-label label-left">On</span>
                                            <input {{ ($row->status==0)?'checked':'' }} data-action="{{ URL::to('course/change-intake-status') }}" data-id="{{ $row->id }}" class="intake-status-change switch-input" type="checkbox"
                                                    role="switch" id="form-custom-switch-inner-text">
                                            <span class="switch-chk-label label-right">Off</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ URL::to('course-intake-group-list/'.$row->id) }}" class="badge badge-pill bg-warning">
                                        <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8.636 12.5a.5.5 0 0 1-.5.5H1.5A1.5 1.5 0 0 1 0 11.5v-10A1.5 1.5 0 0 1 1.5 0h10A1.5 1.5 0 0 1 13 1.5v6.636a.5.5 0 0 1-1 0V1.5a.5.5 0 0 0-.5-.5h-10a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h6.636a.5.5 0 0 1 .5.5z"/>
                                            <path fill-rule="evenodd" d="M16 15.5a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1 0-1h3.793L6.146 6.854a.5.5 0 1 1 .708-.708L15 14.293V10.5a.5.5 0 0 1 1 0v5z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ URL::to('course/intake/'.$row->course_id.'/'.'edit/'.$row->id) }}" class="badge badge-pill bg-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty

                            @endforelse

                        </tbody>
                    </table>
                    <div class="col-md-12">
                        {{ $intakes->links() }}
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<script src="{{ asset('web/js/jquery.js') }}"></script>
<script>
    $(function(){
       $('.intake-status-change').change(function(){
           var status = $(this).prop('checked') == true ? 0 : 1;
           var intake_id = $(this).data('id');
           var url = $(this).data('action');
               $.post(url,
               {
                   intake_id: intake_id,
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
