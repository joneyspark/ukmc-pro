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
            <form action="{{ URL::to('move-to-another-group') }}" id="" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col">
                            <div class="form-group mb-4"><label for="exampleFormControlInput1">Assign To Group: </label>
                                <input type="hidden" name="assign_application_ids" id="assign_application_ids" />
                                <select name="group_id" id="group_id" class="form-select">
                                    <option value="" selected>--Select--</option>
                                    @forelse($get_group_list as $key => $value)
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
                                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="pt-3">Filter :- <span style="color: #f84538; font-size: 14px;">{{ $application_list->total() }} Application found, Showing {{ $application_list->firstItem() }} - {{ $application_list->lastItem() }} of {{ $application_list->total() }} results</span></h5>
        <div class="widget-content widget-content-area">
            <form method="get" action="">
                 <div class="row">
                     <div class="row">
                        <div class="col-6">
                            <input value="{{ (!empty($get_title))?$get_title:'' }}" name="title" id="title" type="text" class="form-control" placeholder="Enter ID,Name,Email,Phone">
                        </div>
                        <div class="col">
                           <input type="submit" value="Filter" name="time" class="btn btn-warning">
                        </div>
                        <div class="col">
                           <a href="{{ URL::to('reset-application-search/'.$group_id) }}" class="btn btn-danger">Reset</a>
                        </div>
                     </div>

                 </div>
            </form>
        </div>

        <h5 class="pt-3">All Application Here</h5>

        <div class="row layout-top-spacing">
            {{-- @if(Auth::user()->role=='manager')
            <a data-bs-toggle="modal" data-bs-target="#assignToModal" class="assignToDisplay assignToBtn dropdown-item" href="#">Assign To</a>
            @endif
            @if(Auth::user()->role=='admin')
            <a data-bs-toggle="modal" data-bs-target="#assignToModal1" class="assignToDisplay1 assignToBtn1 dropdown-item" href="#">Assign To</a>
            @endif

            @if(Auth::user()->role=='manager' || Auth::user()->role=='admin')
            <a data-bs-toggle="modal" data-bs-target="#assignToInterviewerModal" class="assignToDisplay2 assignToBtn2 dropdown-item" href="#">Assign To Interviewer</a>
            @endif --}}
            @if(Auth::check() && Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->role=='adminManager' || Auth::user()->role=='interviewer')
            <a data-bs-toggle="modal" data-bs-target="#assignToGroupModal" class="assignToDisplay1 assignToBtn1 dropdown-item" href="#">Move To Another Group</a>
            @endif
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="checkbox-area" scope="col">
                                    </th>
                                    <th>Application ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Group Name</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($application_list as $row)
                                <tr>
                                    <td>
                                        <div class="form-check form-check-primary">
                                            <input value="{{ (!empty($row->application_data->id)?$row->application_data->id:'') }}" class="assignto{{ $row->id }} form-check-input assign-to-group striped_child" type="checkbox">
                                        </div>
                                    </td>
                                    <td>{{ (!empty($row->application_data->id)?$row->application_data->id:'') }}</td>
                                    <td>{{ (!empty($row->application_data->name)?$row->application_data->name:'') }}</td>
                                    <td>{{ (!empty($row->application_data->email)?$row->application_data->email:'') }}</td>
                                    <td>{{ (!empty($row->application_data->phone)?$row->application_data->phone:'') }}</td>
                                    <td>{{ (!empty($row->group->title)?$row->group->title:'') }}</td>
                                    <td><span class="badge badge-success">Enrolled</span></td>
                                    <td class="flex space-x-2">
                                        <a href="{{ URL::to('application/'.$row->application_data->id.'/details') }}" class="badge badge-pill bg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
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

@if(Auth::user()->role=='admin')
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
@endif
@if($errors->has('group_id'))
<script>
    $(document).ready(function() {
        $('#assignToGroupModal').modal('show');
    });
</script>
@endif
@stop
