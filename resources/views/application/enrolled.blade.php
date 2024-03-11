@extends('adminpanel')
@section('admin')
<div class="modal fade inputForm-modal" id="assignToGroupModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Assign Application To Group</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <div class="mt-0">
            <form action="{{ URL::to('join-to-group') }}" id="" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Assign To Group: {{ (!empty($get_intake))?'Current Intake: '.date('F Y',strtotime($get_intake)):'' }}</label>
                                <input type="hidden" name="assign_application_ids" id="assign_application_ids" />
                                <select name="group_id" id="group_id" class="form-select">
                                    <option value="" selected>--Select--</option>
                                    @forelse($course_groups as $key => $value)
                                        <option value="{{ (!empty($value->id))?$value->id:'' }}">{{ (!empty($value->title))?$value->title.' (Total: '.$value->total_application_count.')':'' }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @if($errors->has('group_id'))
                                    <span class="text-danger">{{ $errors->first('group_id') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</a>
                    <button id="btn-note-submit" class="btn btn-primary mt-2 mb-2 btn-no-effect" >Submit</button>
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
                                    <li class="breadcrumb-item active" aria-current="page">Enrolled</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="pt-3">Filter: (Select Intake Then Assign Application To Group)</h5>
        <div class="widget-content widget-content-area">
            <form method="get" action="">
                 <div class="row">
                     <div class="row mb-2">
                        {{-- <div class="col-3">
                            <select id="campus" name="campus" class="form-control">
                                <option value="">Select Campus</option>
                                @if(count($campuses) > 0)
                                @foreach ($campuses as $campus1)
                                <option {{ (!empty($get_campus) && $get_campus==$campus1->id)?'selected':'' }} value="{{ $campus1->id }}">{{ $campus1->campus_name }}</option>
                                @endforeach
                                @endif
                            </select>
                         </div> --}}
                        <div class="col-3">
                            <select id="course_id" name="course_id" class="form-control">
                                <option value="">Select Course</option>
                                @if(count($courses) > 0)
                                @foreach ($courses as $course1)
                                <option {{ (!empty($get_course_id) && $get_course_id==$course1->id)?'selected':'' }} value="{{ $course1->id }}">{{ $course1->course_name }}</option>
                                @endforeach
                                @endif
                            </select>
                         </div>
                         <div class="col-2">
                            <select id="intake_id" name="intake_id" class="form-control">
                                <option value="">Select Intake</option>
                                @if(count($course_intakes) > 0)
                                @foreach ($course_intakes as $intake)
                                <option {{ (!empty($get_intake_id) && $get_intake_id==$intake->id)?'selected':'' }} value="{{ $intake->id }}">{{ date('F y',strtotime($intake->intake_date)) }}</option>
                                @endforeach
                                @endif
                            </select>
                         </div>
                         <div class="col-5">
                            <input value="{{ (!empty($search))?$search:'' }}" name="q" id="q" type="text" class="form-control" placeholder="Enter Name,Email,Phone">
                        </div>
                        <div class="col-1">
                           <input type="submit" value="Filter" name="time" class="btn btn-warning">
                        </div>
                        <div class="col-1">
                           <a href="{{ URL::to('reset-enrolled-application-search') }}" class="btn btn-danger">Reset</a>
                        </div>
                     </div>
                     
                 </div>
            </form>
        </div>
        <h5 class="pt-3">All Enrolled Application Here</h5>
        <div class="row layout-top-spacing">
            @if(Auth::check() && Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->role=='adminManager' || Auth::user()->role=='interviewer')
            <a data-bs-toggle="modal" data-bs-target="#assignToGroupModal" class="assignToDisplay1 assignToBtn1 dropdown-item" href="#">Assign To Group</a>
            @endif
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Application ID</th>
                                    <th>Name</th>
                                    <th>Campus</th>
                                    <th>Course</th>
                                    <th>Group</th>
                                    <th>Create date</th>
                                    <th>Intake</th>
                                    <th>Assign</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($application_list as $row)
                                <tr>
                                    <td>
                                        @php
                                            $check = App\Models\Course\JoinGroup::with(['group'])->where('application_id',$row->id)->first();
                                        @endphp
                                        @if(!$check)
                                            <div class="form-check form-check-primary">
                                                <input value="{{ (!empty($row->id)?$row->id:'') }}" class="assignto{{ $row->id }} form-check-input assign-to-group striped_child" type="checkbox">
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
                                                <span>{{ (!empty($row->email))?$row->email:'' }}</span><br>
                                                <span>{{ (!empty($row->phone))?$row->phone:'' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ (!empty($row->campus->campus_name)?$row->campus->campus_name:'') }}</td>
                                    <td>{{ (!empty($row->course->course_name)?$row->course->course_name:'') }}</td>
                                    <td>{{ (!empty($check->group->title))?$check->group->title:'' }}</td>
                                    <td>{{ date('F d Y',strtotime($row->created_at)) }}</td>
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
                                        @if (count($statuses) > 0)
                                            @foreach ($statuses as $srow)
                                                @if($row->status==$srow->id)
                                                <span class="shadow-none badge badge-danger">{{ $srow->title }}</span>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="flex space-x-2">
                                        @if($row->application_status_id==1)
                                        <a href="{{ URL::to('application/'.$row->id.'/details') }}" class="badge badge-pill bg-primary">
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
                                            @elseif(!in_array(4,explode(",",$row->steps)))
                                            <a href="{{ URL::to('application-create/'.$row->id.'/step-4') }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            @elseif(!in_array(5,explode(",",$row->steps)))
                                            <a href="{{ URL::to('application-create/'.$row->id.'/step-5') }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            @else

                                            @endif

                                        @endif
                                        @if(Auth::user()->role=='admin' || Auth::user()->id==$row->admission_officer_id)
                                        <span>
                                            <a href="{{ URL::to('application/'.$row->id.'/processing') }}" class="badge badge-pill bg-secondary">
                                                <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.75 5H8.25C7.55964 5 7 5.58763 7 6.3125V19L12 15.5L17 19V6.3125C17 5.58763 16.4404 5 15.75 5Z" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </a>
                                            <a href="{{ URL::to('application-create/'.$row->id) }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                        </span>
                                        @else
                                        <span class="action-spn{{ $row->id }} is-action-data">

                                            <a href="{{ URL::to('application-create/'.$row->id) }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                        </span>
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
    .form-control{
        padding: 0.45rem 1rem !important;
        font-size: 13px !important;
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
@if(Auth::user()->role=='admin' || Auth::user()->role=='manager')
    <script>
        var selectedValues = [];
        $('.assign-to-group').on('change', function() {
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
    @if($errors->has('group_id'))
    <script>
        $(document).ready(function() {
            $('#assignToGroupModal').modal('show');
        });
    </script>
    @endif
@endif
@stop
