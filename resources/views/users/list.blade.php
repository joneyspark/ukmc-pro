@extends('adminpanel')
@section('admin')
<div class="modal fade inputForm-modal" id="inputFormModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Chnage Role Form</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <form method="post" action="{{ URL::to('user-role-confirm') }}" class="mt-0">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <div class="col">
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Role</label>
                            <input type="hidden" name="user_id" value="" id="user_id" />
                            <select id="role_id" name="roll_name" class="form-control">
                                <option value="">Select Role</option>
                                @foreach ($role_list as $row)
                                    <option value="{{ $row['key'] }}">{{ $row['val'] }}</option>
                                @endforeach
                            </select>
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
                                    <li class="breadcrumb-item"><a href="#">Application</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="p-3">User List</h5>
        <div class="widget-content widget-content-area">
            <form method="get" action="">
                 <div class="row mb-4">
                     <div class="col-4">
                        <select name="role" class="form-control">
                            <option value="">Select Role</option>
                            @foreach ($role_list as $row)
                                <option {{ (!empty($get_role) && $get_role==$row['key'])?'selected':'' }} value="{{ $row['key'] }}">{{ $row['val'] }}</option>
                            @endforeach
                        </select>
                     </div>
                     <div class="col-4">
                         <input value="{{ (!empty($get_name))?$get_name:'' }}" name="name" type="text" class="form-control" placeholder="Enter Name">
                     </div>
                     <div class="col-1">
                        <input type="submit" value="Filter" name="time" class="btn btn-warning">
                     </div>
                     <div class="col">
                        <a href="{{ route('reset_user_list') }}" class="btn btn-danger">Reset</a>
                     </div>
                     <div class="col">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Create
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" href="{{ URL::to('create-manager') }}">Manager</a></li>
                                <li><a class="dropdown-item" href="{{ URL::to('create-admission-manager') }}">Admission Officer</a></li>
                                @if(Auth::user()->role=='admin' || Auth::user()->role=='manager')
                                <li><a class="dropdown-item" href="{{ URL::to('create-interviewer') }}">Interviewer</a></li>
                                @endif
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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Role</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($user_list_data as $row)
                                <tr class="{{ (!empty($return_user_id) && $return_user_id==$row->id)?'tr-bg':'' }}">
                                    <td>
                                        <div class="media">
                                            <div class="avatar me-2">
                                                @if($row->photo)
                                                <img alt="avatar" src="{{ asset($row->photo) }}" class="rounded-circle" />
                                                @else
                                                <img alt="avatar" src="{{ asset('web/avatar/user.png') }}" class="rounded-circle" />
                                                @endif
                                            </div>
                                            <div class="media-body align-self-center">
                                                <h6 class="mb-0">{{ (!empty($row->name))?$row->name:'' }}</h6>
                                                <span>{{ (!empty($row->email))?$row->email:'' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ (!empty($row->phone))?$row->phone:'' }}
                                    </td>
                                    <td>
                                        @if($row->role=='admin')
                                        <span class="text-success">Super Admin</span>
                                        @elseif($row->role=='adminManager')
                                        <span class="text-success">Admission Officer</span>
                                        @elseif($row->role=='manager')
                                        <span class="text-success">Manager</span>
                                        @elseif($row->role=='interviewer')
                                        <span class="text-success">Interviewer</span>
                                        @elseif($row->role=='teacher')
                                        <span class="text-success">Teacher</span>
                                        @elseif($row->role=='student')
                                        <span class="text-success">Student</span>
                                        @else
                                        @endif


                                    </td>
                                    <td class="text-center">
                                        <div class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                            <div class="input-checkbox">
                                                <span class="switch-chk-label label-left">On</span>
                                                <input {{ ($row->active==1)?'checked':'' }} data-action="{{ URL::to('user-status-chnage') }}" data-id="{{ $row->id }}" class="user-status-chnage switch-input" type="checkbox"
                                                    role="switch" id="form-custom-switch-inner-text">
                                                <span class="switch-chk-label label-right">Off</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-btns">
                                            @if ($row->role != 'student')
                                            <a onclick="getRoleData({{ $row->id }})" data-id="{{ $row->role }}" data-bs-toggle="modal" data-bs-target="#inputFormModal"  class="get-roll-data{{ $row->id }} badge badge-pill bg-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            </a>
                                            @endif

                                            @if($row->role=='manager')
                                            <a href="{{ URL::to('edit-manager/'.$row->slug) }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            @elseif($row->role=='interviewer')
                                            <a href="{{ URL::to('edit-interviewer/'.$row->slug) }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            @elseif($row->role=='adminManager')
                                            <a href="{{ URL::to('edit-admission-manager/'.$row->slug) }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            @else
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td>No Data Found!</td>
                                </tr>
                                @endforelse

                            </tbody>

                        </table>
                        <div style="text-align: center;" class="pagination-custom_solid">
                            {{ $user_list_data->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@stop
