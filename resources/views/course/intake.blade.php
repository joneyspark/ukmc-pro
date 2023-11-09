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
                                    <li class="breadcrumb-item"><a href="#">Course</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Course Intake</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="p-3">Course Intake List</h5>
        <div class="widget-content widget-content-area">
            <form method="post" action="{{ URL::to('course-level-store') }}" enctype="multipart/form-data">
                @csrf
                 <div class="row mb-4">
                     <div class="col-5">
                         <input type="hidden" name="level_id" value="" />
                         <input type="text" name="title" value="" class="form-control" placeholder="Course Level Name">
                     </div>
                     <div class="col-5">
                         <textarea class="form-control"></textarea>
                     </div>
                     <div class="col">
                        <input type="submit" class="btn btn-primary">
                     </div>
                 </div>
            </form>
        </div>
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <table id="zero-config" class="table dt-table-hover text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Intake Title</th>
                                <th>Intake Description</th>
                                <th>Create date</th>
                                <th>Status</th>
                                <th class="no-content">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr class="">
                                <td>1</td>
                                <td>Title </td>
                                <td>Description </td>
                                <td>Create Date</td>
                                <td>
                                    <div class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                        <div class="input-checkbox">
                                            <span class="switch-chk-label label-left">On</span>
                                            <input data-action="" data-id="" class="level-status-change switch-input" type="checkbox"
                                                    role="switch" id="form-custom-switch-inner-text">
                                            <span class="switch-chk-label label-right">Off</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ URL::to('course-levels') }}" class="badge badge-pill bg-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            <tr class="">
                                <td>1</td>
                                <td>Title </td>
                                <td>Description </td>
                                <td>Create Date</td>
                                <td>
                                    <div class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                        <div class="input-checkbox">
                                            <span class="switch-chk-label label-left">On</span>
                                            <input data-action="" data-id="" class="level-status-change switch-input" type="checkbox"
                                                    role="switch" id="form-custom-switch-inner-text">
                                            <span class="switch-chk-label label-right">Off</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ URL::to('course/subject') }}" class="badge badge-pill bg-warning">
                                        <svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8.636 12.5a.5.5 0 0 1-.5.5H1.5A1.5 1.5 0 0 1 0 11.5v-10A1.5 1.5 0 0 1 1.5 0h10A1.5 1.5 0 0 1 13 1.5v6.636a.5.5 0 0 1-1 0V1.5a.5.5 0 0 0-.5-.5h-10a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h6.636a.5.5 0 0 1 .5.5z"/>
                                            <path fill-rule="evenodd" d="M16 15.5a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1 0-1h3.793L6.146 6.854a.5.5 0 1 1 .708-.708L15 14.293V10.5a.5.5 0 0 1 1 0v5z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

@stop
