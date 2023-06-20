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
                                        <li class="breadcrumb-item"><a href="{{ URL::to('all-application') }}">Applications</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Meeting Details</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <h5 class="pt-3">Meeting Details</h5>
            <div class="" theme-mode-data="false">
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Meeting Title</label>
                                        <h6>{{ (!empty($meeting_data->meeting_notes))?$meeting_data->meeting_notes:'' }}</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Meeting Date</label>
                                        <h6>{{ (!empty($meeting_data->meeting_date_time))?date('F d Y H:i:s',strtotime($meeting_data->meeting_date_time)):'' }}</h6>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Meeting Status</label>
                                        @if($meeting_data->is_meeting_done==0)
                                        <a href="{{ URL::to('direct-meeting-status-change/'.$meeting_data->id) }}" style="color:#ada310;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Pending" aria-label="Pending"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></a>
                                        @else
                                        <a href="{{ URL::to('direct-meeting-status-change/'.$meeting_data->id) }}" style="color:#1f6b08;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Complete" aria-label="Complete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></a>
                                        @endif
                                  </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Is Done Meeting</label>
                                        @if($meeting_data->is_meeting_done==0)
                                        <span class="badge badge-warning">Pending</span>
                                        @else
                                        <span class="badge badge-success">Complete</span>
                                        @endif
                                        
                                    </div>
                                    
                                </div>
                                {{-- @if(!empty($task_data->doc))
                                <div class="col-4">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Task Doc File</label><br>
                                        <a class="task-doc-download" download href="{{ asset($task_data->doc) }}">Download</a>
                                    </div>
                                </div>
                                @endif --}}
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
