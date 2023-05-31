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
                                        <li class="breadcrumb-item"><a href="{{ URL::to('all-course') }}">Courses</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <form method="post" action="{{ URL::to('course-data-store') }}" enctype="multipart/form-data">
                @csrf
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-4">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h4  >Add Course Information</h4><a
                                            href="/courses" class=""><button
                                                class="btn btn-info btn-rounded mb-2 mr-4 inline-flex"> View Courses <svg
                                                    xmlns="http://www.w3.org/2000/svg" width="20"
                                                    height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-eye">
                                                    <path
                                                        d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3">
                                                    </circle>
                                                </svg></button></a>
                                    </div><br  >
                                </div>
                                <div class="col">
                                    <div class="flex space-x-2 md:space-x-4">
                                        <div class="form-group mb-4 w-full"><label
                                                for="campus_id">Select Campus*</label><select
                                                class="form-control" id="campus_id" name="campus_id">
                                                <option value="">--Select One--</option>
                                                @foreach ($campus_list as $campus)
                                                <option value="{{ $campus->id }}">{{ $campus->campus_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('campus_id'))
                                                <span class="text-danger">{{ $errors->first('campus_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Name*</label>
                                            <input type="text" class="form-control" value="{{ old('course_name') }}" name="course_name">
                                            @if ($errors->has('course_name'))
                                                <span class="text-danger">{{ $errors->first('course_name') }}</span>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Category*</label>
                                        <select name="category_id" class="form-control">
                                            <option value="">Select a Category</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category_id'))
                                            <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Level</label>
                                        <select name="course_level_id" class="form-control">
                                            <option value="">Select Course Level</option>
                                            @foreach ($course_levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->title }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('course_level_id'))
                                            <span class="text-danger">{{ $errors->first('course_level_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Duration*</label>
                                            <input type="text" class="form-control" name="course_duration">
                                            @if ($errors->has('course_duration'))
                                                <span class="text-danger">{{ $errors->first('course_duration') }}</span>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="Icon-outside field-wrapper form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Fee (For
                                            Local)*</label>
                                            <input type="text" class="course-fee-input form-control" name="course_fee">
                                            @if ($errors->has('course_fee'))
                                                <span class="text-danger">{{ $errors->first('course_fee') }}</span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="Icon-outside form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Fee (For
                                            International Students)*</label>
                                            <input type="text" class="course-fee-input form-control" name="international_course_fee">
                                            @if ($errors->has('international_course_fee'))
                                                <span class="text-danger">{{ $errors->first('international_course_fee') }}</span>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-8">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Intake*</label>
                                            <input type="text" placeholder="september,janyary" class="" name="course_intake">
                                            @if ($errors->has('course_intake'))
                                                <span class="text-danger">{{ $errors->first('course_intake') }}</span>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Awarding Body*</label>
                                            <input type="text" class="form-control" name="awarding_body">
                                            @if ($errors->has('awarding_body'))
                                                <span class="text-danger">{{ $errors->first('awarding_body') }}</span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Is Language Mendatory*</label>
                                        <input type="text" class="form-control" placeholder="Yes or No" name="is_lang_mendatory">
                                        @if($errors->has('is_lang_mendatory'))
                                            <span class="text-danger">{{ $errors->first('is_lang_mendatory') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlTextarea1"> Language Requirement</label>
                                        <textarea id="exampleFormControlTextarea1" class="form-control" rows="3"
                                            spellcheck="false" name="lang_requirements"></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlTextarea1"> Part Time Work Details</label>
                                        <textarea id="exampleFormControlTextarea1" class="form-control" rows="3"
                                            spellcheck="false" name="per_time_work_details"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlTextarea1"> Additional Information of Course</label>
                                        <textarea id="exampleFormControlTextarea1" class="form-control" rows="3"
                                            spellcheck="false" name="addtional_info_course"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="row d-flex align-items-center">
                                        <div class="col col-md-8">
                                            <div class="form-group mb-4"><label
                                                     >Course Prospectus</label><label
                                                    class="custom-file-container__custom-file"><input
                                                        type="file" name="course_prospectus" class="form-control-file"></label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row d-flex align-items-center">
                                        <div class="col col-md-8">
                                            <div class="form-group mb-4"><label
                                                     >Course Module PDF</label><label
                                                    class="custom-file-container__custom-file"><input
                                                        type="file" name="course_module" class="form-control-file"></label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-4">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4  >Additional Information</h4><br  >
                                </div>
                                <div class="col col-md-12">
                                    <div class="row">
                                        <div class="col col-md-12 text-right">
                                            <div class="row ml-4">
                                                <div>
                                                    <a id="addAttributeButton1" class="btn btn-warning btn-rounded mb-2 mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-plus-circle">
                                                            <circle cx="12" cy="12"
                                                                r="10"></circle>
                                                            <line x1="12" y1="8"
                                                                x2="12" y2="16"></line>
                                                            <line x1="8" y1="12"
                                                                x2="16" y2="12"></line>
                                                    </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-md-10">
                                            <div id="select-wrapper1">
                                                <div id="element-wrapper1">
                                                    <div class="form-group mb-4"><label
                                                        for="personName">Course Additional Information ( If have )</label>
                                                    <textarea id="exampleFormControlTextarea1" class="form-control" rows="3"
                                                        spellcheck="false" name="course_additionals[]"></textarea>
                                                </div>
                                                <span class="input-group-btn"><button type="button" class="btn btn-danger remove-attribute-element1"><i class="glyphicon glyphicon-minus"></i>-</button></span>
                                                </div>
                                            </div>
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
                                <div class="col mt-5">
                                    <button type="button" class="btn btn-warning btn-lg me-2"> Cancel </button>
                                    <button type="submit" class="btn btn-primary btn-lg mr-2"> Submit </button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
