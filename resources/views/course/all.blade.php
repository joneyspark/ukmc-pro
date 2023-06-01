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
                                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="p-3">Course List</h5>
        <div class="widget-content widget-content-area">
            <form>
                 <div class="row mb-4">
                     <div class="col-4">
                        <select name="status" id="status" class="form-control">
                            <option value="">Select Campus</option>
                            @foreach ($campus_list as $row)
                            <option value="{{ $row->id }}">{{ $row->campus_name }}</option>
                            @endforeach

                        </select>
                     </div>
                     <div class="col-6">
                         <input type="text" name="search" id="search" class="form-control" placeholder="Enter Course Name">
                     </div>

                     <div class="col">
                        <input type="submit" value="Reset" name="time" class="btn btn-danger">
                     </div>
                 </div>
            </form>
        </div>
        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div id="tabledata" class="table-responsive">
                        @include('ajax.Course.list')
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@stop
