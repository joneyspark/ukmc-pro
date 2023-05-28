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
                                        <li class="breadcrumb-item"><a href="{{ URL::to('all-campus') }}">Campus List</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ (!empty($campus_data->campus_name))?$campus_data->campus_name:'' }}</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <h5 class="pt-3">Campus Details</h5>
            <div class="" theme-mode-data="false">
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-5">
                                <div class="col">
                                    <img class="img-thumnail rounded-circle" src="{{ asset($campus_data->institute_logo) }}" alt="" width="200px">
                                </div>
                                <div class="col">
                                    <ul class="list-group custom-list-group-branch me-1">
                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="count-warning">Total Courses</h6><a href="" class=""><span class="badge badge-warning">0</span></a></li>
                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="count-primary">All Application</h6><span class="badge badge-primary">8</span></li>
                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="count-primary">New Application</h6><span class="badge badge-info">0</span></li>
                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="count-success">Sub-Agent Application</h6><span class="badge badge-secondary">0</span></li>
                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="count-success">Conditional/ Unconditional</h6><span class="badge badge-success">0</span></li>
                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="count-success">Enrolled Students</h6><span class="badge badge-success">0</span></li>
                                        <li class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="count-danger">Reject Applications</h6><span class="badge badge-danger">0</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h4>{{ (!empty($campus_data->campus_name))?$campus_data->campus_name:'' }} - Details</h4>
                                        <div>
                                            @if(Auth::user()->role=='admin')
                                            <a href="{{ URL::to('edit-campus/'.$campus_data->slug) }}" class="">
                                                <button class="btn btn-info btn-rounded mb-2 mr-4 inline-flex me-2"> Edit
                                                    Campus
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-eye">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg></button>
                                            </a>
                                            @endif
                                            <a href="{{ URL::to('all-campus') }}" class="">
                                                    <button class="btn btn-info btn-rounded mb-2 mr-4 inline-flex"> View Campuses
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-eye">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </button>
                                            </a>
                                        </div>
                                    </div><br>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-6"><label for="exampleFormControlInput1">Country</label>
                                        <h6>{{ (!empty($campus_data->country))?$campus_data->country:'' }}</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-6"><label for="exampleFormControlInput1">Campus Name</label>
                                        <h6>{{ (!empty($campus_data->campus_name))?$campus_data->campus_name:'' }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Website</label>
                                        <h6>{{ (!empty($campus_data->website))?$campus_data->website:'' }}</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Monthly Living
                                            Cost</label>
                                        <h6>{{ (!empty($campus_data->monthly_living_cost))?$campus_data->monthly_living_cost:'' }}</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Funds Requirements
                                            for Visa</label>
                                        <p>{{ (!empty($campus_data->funds_requirements_for_visa))?$campus_data->funds_requirements_for_visa:'' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Application
                                            Fees</label>
                                        <h6>{{ (!empty($campus_data->application_fee))?$campus_data->application_fee:'' }}</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Currency</label>
                                        <h6>{{ (!empty($campus_data->currency))?$campus_data->currency:'' }}</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlInput1">Is Language
                                            Mendatory</label>
                                        <h6>{{ (!empty($campus_data->is_lang_mendatory))?$campus_data->is_lang_mendatory:'' }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Language
                                            Requirements</label>
                                        <p>{{ (!empty($campus_data->lang_requirements))?$campus_data->lang_requirements:'' }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Campus
                                            Benifits</label>
                                        <p>{{ (!empty($campus_data->institute_benifits))?$campus_data->institute_benifits:'' }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1"> Part Time Work
                                            Details</label>
                                        <p>{{ (!empty($campus_data->per_time_work_details))?$campus_data->per_time_work_details:'' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1">Scholarship
                                            Policy</label>
                                        <p>{{ (!empty($campus_data->scholarship_policy))?$campus_data->scholarship_policy:'' }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label for="exampleFormControlTextarea1"> Campus
                                            Important Notes</label>
                                        <p>{{ (!empty($campus_data->institute_important_notes))?$campus_data->institute_important_notes:'' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="row d-flex align-items-center">
                                        <div class="col col-md-8">
                                            <div class="form-group mb-4"><span><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="64" height="64" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-file">
                                                        <path
                                                            d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                                        </path>
                                                        <polyline points="13 2 13 9 20 9"></polyline>
                                                    </svg></span>
                                                    @if(!empty($campus_data->institute_prospectus))
                                                    <a download href="{{ URL::to(asset($campus_data->institute_prospectus)) }}">Download Campus Prospectus</a>
                                                    @else
                                                    <label>No Campus Prospectus Found</label>
                                                    @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row d-flex align-items-center">
                                        <div class="col col-md-8">
                                            <div><span><svg xmlns="http://www.w3.org/2000/svg" width="64"
                                                        height="64" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-file">
                                                        <path
                                                            d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                                        </path>
                                                        <polyline points="13 2 13 9 20 9"></polyline>
                                                    </svg></span>
                                                    @if(!empty($campus_data->institute_course_pdf))
                                                    <a download href="{{ URL::to(asset($campus_data->institute_course_pdf)) }}">Download Course Module</a>
                                                    @else
                                                    <label>No Course Module Found</label>
                                                    @endif

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
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>University Contact Person</h4><br>
                                </div>
                                <div class="col col-md-12">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table-bordered table-hover table-striped mb-4 table">
                                                <thead>
                                                    <tr>
                                                        <th>Contact Person Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Alternate Phone</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($campus_contact_persons as $person)
                                                    <tr>
                                                        <td>{{ $person->name }}</td>
                                                        <td>{{ $person->email }}</td>
                                                        <td>{{ $person->phone }}</td>
                                                        <td>{{ $person->alternate_phone }}</td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td>No Data Found</td>
                                                    </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
