@extends('adminpanel')
@section('admin')
<div class="layout-px-spacing">
    <div class="middle-content p-0">
        <div class="secondary-nav">
            <div class="breadcrumbs-container" data-page-heading="Analytics">
                <header class="header navbar navbar-expand-sm">
                    <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
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
                                    <li class="breadcrumb-item"><a href="{{ URL::to('course-all') }}">Courses</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ (!empty($course_data->course_name))?$course_data->course_name:'' }}</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="pt-3">Course Details</h5>
        <div class="" theme-mode-data="false">
            <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">

                        <div class="row mb-4">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <div class="d-flex align-items-start justify-content-between">
                                    <h4>{{ $course_data->course_name }} - Details</h4>
                                    <div>
                                                                                    <a href="{{ URL::to('course/edit/'.$course_data->slug) }}" class="">
                                            <button class="btn btn-info btn-rounded mb-2 mr-4 inline-flex me-2 _effect--ripple waves-effect waves-light"> Edit
                                                Course
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg></button>
                                        </a>
                                                                                    <a href="{{ url()->previous() }}" class="">
                                                <button class="btn btn-info btn-rounded mb-2 mr-4 inline-flex _effect--ripple waves-effect waves-light"> Back
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </button>
                                        </a>
                                    </div>
                                </div><br>
                            </div>
                            <div class="col">
                                <div class="form-group mb-6"><label for="exampleFormControlInput1">Campus</label>
                                    <h6>{{ (!empty($course_data->campus->campus_name))?$course_data->campus->campus_name:'' }}</h6>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-6"><label for="exampleFormControlInput1">Course Name</label>
                                    <h6>{{ (!empty($course_data->course_name))?$course_data->course_name:'' }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-group mb-4"><label for="exampleFormControlInput1">Course Category</label>
                                    <h6>{{ (!empty($course_data->category->title))?$course_data->category->title:'' }}</h6>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-4"><label for="exampleFormControlInput1">Course Level</label>
                                    <h6>{{ (!empty($course_data->course_level->title))?$course_data->course_level->title:'' }}</h6>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-4"><label for="exampleFormControlInput1">Course Duration</label>
                                    <p>{{ (!empty($course_data->course_duration))?$course_data->course_duration:'' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-group mb-4"><label for="exampleFormControlInput1">Course Fee (For Local)</label>
                                    <h6>{{ (!empty($course_data->course_fee))?$course_data->course_fee:'' }}</h6>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-4"><label for="exampleFormControlInput1">Course Fee (For International Students)</label>
                                    <h6>{{ (!empty($course_data->international_course_fee))?$course_data->international_course_fee:'' }}</h6>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-4"><label for="exampleFormControlInput1">Course Intake</label>
                                    <h6>{{ (!empty($course_data->course_intake))?$course_data->course_intake:'' }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Awarding Body</label>
                                    <p>{{ (!empty($course_data->awarding_body))?$course_data->awarding_body:'' }}</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Is Language Mendatory</label>
                                    <p>{{ (!empty($course_data->is_lang_mendatory))?$course_data->is_lang_mendatory:'' }}</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-4"><label for="exampleFormControlTextarea1"> Language Requirement</label>
                                    <p>{{ (!empty($course_data->lang_requirements))?$course_data->lang_requirements:'' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Part Time Work Details</label>
                                    <p>{{ (!empty($course_data->per_time_work_details))?$course_data->per_time_work_details:'' }}</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-4"><label for="exampleFormControlTextarea1"> Additional Information of Course</label>
                                    <p>{{ (!empty($course_data->addtional_info_course))?$course_data->addtional_info_course:'' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="row d-flex align-items-center">
                                    <div class="col col-md-8">
                                        @if(!empty($course_data->course_prospectus))
                                        <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Course Prospectus</label><br>
                                            <a href="{{ asset($course_data->course_prospectus) }}" download>Course Prospectus Download</a>
                                        </div>
                                        @else
                                        <div class="form-group mb-4"><span><svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                            </path>
                                            <polyline points="13 2 13 9 20 9"></polyline>
                                        </svg></span><label>No Course Prospectus Found</label>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row d-flex align-items-center">
                                    <div class="col col-md-8">
                                        @if(!empty($course_data->course_module))
                                        <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Course Module</label><br>
                                            <a href="{{ asset($course_data->course_module) }}" download>Course Module Download</a>
                                        </div>
                                        @else
                                        <div class="form-group mb-4"><span><svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                            </path>
                                            <polyline points="13 2 13 9 20 9"></polyline>
                                        </svg></span><label>No Course Module Found</label>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                        <div class="row mb-4">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Course Additional Information</h4><br>
                            </div>
                            @if(count($course_data->additionals) > 0)
                            @foreach($course_data->additionals as $key=>$row)
                            <div class="col col-md-12">
                                <div class="row">
                                    <span>{{ $key + 1 }}: {{ $row->additional }}</span>
                                </div>
                            </div><hr>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
