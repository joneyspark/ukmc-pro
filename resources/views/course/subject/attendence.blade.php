@extends('adminpanel')
@section('admin')
<div class="modal fade inputForm-modal" id="inputFormModal133" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Notes</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <div class="mt-0">
            <form id="schedule-note-formid" method="post">
                <div class="modal-body">
                    <div id="note-data">

                    </div>
                    <div class="form-group">
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Note:</label>
                                <input type="hidden" value="" name="note_application_id" id="note_application_id" />
                                <input type="hidden" value="" name="note_schedule_id" id="note_schedule_id" />
                                <textarea name="application_note" id="application_note" class="form-control" rows="2"></textarea>
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
                                    <li class="breadcrumb-item"><a href="#">Subject</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Student Attendance list</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="p-3">Student Attendance list</h5><a href="{{ URL::to('attendence-group-details/'.$group_id) }}" class="btn btn-primary">Back</a>


        <div class="row">
            <input type="hidden" id="get_note_schedule_id" name="get_note_schedule_id" value="{{ (!empty($schedule_id))?$schedule_id:'' }}" />
            @forelse ($applicants as $row)
            @php
                $getAttendenceConfirmation = App\Models\Course\AttendenceConfirmation::where('class_schedule_id',$schedule_id)->where('application_id',$row->application_data->id)->first();
                $checkAbsent = App\Models\Course\AuthorisedAbsent::where('application_id', $row->application_data->id)->whereDate('to_date', '>', $current_date)->where('status',0)->orderBy('id', 'desc')->first();
            @endphp
            <div class="col-3 mt-3">
                <input type="hidden" id="application_id{{ $row->application_data->id }}" name="application_id" value="{{ (!empty($row->application_data->id))?$row->application_data->id:'' }}" />
                <input type="hidden" id="schedule_id{{ $row->application_data->id }}" name="schedule_id" value="{{ (!empty($schedule_id))?$schedule_id:'' }}" />
                <div class="card style-2 mb-md-0 mb-4">
                    <div style="height: 80px;" class="row text-end">
                        @if(!empty($checkAbsent))
                        <p class="col-md-8">Authorised Leave From <span style="color:green;">{{ date('F d Y',strtotime($checkAbsent->from_date)) }}</span> to <span style="color: red;">{{ date('F d Y',strtotime($checkAbsent->to_date)) }}</span></p>
                        @endif
                        <div style="display: flex;" class="col-md-4">
                            <a onclick="get_schedule_notes('{{ $row->application_data->id }}', '{{ $schedule_id }}')" data-bs-toggle="modal" data-bs-target="#inputFormModal133" class="dropdown-item" href="javascript://"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                            <a class="dropdown-item" href="javascript://"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-view-stacked" viewBox="0 0 16 16">
                                <path d="M3 0h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zm0 8h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2m0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                              </svg></a>
                        </div>
                    </div>
                    <div class="text-center">
                        <img src="{{ asset('img/dummy-user.png') }}" class="card-img-top rounded-circle" alt="..." style="width: 120px">
                    </div>
                    <h6 class="text-center pt-3">{{ (!empty($row->application_data->name))?$row->application_data->name:'' }}</h6>
                    <p class="text-center">{{ (!empty($row->application_data->id))?$row->application_data->id:'' }}</p>
                    <div class="card-body px-0 pb-0 d-flex justify-content-between">
                        @if(!empty($getAttendenceConfirmation))
                            @if(empty($checkAbsent))
                                @if($getAttendenceConfirmation->application_status==1)
                                    <a onclick="presentCall({{ $row->application_data->id }})" id="present_id{{ $row->application_data->id }}" class="btn btn-success" href="javascript://"><h5>Pp</h5></a>
                                @else
                                    <a onclick="presentCall({{ $row->application_data->id }})" id="present_id{{ $row->application_data->id }}" class="btn btn-outline-success" href="javascript://"><h5>Pp</h5></a>
                                @endif
                                @if($getAttendenceConfirmation->application_status==2)
                                    <a onclick="absentCall({{ $row->application_data->id }})" id="absent_id{{ $row->application_data->id }}" class="btn btn-danger" href="javascript://"><h5>AB</h5></a>
                                @else
                                    <a onclick="absentCall({{ $row->application_data->id }})" id="absent_id{{ $row->application_data->id }}" class="btn btn-outline-danger" href="javascript://"><h5>AB</h5></a>
                                @endif
                            @endif

                            @if($getAttendenceConfirmation->application_status==3)
                                <a onclick="leaveCall({{ $row->application_data->id }})" id="leave_id{{ $row->application_data->id }}" class="btn btn-warning" href="javascript://"><h5>AA</h5></a>
                            @else
                                <a onclick="leaveCall({{ $row->application_data->id }})" id="leave_id{{ $row->application_data->id }}" class="btn btn-outline-warning" id="leave_id{{ $row->application_data->id }}" href="javascript://"><h5>AA</h5></a>
                            @endif
                        @else
                            @if(empty($checkAbsent))
                                <a onclick="presentCall({{ $row->application_data->id }})" id="present_id{{ $row->application_data->id }}" class="btn btn-outline-success" href="javascript://"><h5>Pp</h5></a>
                                <a onclick="absentCall({{ $row->application_data->id }})" id="absent_id{{ $row->application_data->id }}" class="btn btn-outline-danger" href="javascript://"><h5>AB</h5></a>
                            @endif
                            <a onclick="leaveCall({{ $row->application_data->id }})" id="leave_id{{ $row->application_data->id }}" class="btn btn-outline-warning" href="javascript://"><h5>AA</h5></a>
                        @endif

                    </div>
                </div>
            </div>
            @empty

            @endforelse
        </div>
        <div class="col-md-12">
            {{ $applicants->links() }}
        </div>
    </div>
