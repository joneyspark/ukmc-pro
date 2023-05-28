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
                                    <li class="breadcrumb-item"><a href="#">Campus</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">All</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="px-3 pt-3">All Campus</h5>
        <div class="row layout-top-spacing">
            <div class="layout-px-spacing" theme-mode-data="false">
                <div id="card_1" class="col-lg-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row">
                                @forelse ($campuses as $campus)
                                <div class="col col-md-4 mb-4">
                                    <div class="{{ (!empty($campus_id) && $campus_id==$campus->id)?'tr-bg':'' }} card component-card_4">
                                        <div class="card-body custom-card-body-country">
                                            <div class="user-info">
                                                <div class="d-flex align-items-start justify-content-between pl-4">
                                                    <div class="logo-title-wrap">
                                                        <img class="rounded-circle bg-white" src="{{ URL::to($campus->institute_logo) }}" alt="..." width="70px">
                                                    </div>
                                                    <div class="action-wrapd-flex align-items-center justify-content-between">
                                                        <div class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                                            <div class="input-checkbox">
                                                                <span class="switch-chk-label label-left">On</span>
                                                                <input {{ ($campus->active==1)?'checked':'' }} data-id="{{ $campus->id }}" data-toggle="toggle" class="switch-input campus-change-status" type="checkbox"
                                                                    role="switch" id="form-custom-switch-inner-text">
                                                                <span class="switch-chk-label label-right">Off</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-info-lists">
                                                    <div class="title-subtitle-wrap mt-4">
                                                        <a href="" class="">
                                                            <h4 class="card-user_name">{{ (!empty($campus->campus_name))?$campus->campus_name:'' }}</h4>
                                                        </a>
                                                        <p class="card-user_occupation">Country: {{ (!empty($campus->country))?$campus->country:'' }}</p>
                                                    </div>
                                                    <ul class="list-group custom-list-group-branch me-1">
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-warning">Total Courses</h6><a href="" class=""><span class="badge badge-warning">0</span></a></li>
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-primary">All Application</h6><span class="badge badge-primary">8</span></li>
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-primary">New Application</h6><span class="badge badge-info">0</span></li>
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-success">Sub-Agent Application</h6><span class="badge badge-secondary">0</span></li>
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-success">Conditional/ Unconditional</h6><span class="badge badge-success">0</span></li>
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-success">Enrolled Students</h6><span class="badge badge-success">0</span></li>
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-danger">Reject Applications</h6><span class="badge badge-danger">0</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                    <div>No Data Found</div>
                                @endforelse
                                <div class="pagination-custom_solid">
                                    {{ $campuses->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<style>
    .tr-bg{
        background: #657a9b !important;
    }
</style>
@stop
