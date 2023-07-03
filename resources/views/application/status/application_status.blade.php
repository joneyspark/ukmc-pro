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
                                    <li class="breadcrumb-item active" aria-current="page">Create Status</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="p-3">Status List</h5>
        <div class="widget-content widget-content-area">
            <form method="post" action="{{ URL::to('application-status-store') }}" enctype="multipart/form-data">
                @csrf
                 <div class="row mb-4">
                     <div class="col-7">
                         <input type="hidden" name="application_status_id" value="{{ (!empty($applicatoin_status_data->id))?$applicatoin_status_data->id:'' }}" />
                         <input type="text" name="title" value="{{ (!empty($applicatoin_status_data->title))?$applicatoin_status_data->title:'' }}" class="form-control" placeholder="Application Status Title">
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
                                <th>Title</th>
                                <th>Create date</th>
                                <th>Status</th>
                                <th class="no-content">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($get_application_status as $row)
                            <tr class="{{ (!empty($return_application_status_id) && $return_application_status_id==$row->id)?'tr-bg':'' }}">
                                <td>{{ (!empty($row->id))?$row->id:'' }}</td>
                                <td>{{ (!empty($row->title))?$row->title:'' }}</td>
                                <td>{{ (!empty($row->created_at))?$row->created_at:'' }}</td>
                                <td>
                                    <div class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                        <div class="input-checkbox">
                                            <span class="switch-chk-label label-left">On</span>
                                            <input {{ ($row->status==0)?'checked':'' }} data-action="{{ URL::to('application-main-status-change') }}" data-id="{{ $row->id }}" class="application-main-status-chnage switch-input" type="checkbox"
                                                    role="switch" id="form-custom-switch-inner-text">
                                            <span class="switch-chk-label label-right">Off</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ URL::to('all-application-status/'.$row->id) }}" class="badge badge-pill bg-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    </a></td>
                            </tr>
                            @empty
                               <tr>No Data Found!</tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

@stop
