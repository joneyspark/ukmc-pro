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
                                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ URL::to('my-notification-list') }}">My Notifications</a></li>
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
                    <h5 class="p-3">All Task List</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Notification</th>
                                    <th>Notification Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($all_data as $row)
                                <tr class="">
                                    <td>
                                        <p>{{ $row->id }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ URL::to($row->slug) }}"><p>{!! $row->description !!}</p></a>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ date('Y-m-d',strtotime($row->created_at)) }}</p>
                                    </td>
                                </tr>
                                @empty
                                <tr>No Data Found</tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div style="text-align: center;" class="pagination-custom_solid">
                            {{ $all_data->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@stop