</div>
<script src="{{ asset('web/js/jquery.js') }}"></script>
<script>
    function presentCall(p){

        var application_id = $('#application_id'+p).val();
        var schedule_id = $('#schedule_id'+p).val();
        var url = '{{ URL::to('class/schedule/present-call') }}';
        $.post(url,
        {
            application_id: application_id,
            schedule_id: schedule_id
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
                $('#present_id'+p).removeClass('btn-outline-success');
                $('#absent_id'+p).removeClass('btn-danger');
                $('#leave_id'+p).removeClass('btn-warning');
                $('#present_id'+p).addClass('btn-success');
                $('#absent_id'+p).addClass('btn-outline-danger');
                $('#leave_id'+p).addClass('btn-outline-warning');
            }
        });
    }
    function absentCall(p){

        var application_id = $('#application_id'+p).val();
        var schedule_id = $('#schedule_id'+p).val();
        var url = '{{ URL::to('class/schedule/absent-call') }}';
        $.post(url,
        {
            application_id: application_id,
            schedule_id: schedule_id
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
                    color: 'red',
                    balloon: true,
                    close: true,
                    progressBarColor: 'yellow',
                });
                $('#absent_id'+p).removeClass('btn-outline-danger');
                $('#absent_id'+p).addClass('btn-danger');

                $('#present_id'+p).removeClass('btn-success');
                $('#present_id'+p).addClass('btn-outline-success');

                $('#leave_id'+p).removeClass('btn-warning');
                $('#leave_id'+p).addClass('btn-outline-warning');
            }
        });
    }
    function leaveCall(p){
        var application_id = $('#application_id'+p).val();
        var schedule_id = $('#schedule_id'+p).val();
        var url = '{{ URL::to('class/schedule/leave-call') }}';
        $.post(url,
        {
            application_id: application_id,
            schedule_id: schedule_id
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
                    color: 'warning',
                    balloon: true,
                    close: true,
                    progressBarColor: 'yellow',
                });
                $('#absent_id'+p).addClass('btn-outline-danger');
                $('#absent_id'+p).removeClass('btn-danger');

                $('#present_id'+p).removeClass('btn-success');
                $('#present_id'+p).addClass('btn-outline-success');

                $('#leave_id'+p).addClass('btn-warning');
                $('#leave_id'+p).removeClass('btn-outline-warning');
            }
        });
    }
</script>
<script>
    function get_schedule_notes(id,schedule_id){
        if(id===null){
            return false;
        }
        //alert(id);
        $('#note_application_id').val(id);
        $('#note_schedule_id').val(schedule_id);
        $.get('{{ URL::to('class/schedule/get-notes') }}/'+id+'/'+schedule_id,function(data,status){
            if(data['result']['key']===200){
                console.log(data['result']['val']);
                $('#note-data').html(data['result']['val']);
            }
        });
    }
    function deleteMainNote1(id){
        if(confirm('Are You Sure To Delete Note Data')){
            $.get('{{ URL::to('class/schedule/note_delete') }}/'+id,function(data,status){
                if(data['result']['key']===101){
                    alert(data['result']['val']);
                }
                if(data['result']['key']===200){
                    console.log(data['result']['val']);
                    $('#note-data').html(data['result']['val']);
                }
            });
        }
    }
</script>
<script>
    $(document).ready(function() {
        $('#schedule-note-formid').validate({
            rules: {
                application_note: {
                    required: true
                },
            },
            messages: {
                application_note: {
                    required: "Note Field Is Required!"
                },
            },
            submitHandler: function(form) {
            $('#btn-note-submit').prop('disabled', true);
            var note_schedule_id = $('#note_schedule_id').val();
            var note_application_id = $('#note_application_id').val();
            var application_note = $('#application_note').val();
            $.post('{{ URL::to('class/schedule/schedule-note-post') }}',
                {
                    note_schedule_id: note_schedule_id,
                    note_application_id: note_application_id,
                    application_note: application_note,
                },
                function(data, status){
                    console.log(data);
                    console.log(status);
                    if(data['result']['key']===200){
                        iziToast.show({
                            title: 'Success:',
                            message: 'Successfully Create a New Note of Schedule!',
                            position: 'topRight',
                            timeout: 8000,
                            color: 'green',
                            balloon: true,
                            close: true,
                            progressBarColor: 'yellow',
                        });
                        $('#btn-note-submit').prop('disabled', false);
                        $('#note-data').html(data['result']['val']);
                        $('#application_note').val("");
                        $('#note_application_id').val(data['result']['application_id']);
                    }
                }).fail(function(xhr, status, error) {
                    // Error callback...
                    console.log(xhr.responseText);
                    console.log(status);
                    console.log(error);
                });
            }
        });
    });
</script>
@stop
