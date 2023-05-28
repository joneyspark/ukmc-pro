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
                                    <li class="breadcrumb-item"><a href="{{ URL::to('task-create') }}">Task Create</a></li>
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
                                    <th>Task Name</th>
                                    <th>Assign Person</th>
                                    <th>Progress</th>
                                    <th>Priority</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Deadline</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $task)
                                <tr class="{{ (!empty($get_task_id) && $get_task_id==$task->id)?'tr-bg':'' }}">
                                    <td>{{ $task->task_name }}</td>
                                    <td>
                                        <p class="text-danger">{{ $task->user->name }}</p>
                                    </td>
                                    <td>
                                        <div class="progress br-30">
                                              @if($task->status==1)
                                              <div class="progress-bar br-30 bg-danger" role="progressbar" style="width: 29.56%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                              @elseif($task->status==2)
                                              <div class="progress-bar br-30 bg-danger" role="progressbar" style="width: 59.56%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div> 
                                              @elseif($task->status==3)
                                              <div class="progress-bar br-30 bg-danger" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div> 
                                              @else
                                              <div class="progress-bar br-30 bg-danger" role="progressbar" style="width: {{ ($task->is_view==1)?'10%':'0%' }}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div> 
                                            @endif
                                            
                                        </div>
                                    </td>
                                    </td>
                                    
                                    <td>{{ $task->priority }}</td>
                                    <td>
                                        @if($task->status==0)
                                        <span class="badge badge-light-primary mb-2 me-4">Pending</span>
                                        @elseif($task->status==1)
                                        <span class="badge badge-light-info mb-2 me-4">Ongoing</span>
                                        @elseif($task->status==2)
                                        <span class="badge badge-light-warning mb-2 me-4">Progress</span>
                                        @elseif($task->status==3)
                                        <span class="badge badge-light-success mb-2 me-4">Complete</span>
                                        @else
                                        <span class="badge badge-light-danger mb-2 me-4">Cancel</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <p>{{ date('Y-m-d',strtotime($task->deadline)) }}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ URL::to('task/details/'.$task->slug) }}" class="badge badge-pill bg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        </a>
                                        <a href="{{ URL::to('edit-task/'.$task->slug) }}" class="badge badge-pill bg-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                        </a>
                                        @if($task->status==3 || $task->status==4)
                                        <a href="" class="badge badge-pill bg-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2  delete-multiple text-white"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </a></td>
                                        @endif
                                        
                                </tr> 
                                @empty
                                <tr>No Data Found</tr> 
                                @endforelse
                            </tbody>
                        </table>
                        <div style="text-align: center;" class="pagination-custom_solid">
                            {{ $tasks->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@stop
