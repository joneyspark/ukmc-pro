@extends('adminpanel')
@section('admin')
<style>
    .assignToBtn{
        color: #f7bd1a !important;
        margin-left: 14px;
        font-size: 15px !important;
    }
    .form-control{
        padding: 0.45rem 1rem !important;
        font-size: 13px !important;
    }
</style>
<link href="{{ asset('backend/src/plugins/src/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('backend/src/plugins/css/light/fullcalendar/custom-fullcalendar.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('backend/src/plugins/css/dark/fullcalendar/custom-fullcalendar.css') }}" rel="stylesheet" type="text/css">

<div class="modal fade inputForm-modal" id="inputFormModal1" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Transfer Application To Interviewer</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <form method="post" action="#" class="mt-0">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <div class="col">
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Role</label>
                            <input type="hidden" name="interviewer_user_id" value="" id="interviewer_user_id" />
                            {{-- <select id="assign_to_interviewer_user_id" name="assign_to_interviewer_user_id" class="form-control">
                                <option value="">Select Interviewer</option>
                                @foreach ($interviewer_list as $irow)
                                    <option value="{{ $irow->id }}">{{ $irow->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('assign_to_interviewer_user_id'))
                                <span class="text-danger">{{ $errors->first('assign_to_interviewer_user_id') }}</span>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</a>
                <button type="submit" class="btn btn-primary mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Confirm</button>
            </div>
        </form>
      </div>
    </div>
</div>
<div class="modal fade inputForm-modal" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Create Group</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <form method="post" action="#" class="mt-0">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <div class="col">
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Course</label>
                            <input type="hidden" name="interviewer_user_id" value="" id="interviewer_user_id" />
                            <select id="course_id" name="course_id" class="form-control">
                                <option value="">Select Course</option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Intake</label>
                            <select id="intake" name="intake" class="form-control">
                                <option value="">Select Intake</option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Group Name</label>
                            <input type="text" name="group_name" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</a>
                <button type="submit" class="btn btn-primary mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Confirm</button>
            </div>
        </form>
      </div>
    </div>
</div>
<div class="modal fade inputForm-modal" id="timeTableModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Create Timetable</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <form method="post" action="#" class="mt-0">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Course</label>
                                <select id="intake" name="intake" class="form-control">
                                    <option value="">Select Course</option>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Intake</label>
                                <input type="hidden" name="interviewer_user_id" value="" id="interviewer_user_id" />
                                <select id="course_id" name="course_id" class="form-control">
                                    <option value="">Select Intake</option>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Group</label>
                                <select id="intake" name="intake" class="form-control">
                                    <option value="">Select Group</option>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Subject</label>
                                <input type="hidden" name="interviewer_user_id" value="" id="interviewer_user_id" />
                                <select id="course_id" name="course_id" class="form-control">
                                    <option value="">Select Subject</option>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Module No</label>
                                <select id="intake" name="intake" class="form-control">
                                    <option value="">Select Module</option>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Location</label>
                                <input type="hidden" name="interviewer_user_id" value="" id="interviewer_user_id" />
                                <select id="course_id" name="course_id" class="form-control">
                                    <option value="">Select Location</option>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Stuff</label>
                                <select id="intake" name="intake" class="form-control">
                                    <option value="">Select Stuff</option>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Date</label>
                                <input class="form-control" type="datetime-local" name="interviewer_user_id" value="" id="interviewer_user_id" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Start Time</label>
                                <input class="form-control" type="time" name="interviewer_user_id" value="" id="interviewer_user_id" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">End Time</label>
                                <input class="form-control" type="time" name="interviewer_user_id" value="" id="interviewer_user_id" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-light-danger mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Cancel</a>
                <button type="submit" class="btn btn-primary mt-2 mb-2 btn-no-effect" data-bs-dismiss="modal">Confirm</button>
            </div>
        </form>
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
                                    <li class="breadcrumb-item"><a href="#">Teacher</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="p-3">Attendence Overview</h5>
        <div class="widget-content widget-content-area">
            <form method="get" action="">
                 <div class="row mb-2">
                     <div class="col-2">
                        <select id="assign_to_interviewer_user_id" name="assign_to_interviewer_user_id" class="form-control">
                            <option value="">Select Course</option>
                            <option value="">Course 1</option>
                        </select>
                     </div>
                     <div class="col-2">
                        <select id="assign_to_interviewer_user_id" name="assign_to_interviewer_user_id" class="form-control">
                            <option value="">Select Intake</option>
                            <option value="">Sep 2024</option>
                        </select>
                     </div>
                     <div class="col-2">
                        <select id="assign_to_interviewer_user_id" name="assign_to_interviewer_user_id" class="form-control">
                            <option value="">Select Group</option>
                            <option value="">Group 1</option>
                        </select>
                     </div>
                     <div class="col-2">
                        <select id="assign_to_interviewer_user_id" name="assign_to_interviewer_user_id" class="form-control">
                            <option value="">Select Subject</option>
                            <option value="">Subject 1</option>
                        </select>
                     </div>
                     <div class="col-2">
                        <select id="assign_to_interviewer_user_id" name="assign_to_interviewer_user_id" class="form-control">
                            <option value="">Select Campus</option>
                            <option value="">Campus 1</option>
                        </select>
                     </div>
                     <div class="col-2">
                        <select id="assign_to_interviewer_user_id" name="assign_to_interviewer_user_id" class="form-control">
                            <option value="">Select Teacher</option>
                            <option value="">Teacher 1</option>
                        </select>
                     </div>

                 </div>
                 <div class="row">
                    <div class="col-2">
                        <input value="{{ (!empty($get_name))?$get_name:'' }}" name="from_date" type="datetime-local" class="form-control">
                    </div>
                     <div class="col-2">
                        <input value="{{ (!empty($get_name))?$get_name:'' }}" name="to_date" type="datetime-local" class="form-control">
                    </div>
                    <div class="col-4">
                        <input value="{{ (!empty($get_name))?$get_name:'' }}" name="name" type="text" class="form-control" placeholder="Enter Schedue Title">
                    </div>
                    <div class="col-1">
                        <input type="submit" value="Filter" name="time" class="btn btn-warning">
                     </div>
                     <div class="col">
                        <a href="#" class="btn btn-danger">Reset</a>
                     </div>
                     <div class="col">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Create
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li><a data-bs-toggle="modal" data-bs-target="#timeTableModal" class="dropdown-item" href="#">Create Timetable</a></li>
                                    <li><a data-bs-toggle="modal" data-bs-target="#groupModal" class="dropdown-item" href="#">Create Group</a></li>
                                </ul>
                            </div>
                        </div>
                     </div>
                 </div>
            </form>
        </div>
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="row layout-top-spacing layout-spacing" id="cancel-row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="calendar-container">
                                <div class="calendar"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="">
                                                <label class="form-label">Enter Title</label>
                                                <input id="event-title" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12 d-none">
                                            <div class="">
                                                <label class="form-label">Enter Start Date</label>
                                                <input id="event-start-date" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12 d-none">
                                            <div class="">
                                                <label class="form-label">Enter End Date</label>
                                                <input id="event-end-date" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">

                                            <div class="d-flex mt-4">
                                                <div class="n-chk">
                                                    <div class="form-check form-check-primary form-check-inline">
                                                        <input class="form-check-input" type="radio" name="event-level" value="Work" id="rwork">
                                                        <label class="form-check-label" for="rwork">Work</label>
                                                    </div>
                                                </div>
                                                <div class="n-chk">
                                                    <div class="form-check form-check-warning form-check-inline">
                                                        <input class="form-check-input" type="radio" name="event-level" value="Travel" id="rtravel">
                                                        <label class="form-check-label" for="rtravel">Travel</label>
                                                    </div>
                                                </div>
                                                <div class="n-chk">
                                                    <div class="form-check form-check-success form-check-inline">
                                                        <input class="form-check-input" type="radio" name="event-level" value="Personal" id="rPersonal">
                                                        <label class="form-check-label" for="rPersonal">Personal</label>
                                                    </div>
                                                </div>
                                                <div class="n-chk">
                                                    <div class="form-check form-check-danger form-check-inline">
                                                        <input class="form-check-input" type="radio" name="event-level" value="Important" id="rImportant">
                                                        <label class="form-check-label" for="rImportant">Important</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">Update changes</button>
                                    <button type="button" class="btn btn-primary btn-add-event">Add Event</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<script src="{{ asset('web/js/jquery.js') }}"></script>
<script>
    function getInterviewerData(id){
        if(id===null){
            return false;
        }
        $('#interviewer_user_id').val(id);
    }
    function getAdmissionOfficer(){
        var manager_id = $('#manager_id').val();
        $.get('{{ URL::to('get-admission-officer-by-manager') }}/'+manager_id,function(data,status){
            if(data['result']['key']===200){
                console.log(data['result']['val']);
                $('#admission_officer_id').html(data['result']['val']);
            }
        });
    }
    function getAdmissionOfficerList(id){
        $('#from_admission_officer_id').val(id);
    }
    function change_password(id){
        $('#change_password_user_id').val(id);
    }
</script>
@if($errors->has('assign_to_interviewer_user_id'))
    <script>
        $(document).ready(function() {
            $('#inputFormModal1').modal('show');
        });
    </script>
@endif
@if($errors->has('manager_id') || $errors->has('admission_officer_id'))
    <script>
        $(document).ready(function() {
            $('#inputFormModal2').modal('show');
        });
    </script>
@endif
@if($errors->has('password_confirmation') || $errors->has('password_confirmation'))
    <script>
        $(document).ready(function() {
            $('#inputFormModal5').modal('show');
        });
    </script>
@endif
@stop
<script src="{{ asset('backend/src/plugins/src/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('backend/src/plugins/src/fullcalendar/custom-fullcalendar.js') }}"></script>
<script src="{{ asset('backend/src/plugins/src/uuid/uuid4.min.js') }}"></script>
