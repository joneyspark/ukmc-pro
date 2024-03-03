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
                                    <li class="breadcrumb-item"><a href="#">Application</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Offer Request List</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="pt-3">Filter</h5>
        <div class="widget-content widget-content-area">
            <form method="get" action="">
                 <div class="row">
                    <div class="row mb-2">
                        <div class="col-3">
                           <select id="status_id" name="status_id" class="form-control">
                               <option value="">Select Status</option>
                               @if(count($statuses) > 0)
                               @foreach ($statuses as $status)
                               <option {{ (!empty($get_status_id) && $get_status_id==$status['id'])?'selected':'' }} value="{{ $status['id'] }}">{{ $status['value'] }}</option>
                               @endforeach
                               @endif
                           </select>
                        </div>
                        <div class="col-3">
                            <select id="intake" name="intake" class="form-control">
                                <option value="">Select Intake</option>
                                @if(count($intakes) > 0)
                                @foreach ($intakes as $intake)
                                <option {{ (!empty($get_intake) && $get_intake==$intake)?'selected':'' }} value="{{ $intake }}">{{ date('F y',strtotime($intake)) }}</option>
                                @endforeach
                                @endif
                            </select>
                         </div>
                         <div class="col-1">
                            <input type="submit" value="Filter" name="time" class="btn btn-warning">
                         </div>
                         <div class="col-1">
                            <a href="{{ URL::to('offer-request-list') }}" class="btn btn-danger">Reset</a>
                         </div>
                    </div>
                </div>
            </form>
        </div>

        <h5 class="pt-3">All Application Here</h5>

        <div class="row layout-top-spacing">
            @if(Auth::user()->role=='adminManager')
            <a data-bs-toggle="modal" data-bs-target="#assignToModal4" class="assignToDisplay assignToBtn dropdown-item" href="#">Transfer Application To Other Admission Officer</a>
            @endif

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Application ID</th>
                                    <th>Offer Status</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Campus</th>
                                    <th>Course</th>
                                    <th>Intake</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($application_list as $row)
                                <tr>
                                    <td>{{ (!empty($row->application->id)?$row->application->id:'') }}</td>
                                    <td>
                                        @if($row->accept==1)
                                        <span class="badge badge-success">Accepted</span>
                                        @elseif($row->accept==2)
                                        <span class="badge badge-danger">Declined</span>
                                        @else
                                        <span class="badge badge-warning">Deffered</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ (!empty($row->application->name)?$row->application->name:'') }}
                                    </td>
                                    <td>
                                        <span>{{ (!empty($row->application->email)?$row->application->email:'') }}</span>
                                    <td>
                                        <span>{{ (!empty($row->application->phone))?$row->application->phone:'' }}</span>
                                    </td>
                                    <td>{{ (!empty($row->application->campus->campus_name)?$row->application->campus->campus_name:'') }}</td>
                                    <td>{{ (!empty($row->application->course->course_name)?$row->application->course->course_name:'') }}</td>
                                    <td>{{ date('F Y',strtotime($row->application->intake)) }}</td>
                                    <td>
                                        <a href="{{ URL::to('application/'.$row->application->id.'/processing') }}" class="badge badge-pill bg-secondary">
                                            <svg style="color: white;" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.75 5H8.25C7.55964 5 7 5.58763 7 6.3125V19L12 15.5L17 19V6.3125C17 5.58763 16.4404 5 15.75 5Z" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </a>
                                        <a href="{{ URL::to('application-create/'.$row->application->id) }}" class="badge badge-pill bg-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                        </a>
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
    .assignToDisplay{
        display: none;
    }
    .assignToDisplay1{
        display: none;
    }
    .assignToBtn{
        color: #f7bd1a !important;
        margin-left: 14px;
        font-size: 15px !important;
    }
    .assignToBtn1{
        color: #f7bd1a !important;
        margin-left: 14px;
        font-size: 15px !important;
    }
    .form-control{
        padding: 0.45rem 1rem !important;
    }
</style>
<script src="{{ asset('web/js/jquery.js') }}"></script>

<script>
    function getMyApplicationData(){
        var campus = $('#campus').val();
        var agent = $('#agent').val();
        var officer = $('#officer').val();
        var status = $('#status').val();
        var intake = $('#intake').val();
        var interview_status = $('#interview_status').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        window.location = "{{ URL::to('my-applications?campus=') }}" + campus + "&agent=" + agent + "&officer=" + officer + "&status=" + status + "&intake=" + intake + "&interview_status=" + interview_status + "&from_date=" + from_date + "&to_date=" + to_date;
    }
</script>

<script>
    var selectedValues = [];
        $('.assign-to-adminmanager').on('change', function() {
        if ($(this).is(':checked')) {
            var value = $(this).val();
            selectedValues.push(value);
            $('.assignToDisplay').show();
            $('#assign_application_ids').val(selectedValues);
        } else {
            var valueIndex = selectedValues.indexOf($(this).val());
            if (valueIndex !== -1) {
                selectedValues.splice(valueIndex, 1);
            }
            if(selectedValues.length === 0){
                $('.assignToDisplay').hide();
            }
            $('#assign_application_ids').val(selectedValues);
        }

        var selectedValue = selectedValues.join(',');
        console.log(selectedValue);
        // Perform any further actions with the selected values
    });
</script>
@if($errors->has('assign_to_user_id'))
<script>
    $(document).ready(function() {
        $('#assignToModal').modal('show');
    });
</script>
@endif

@stop
