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
                                        <li class="breadcrumb-item"><a href="#">Agent Company</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">All</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <h5 class="p-3">Company List</h5>
            <div class="widget-content widget-content-area">
                <form method="get" action="">
                    <div class="row">

                        <div class="col-6">
                            <input type="text" value="{{ (!empty($get_company_name))?$get_company_name:'' }}" name="company_name" class="form-control" placeholder="Enter Company Name">
                        </div>
                        <div class="col-1">
                            <input type="submit" value="Filter" name="name-list" class="btn btn-warning">
                        </div>
                        <div class="col-1">
                            <a class="btn btn-danger" href="{{ URL::to('reset-company-list') }}">Reset</a>
                        </div>
                        <div class="col-4">
                            <a style="float: right;" class="btn btn-secondary" href="{{ URL::to('create-agent') }}">+ Add Agent</a>
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
                                        <th class="text-center">Company Name</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Total Employee</th>
                                        <th class="text-center">Agreement Expire</th>
                                        <th class="text-center" scope="col">Status</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($companies as $company)
                                    <tr class="{{ (!empty($company_id) && $company_id==$company->id)?'tr-bg':'' }}">
                                        <td>
                                            <div class="media">
                                                <div class="avatar me-2">
                                                    @if(!empty($company->company_logo))
                                                    <img alt="avatar"
                                                        src="{{ asset($company->company_logo) }}"
                                                        class="rounded-circle" />
                                                    @else
                                                    <img alt="avatar"
                                                        src="{{ asset('backend/images/company_logo/dummy-logo.jpg') }}"
                                                        class="rounded-circle" />
                                                    @endif
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <h6 class="mb-0">{{ $company->company_name }}</h6>
                                                    <span>{{ $company->company_email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $company->company_phone }}
                                        </td>
                                        <td>
                                            <span class="text-success">{{ $company->users->count() }}</span>
                                        </td>
                                        <td>
                                            {{ date('Y-m-d',strtotime($company->agreement_expire_date)) }}
                                        </td>
                                        <td class="text-center">
                                            <div
                                                class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                                <div class="input-checkbox">
                                                    <span class="switch-chk-label label-left">On</span>
                                                    <input {{ ($company->status==1)?'checked':'' }} data-action="{{ URL::to('company-status-chnage') }}" data-id="{{ $company->id }}" class="company-status-chnage switch-input" type="checkbox"
                                                        role="switch" id="form-custom-switch-inner-text">
                                                    <span class="switch-chk-label label-right">Off</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-btns">
                                                <a href="{{ URL::to('get-employees-by-company/'.$company->id.'/list') }}" class="badge badge-pill bg-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-eye text-white">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </a>
                                                <a href="{{ URL::to('company/'.$company->id.'/edit') }}" class="badge badge-pill bg-warning">
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
                                {{ $companies->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop
