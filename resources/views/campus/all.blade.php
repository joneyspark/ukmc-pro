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
                                    <li class="breadcrumb-item"><a href="{{ URL::to('all-campus') }}">Campus</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Archive Campus List</li>
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
                                                        @if(Auth::user()->role=='admin' || Auth::user()->role=='adminManager')
                                                        <span class="badge badge-pill badge-warning custom-btn-branch me-1">
                                                            <a href="{{ URL::to('view-campus/'.$campus->slug) }}" class=""><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                                                        </span>
                                                        @endif
                                                        @if(Auth::user()->role=='admin')
                                                        <a href="{{ URL::to('edit-campus/'.$campus->slug) }}" class="">
                                                            <span class="badge badge-pill badge-secondary custom-btn-branch me-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                                            </span>
                                                        </a>
                                                        <a onclick="if(confirm('Are you sure to Delete this Campus?')) location.href='{{ URL::to('delete-campus/'.$campus->id) }}'; return false;" href="javascript:void(0)" class="">
                                                            <span class="badge badge-pill badge-danger custom-btn-branch me-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2  delete-multiple"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                            </span>
                                                        </a>
                                                        @endif
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
                                                            <h6 class="count-warning">Total Courses</h6><a href="" class=""><span class="badge badge-warning">{{ count($campus->courses) }}</span></a></li>
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-primary">All Application</h6><span class="badge badge-primary">{{ count($campus->total_applications) }}</span></li>
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-primary">New Application</h6><span class="badge badge-info">{{ count($campus->new_applications) }}</span></li>
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-success">Sub-Agent Application</h6><span class="badge badge-secondary">{{ count($campus->agent_applications) }}</span></li>
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-success">Conditional/ Unconditional</h6><span class="badge badge-success">{{ count($campus->conditional_applications) }}</span></li>
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-success">Enrolled Students</h6><span class="badge badge-success">{{ count($campus->enrolled_applications) }}</span></li>
                                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="count-danger">Reject Applications</h6><span class="badge badge-danger">{{ count($campus->reject_applications) }}</span></li>
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
@stop
