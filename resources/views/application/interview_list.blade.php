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
                                    <th>Applicant Name</th>
                                    <th>Interview Date</th>
                                    <th>Interview Time</th>
                                    <th>Notes</th>
                                    <th>Result</th>
                                    <th>Interview Video</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>James Bond</td>
                                    <td>10/11/2023</td>
                                    <td>5:00 PM UK time</td>
                                    <td>Reason of Interview</td>
                                    <td>Interview Outcome Here</td>
                                    <td><a download href="#">Download</a></td>
                                    <td><span class="badge badge-danger">Pending</span></td>
                                    <td>Edit</td>
                                </tr>
                                <tr>
                                    <td>James Bond</td>
                                    <td>10/11/2023</td>
                                    <td>5:00 PM UK time</td>
                                    <td>Reason of Interview</td>
                                    <td>Interview Outcome Here</td>
                                    <td><a download href="#">Download</a></td>
                                    <td><span class="badge badge-danger">Pending</span></td>
                                    <td>Edit</td>
                                </tr>
                                <tr>
                                    <td>James Bond</td>
                                    <td>10/11/2023</td>
                                    <td>5:00 PM UK time</td>
                                    <td>Reason of Interview</td>
                                    <td>Interview Outcome Here</td>
                                    <td><a download href="#">Download</a></td>
                                    <td><span class="badge badge-danger">Pending</span></td>
                                    <td>Edit</td>
                                </tr>
                                <tr>
                                    <td>James Bond</td>
                                    <td>10/11/2023</td>
                                    <td>5:00 PM UK time</td>
                                    <td>Reason of Interview</td>
                                    <td>Interview Outcome Here</td>
                                    <td><a download href="#">Download</a></td>
                                    <td><span class="badge badge-danger">Pending</span></td>
                                    <td>Edit</td>
                                </tr>
                                <tr>
                                    <td>James Bond</td>
                                    <td>10/11/2023</td>
                                    <td>5:00 PM UK time</td>
                                    <td>Reason of Interview</td>
                                    <td>Interview Outcome Here</td>
                                    <td><a download href="#">Download</a></td>
                                    <td><span class="badge badge-danger">Pending</span></td>
                                    <td>Edit</td>
                                </tr>
                                <tr>
                                    <td>James Bond</td>
                                    <td>10/11/2023</td>
                                    <td>5:00 PM UK time</td>
                                    <td>Reason of Interview</td>
                                    <td>Interview Outcome Here</td>
                                    <td><a download href="#">Download</a></td>
                                    <td><span class="badge badge-danger">Pending</span></td>
                                    <td>Edit</td>
                                </tr>

                            </tbody>
                        </table>
                        <div style="text-align: center;" class="pagination-custom_solid">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@stop
