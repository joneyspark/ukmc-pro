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
                                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ URL::to('my-notification-list') }}">My Notifications</a></li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">

            <div class="usr-tasks ">
                <h5 class="p-3">All Activity List</h5>
                <div class="widget-content widget-content-area">
                    <form method="get" action="">
                            <div class="row mb-4">
                                <div class="col-3">
                                <select id="role" name="role" class="form-control" onchange="getUserByRole()">
                                    <option value="">Select Role</option>
                                    @foreach ($user_role as $row)
                                    <option {{ (!empty($get_role) && $get_role==$row['key'])?'selected':'' }} value="{{ $row['key'] }}">{{ $row['val'] }}</option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="col-4">
                                <select id="user_data" name="user_id" class="form-control">
                                    <option value="">Select User</option>
                                    @foreach ($user_list as $list)
                                        <option {{ (!empty($get_user_id) && $get_user_id==$list->id)?'selected':'' }} value="{{ $list->id }}">{{ $list->name.'-'.$list->role }}</option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="col-2">
                                <input value="{{ (!empty($get_from_date))?$get_from_date:'' }}" name="from_date" id="from_date" type="date" class="form-control" placeholder="From Date">
                                </div>
                                <div class="col-2">
                                <input value="{{ (!empty($get_to_date))?$get_to_date:'' }}" name="to_date" id="to_date" type="date" class="form-control" placeholder="To Date">
                                </div>

                            </div>
                            <div class="row mb-4">
                                <div class="col-5">
                                    <input value="{{ (!empty($get_application_id))?$get_application_id:'' }}" name="application_id" id="application_id" type="text" class="form-control" placeholder="Application ID">
                                </div>
                                <div class="col-1">
                                    <input type="submit" value="Filter" name="time" class="btn btn-warning">
                                </div>
                                <div class="col">
                                    <a href="{{ URL::to('reset-user-activity-list') }}" class="btn btn-danger">Reset</a>
                                </div>
                            </div>

                    </form>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Activity Description</th>
                                    <th>Activity Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($all_data as $row)
                                <tr class="">
                                    <td>
                                        <p>{{ $row->id }}</p>
                                    </td>
                                    <td>
                                        <p>{!! $row->description !!}<p class="t-time">{{ App\Models\Notification\Notification::timeLeft($row->create_date) }}</p></p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ date('Y-m-d',strtotime($row->created_at)) }}</p>
                                    </td>
                                </tr>
                                @empty
                                <tr>No Data Found</tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div style="text-align: center;" class="pagination-custom_solid">
                            {{ $all_data->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<style>
    .form-control{
        padding: 0.45rem 1rem !important;
        font-size: 13px !important;
    }
</style>
<script src="{{ asset('web/js/jquery.js') }}"></script>
<script>
    function getUserByRole(){
        var get_role = $('#role').val();
        $.get('{{ URL::to('get-user-by-role') }}/'+get_role,function(data,status){
            if(data['result']['key']===200){
                console.log(data['result']['val']);
                $('#user_data').html(data['result']['val']);
            }
        });
    }

</script>
@stop
