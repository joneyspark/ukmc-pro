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
                                    <li class="breadcrumb-item"><a href="#">Interview List</a></li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">

            <div class="usr-tasks ">
                <div class="widget-content widget-content-area">
                    <h5 class="p-3">Interview List</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Meeting Details</th>
                                    <th class="text-center">Interview Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($meetings))
                                    @foreach ($meetings as $meeting)
                                    <tr>
                                        <td class="text-center">{{ $meeting->meeting_notes }}</td>
                                        <td class="text-center">{{ date('F d Y H:i:s',strtotime($meeting->meeting_date_time)) }}</td>
                                        <td class="text-center">
                                            @if($meeting->is_meeting_done==0)
                                                <span class="badge badge-danger">Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ URL::to('application/'.$meeting->application_id.'/processing') }}" class="badge badge-pill bg-secondary">
                                                <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.75 5H8.25C7.55964 5 7 5.58763 7 6.3125V19L12 15.5L17 19V6.3125C17 5.58763 16.4404 5 15.75 5Z" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </a>
                                            <a href="javascript:void(0)" onclick="if(confirm('Are you sure to Confirm this Meeting?')) location.href='{{ URL::to('direct-meeting-status-change/'.$meeting->id) }}'; return false;" style="color:#ada310; margin-right:10px;" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Pending" aria-label="Pending"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <h5 class="p-3">Followup List</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Followup Details</th>
                                    <th class="text-center">Followup Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($followups))
                                    @foreach ($followups as $followup)
                                    <tr>
                                        <td class="text-center">{{ $followup->follow_up }}</td>
                                        <td class="text-center">{{ date('F d Y H:i:s',strtotime($followup->follow_up_date_time)) }}</td>
                                        <td class="text-center">
                                            @if($followup->is_follow_up_done==0)
                                                <span class="badge badge-danger">Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ URL::to('application/'.$followup->application_id.'/processing') }}" class="badge badge-pill bg-secondary">
                                                <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.75 5H8.25C7.55964 5 7 5.58763 7 6.3125V19L12 15.5L17 19V6.3125C17 5.58763 16.4404 5 15.75 5Z" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </a>
                                            <a href="javascript:void(0)" onclick="if(confirm('Are you sure to Confirm this Followup?')) location.href='{{ URL::to('direct-followup-status-change/'.$followup->id) }}'; return false;" style="color:#ada310; margin-right:10px;" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Pending" aria-label="Pending"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@stop
