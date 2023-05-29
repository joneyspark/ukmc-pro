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
                                        <li class="breadcrumb-item"><a href="{{ URL::to('task-list') }}">Task List</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ (!empty($task_data->task_name))?$task_data->task_name:'' }}</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <h5 class="pt-3">Task Details</h5>
            <div class="" theme-mode-data="false">
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Task Name</label>
                                        <h6>{{ (!empty($task_data->task_name))?$task_data->task_name:'' }}</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Priority</label>
                                        <h6>{{ (!empty($task_data->priority))?$task_data->priority:'' }}</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Assigned Person</label>
                                        <p>{{ (!empty($task_data->user->name))?$task_data->user->name:'' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Task Status</label>
                                        <h6>
                                            @if($task_data->status==0)
                                            <span class="badge badge-light-primary mb-2 me-4">Pending</span>
                                            @elseif($task_data->status==1)
                                            <span class="badge badge-light-info mb-2 me-4">Ongoing</span>
                                            @elseif($task_data->status==2)
                                            <span class="badge badge-light-warning mb-2 me-4">Progress</span>
                                            @elseif($task_data->status==3)
                                            <span class="badge badge-light-success mb-2 me-4">Complete</span>
                                            @else
                                            <span class="badge badge-light-danger mb-2 me-4">Cancel</span>
                                            @endif
                                        </h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Task Details</label>
                                        <p>{{ (!empty($task_data->task_details))?$task_data->task_details:'' }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Task Deadline</label>
                                        <p>{{ date('Y-m-d',strtotime($task_data->deadline)) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                @if(Auth::user()->id==$task_data->assign_to)
                                <div class="col-3">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Change Status*</label>
                                        <select data-id="{{ $task_data->id }}" data-action="{{ URL::to('task-status-chnage') }}" name="status" class="task-status-change form-control" onchange="task_status_change()">
                                            <option value="">--Select One--</option>
                                            @foreach ($task_status as $status)
                                            <option {{ ($status['id']==$task_data->status)?'selected':'' }} value="{{ $status['id'] }}">{{ $status['val'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="col-5">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Task Progress</label>
                                        <div class="progress br-30">
                                            @if($task_data->status==1)
                                            <div class="progress-bar br-30 bg-danger" role="progressbar" style="width: 29.56%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            @elseif($task_data->status==2)
                                            <div class="progress-bar br-30 bg-danger" role="progressbar" style="width: 59.56%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            @elseif($task_data->status==3)
                                            <div class="progress-bar br-30 bg-danger" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            @else
                                            <div class="progress-bar br-30 bg-danger" role="progressbar" style="width: {{ ($task_data->is_view==1)?'10%':'0%' }}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            @endif

                                        </div>
                                  </div>
                                </div>
                                @if(!empty($task_data->doc))
                                <div class="col-4">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Task Doc File</label><br>
                                        <a class="task-doc-download" download href="{{ asset($task_data->doc) }}">Download</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-5">Comments <span class="comment-count">({{ (!empty($coments))?count($coments):'0' }})</span></h5>
                                    <div class="post-comments">
                                        @if(!is_null($coments) && (is_array($coments) || $coments instanceof Countable))

                                        @foreach($coments as $coment)
                                        <div class="media mb-1 pb-3 primary-comment">
                                            <div class="avatar me-4">
                                                <img alt="avatar" src="{{ asset($coment->photo) }}" class="rounded-circle" />
                                            </div>
                                            <div class="media-body">
                                                <h5 class="media-heading mb-1">{{ $coment->name }}</h5>
                                                <div class="meta-info mb-0">{{ App\Models\Task\Task::timeLeft($coment->create_date) }}</div>
                                                <p class="media-text mt-2 mb-0">{{ $coment->coment }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif

                                    </div>
                                    @if(Auth::user()->role=='admin' || Auth::user()->id==$task_data->assign_to)
                                    <div class="post-form mt-5">
                                        <div class="section add-comment">
                                            <div class="info">
                                                <form action="{{ URL::to('task-coment-store') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <h6 class="">Add Comment</h6>
                                                <div class="row mt-4">
                                                        <div class="col-md-8">
                                                        <input type="hidden" name="task_id" value="{{ $task_data->id }}" />
                                                        <div class="mb-3">
                                                            <label class="form-label">Write Comment</label>
                                                            <textarea name="coment" class="form-control" cols="30" rows="3"></textarea>
                                                            @if($errors->has('coment'))
                                                                <span class="text-danger">{{ $errors->first('coment') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <button type="submit" class="btn btn-success">Add Comment</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
