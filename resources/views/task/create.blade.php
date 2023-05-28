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
                                        <li class="breadcrumb-item"><a href="{{ URL::to('task-list') }}">Tasks</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <form method="post" action="{{ URL::to('task-store') }}" enctype="multipart/form-data">
                @csrf
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-2">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h5>Task Information</h5>
                                    </div><br>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Assign Person*</label>
                                        <select name="assign_to" class="form-control">
                                            <option value="">Select Assign Person</option>
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }} {{ ($user->role=='teacher')?'(Teacher)':'(Admission Manager)' }}
                                            </option>
                                            @endforeach
                                            
                                        </select>
                                        @if($errors->has('assign_to'))
                                            <span class="text-danger">{{ $errors->first('assign_to') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Task Name*</label>
                                        <input type="text" class="form-control" value="{{ old('task_name') }}" name="task_name">
                                        @if($errors->has('task_name'))
                                            <span class="text-danger">{{ $errors->first('task_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-7">
                                    <div class="form-group mb-2"><label for="exampleFormControlTextarea1">Task Details*</label>
                                        <textarea class="form-control" rows="3" name="task_details">{{ old('task_details') }}</textarea>
                                        @if($errors->has('task_details'))
                                            <span class="text-danger">{{ $errors->first('task_details') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Priority*</label>
                                        <select name="priority" class="form-control">
                                            <option value="">--Select One--</option>
                                            @foreach ($priorities as $priority)
                                            <option value="{{ $priority }}">{{ $priority }}</option> 
                                            @endforeach
                                        </select>
                                        @if($errors->has('priority'))
                                            <span class="text-danger">{{ $errors->first('priority') }}</span>
                                        @endif
                                        <ul>
                                            <!---->
                                        </ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Task Doc(Optional)</label>
                                        <input type="file" class="form-control-file" name="doc">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Task Deadline*</label>
                                        <input type="date" class="form-control" name="deadline">
                                        @if($errors->has('deadline'))
                                            <span class="text-danger">{{ $errors->first('deadline') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col mt-5"><button type="button" class="btn btn-warning btn-lg me-2">
                                Cancel </button><button type="submit" class="btn btn-primary btn-lg mr-2"
                                > Submit </button></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
