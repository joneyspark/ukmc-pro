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
                                    <li class="breadcrumb-item"><a href="#">Application</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Enrolled</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="pt-3">Filter</h5>
        <div class="widget-content widget-content-area">
            <form method="get" action="">
                 <div class="row">
                     <div class="row mb-2">
                        <div class="col">
                            <select id="campus" name="Course" class="form-control">
                                <option value="">Select Courses</option>
                                <option value="1">Course 1</option>
                                <option value="2">Course 2</option>
                                <option value="3">Course 3</option>
                                <option value="4">Course 4</option>
                            </select>
                         </div>
                        <div class="col">
                            <select id="campus" name="Intake" class="form-control">
                                <option value="">Select Intake</option>
                                <option value="1">Intake 1</option>
                                <option value="2">Intake 2</option>
                                <option value="3">Intake 3</option>
                                <option value="4">Intake 4</option>
                            </select>
                         </div>
                        <div class="col">
                            <select id="campus" name="campus" class="form-control">
                                <option value="">Select Courses</option>
                                <option value="1">Course 1</option>
                                <option value="2">Course 2</option>
                                <option value="3">Course 3</option>
                                <option value="4">Course 4</option>
                            </select>
                         </div>
                         <div class="col-1">
                            <input type="submit" value="Filter" name="time" class="btn btn-warning">
                         </div>
                         <div class="col-1">
                            <a href="{{ URL::to('reset-application-search') }}" class="btn btn-danger">Reset</a>
                         </div>
                     </div>
                 </div>
            </form>
        </div>
        <h5 class="pt-3">All Application Here</h5>
        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Application ID</th>
                                    <th>Name</th>
                                    <th>Campus</th>
                                    <th>Course</th>
                                    <th>Create date</th>
                                    <th>Intake</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>23566</td>
                                    <td>Ka</td>
                                    <td>UKMC</td>
                                    <td>MSC</td>
                                    <td>12/12/2029</td>
                                    <td>JAN 2024</td>
                                    <td>new</td>
                                    <td>Edit</td>
                                </tr>
                                <tr>
                                    <td>23566</td>
                                    <td>Ka</td>
                                    <td>UKMC</td>
                                    <td>MSC</td>
                                    <td>12/12/2029</td>
                                    <td>JAN 2024</td>
                                    <td>new</td>
                                    <td>Edit</td>
                                </tr>
                                <tr>
                                    <td>23566</td>
                                    <td>Ka</td>
                                    <td>UKMC</td>
                                    <td>MSC</td>
                                    <td>12/12/2029</td>
                                    <td>JAN 2024</td>
                                    <td>new</td>
                                    <td>Edit</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<style>
    .is-action-data{
        display: none;
    }
    .is-action-data-show{
        display: block;
    }
    .error{
        color: #a90606 !important;
    }
</style>
@stop
