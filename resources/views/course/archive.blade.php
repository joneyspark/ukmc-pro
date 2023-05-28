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
                                        <li class="breadcrumb-item"><a href="#">Application</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <div class="row layout-top-spacing">
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row">
                                <div class="col col-md-12">
                                    <div id="tableSimple" class="col-lg-12 col-12 p-0">
                                        <div class="table-responsive">
                                            <table id="manage_app_process" class="table-bordered mb-4 table"
                                                style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Course Name</th>
                                                        <th>Campus Name</th>
                                                        <th>Category</th>
                                                        <th>Course Level</th>
                                                        <th>Duration</th>
                                                        <th>Intake</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="">
                                                        <td>1</td>
                                                        <td>Bachelor of Computer Science</td>
                                                        <td>Birmingham</td>
                                                        <td>Architecture</td>
                                                        <td>Undergraduate</td>
                                                        <td>Full-Time, 3 years</td>
                                                        <td>February</td>
                                                        <td>
                                                            <div
                                                                class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                                                <div class="input-checkbox">
                                                                    <span class="switch-chk-label label-left">On</span>
                                                                    <input class="switch-input" type="checkbox"
                                                                        role="switch" id="form-custom-switch-inner-text"
                                                                        checked="">
                                                                    <span class="switch-chk-label label-right">Off</span>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td class="flex space-x-2 text-center"><a
                                                                href="/course/78327ed4e27e476383aecf91fda7d0f1"
                                                                class=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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
