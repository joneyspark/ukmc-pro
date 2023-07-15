@extends('adminpanel')
@section('admin')
<div class="modal fade inputForm-modal" id="inputFormModal5" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Chnage Password</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <form method="post" action="{{ URL::to('user-password-change-by-admin') }}" class="mt-0">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <div class="col">
                        <div class="form-group mb-4"><label for="password">Password</label>
                            <input type="hidden" name="change_password_user_id" id="change_password_user_id" value="" />
                            <input name="password" type="password" class="form-control">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                            <!---->
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mb-4"><label for="password">Confirm Password</label>
                            <input name="password_confirmation" type="password" class="form-control">
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                            <!---->
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
<div class="modal fade inputForm-modal" id="inputFormModal2" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Transfer Application To Admission Officer</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <form method="post" action="{{ URL::to('confirm_transfer_application_to_admission_officer') }}" class="mt-0">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <div class="col">
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Role</label>
                            <input type="hidden" value="" name="from_admission_officer_id" id="from_admission_officer_id" />
                            <select id="manager_id" name="manager_id" class="form-control">
                                <option value="" selected>Select Manager</option>
                                @foreach ($manager_list as $manager)
                                @if($manager->role=='manager')
                                <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                @endif
                                @endforeach
                            </select>
                            @if ($errors->has('manager_id'))
                                <span class="text-danger">{{ $errors->first('manager_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Role</label>
                            <select id="admission_officer_id" name="admission_officer_id" class="form-control">
                                <option value="" selected>Select Admission Officer</option>
                                @foreach ($officer_list as $urow)
                                    <option value="{{ $urow->id }}">{{ $urow->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('admission_officer_id'))
                                <span class="text-danger">{{ $errors->first('admission_officer_id') }}</span>
                            @endif
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
<div class="modal fade inputForm-modal" id="inputFormModal1" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header" id="inputFormModalLabel">
            <h5 class="modal-title"><b>Transfer Application To Interviewer</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <form method="post" action="{{ URL::to('confirm_transfer_application_to_interviewer') }}" class="mt-0">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <div class="col">
                        <div class="form-group mb-4"><label for="exampleFormControlInput1">Role</label>
                            <input type="hidden" name="interviewer_user_id" value="" id="interviewer_user_id" />
                            <select id="assign_to_interviewer_user_id" name="assign_to_interviewer_user_id" class="form-control">
                                <option value="">Select Interviewer</option>
                                @foreach ($interviewer_list as $irow)
                                    <option value="{{ $irow->id }}">{{ $irow->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('assign_to_interviewer_user_id'))
                                <span class="text-danger">{{ $errors->first('assign_to_interviewer_user_id') }}</span>
                            @endif
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
                                    <th scope="col">Assigned Application</th>
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
                                    <td>

                                        @if($row->role=='adminManager')
                                        <span class="badge badge-secondary">{{ count($row->applications) }}</span>
                                        @elseif($row->role=='interviewer')
                                        <span class="badge badge-secondary">{{ count($row->interviewer_applications) }}</span>
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
                                            <a onclick="change_password({{ $row->id }})" data-id="{{ $row->id }}" data-bs-toggle="modal" data-bs-target="#inputFormModal5"  class="get-roll-data{{ $row->id }} badge badge-pill bg-secondary">
                                                <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-lock" viewBox="0 0 16 16">
                                                    <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5v-1a1.9 1.9 0 0 1 .01-.2 4.49 4.49 0 0 1 1.534-3.693C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm7 0a1 1 0 0 1 1-1v-1a2 2 0 1 1 4 0v1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-2Zm3-3a1 1 0 0 0-1 1v1h2v-1a1 1 0 0 0-1-1Z"/>
                                                </svg>
                                            </a>
                                            @endif

                                            @if($row->role=='manager')
                                            <a href="{{ URL::to('edit-manager/'.$row->slug) }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            @endif
                                            @if($row->role=='interviewer')
                                            <a href="{{ URL::to('edit-interviewer/'.$row->slug) }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#inputFormModal1" onclick="getInterviewerData({{ $row->id }})" class="badge badge-pill bg-success">
                                                <svg style="color: unset;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ URL::to('get-interviewer-application/'.$row->id) }}" class="badge badge-pill bg-danger">
                                                <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
                                                    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                                                </svg>
                                            </a>
                                            @endif
                                            @if($row->role=='adminManager')
                                            <a href="{{ URL::to('edit-admission-manager/'.$row->slug) }}" class="badge badge-pill bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#inputFormModal2" onclick="getAdmissionOfficerList({{ $row->id }})" class="badge badge-pill bg-success">
                                                <svg style="color: unset;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ URL::to('get-admission-officer-application/'.$row->id) }}" class="badge badge-pill bg-danger">
                                                <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
                                                    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                                                </svg>
                                            </a>

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
