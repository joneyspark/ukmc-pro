@extends('adminpanel')
@section('admin')
    <div class="modal fade inputForm-modal" id="assignToModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header" id="inputFormModalLabel">
                <h5 class="modal-title"><b>Assign Application To Other Subagent</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
            </div>
            <div class="mt-0">
                <form action="{{ URL::to('transfer-application-to-other-sub-agent') }}" id="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col">
                                <div class="form-group mb-4"><label for="exampleFormControlInput1">Assign To User:</label>
                                    <input type="hidden" value="" name="from_sub_agent_id" id="from_sub_agent_id" />
                                    <select name="assign_to_user_id" id="assign_to_user_id" class="form-select">

                                    </select>
                                    {{-- @if ($errors->has('assign_to_user_id'))
                                        <span class="text-danger">{{ $errors->first('assign_to_user_id') }}</span>
                                    @endif --}}
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-menu">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </a>
                        <div class="d-flex breadcrumb-content">
                            <div class="page-header">
                                <div class="page-title">
                                </div>
                                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#">{{ $company_data->company_name }}</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">List of Employee</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <h5 class="p-3">Employee List</h5>
            <div class="row">
                <div class="col-12">
                    <a style="float: right;" class="btn btn-secondary" href="{{ URL::to('create-employee-by-agent/'.$company_data->id.'/new') }}">+ Add Employee</a>&nbsp;
                    <a style="float: right;" class="btn btn-warning" href="{{ URL::to('create-sub-agent-by-agent/'.$company_data->id.'/new') }}">+ Add Sub Agent</a>&nbsp;
                </div>
            </div>
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Agent Name</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Total Applications</th>
                                        <th class="text-center" scope="col">Role</th>
                                        <th class="text-center" scope="col">Status</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($agent_data as $agent)
                                    <tr class="{{ (!empty($agent_id) && $agent_id==$agent->id)?'tr-bg':'' }}">
                                        <td>
                                            <div class="media">
                                                <div class="avatar me-2">
                                                    @if(!empty($agent->photo))
                                                    <img alt="avatar"
                                                        src="{{ asset($agent->photo) }}"
                                                        class="rounded-circle" />
                                                    @else
                                                    <img alt="avatar"
                                                        src="{{ asset('backend/images/company_logo/dummy-logo.jpg') }}"
                                                        class="rounded-circle" />
                                                    @endif
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <h6 class="mb-0">{{ $agent->name }}</h6>
                                                    <span>{{ $agent->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $agent->phone }}
                                        </td>
                                        <td>
                                            Total: {{ $agent->agent_applications_count }}
                                        </td>
                                        <td>
                                            @if($agent->is_admin==1)
                                            <span class="text-success">Admin</span>
                                            @elseif($agent->is_admin==0 && $agent->role=='subAgent')
                                            <span class="text-danger">Sub Agent</span>
                                            @else
                                            <span class="text-success">Employee</span>
                                            @endif

                                        </td>
                                        <td class="text-center">
                                            <div class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                                <div class="input-checkbox">
                                                    <span class="switch-chk-label label-left">On</span>
                                                    <input {{ ($agent->active==1)?'checked':'' }} data-action="{{ URL::to('user-status-chnage') }}" data-id="{{ $agent->id }}" class="user-status-chnage switch-input" type="checkbox"
                                                        role="switch" id="form-custom-switch-inner-text">
                                                    <span class="switch-chk-label label-right">Off</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-btns">
                                                <a href="{{ URL::to('edit-employee-by-agent/'.$agent->id.'/edit') }}" class="badge badge-pill bg-warning">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit-3 text-white">
                                                        <path d="M12 20h9"></path>
                                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z">
                                                        </path>
                                                    </svg>
                                                </a>
                                                @if($agent->role=='subAgent')
                                                <a onclick="getSubAgent({{ $agent->id }})" href="javascript://" data-bs-toggle="modal" data-bs-target="#assignToModal" class="badge badge-pill bg-danger">
                                                    <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-diff" viewBox="0 0 16 16">
                                                        <path d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4zm-2.5 6.5A.5.5 0 0 1 6 10h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"></path>
                                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"></path>
                                                    </svg>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>No Data Found</tr>
                                    @endforelse


                                </tbody>
                            </table>
                            <div style="text-align: center;" class="pagination-custom_solid">
                                {{ $agent_data->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="{{ asset('web/js/jquery.js') }}"></script>
    <script>
        function getSubAgent(getId){
            //var getId = $('#assign_to_manager_id').val();
            $('#from_sub_agent_id').val(getId);
            $.get('{{ URL::to('get-sub-agent-for-transfer-application') }}/'+getId,function(data,status){
                if(data['result']['key']===200){
                    console.log(data['result']['val']);
                    $('#assign_to_user_id').html(data['result']['val']);
                }
            });
        }
    </script>
@stop
