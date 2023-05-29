@extends('adminpanel')
@section('admin')
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
                    <a style="float: right;" class="btn btn-secondary" href="{{ URL::to('create-employee-by-agent/'.$company_data->id.'/new') }}">+ Add Employee</a>
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
                                            Total: 1
                                        </td>
                                        <td>
                                            @if($agent->is_admin==1)
                                            <span class="text-success">Admin</span>
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

@stop
