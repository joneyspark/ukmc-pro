@extends('adminpanel')
@section('admin')
<div class="container">
    <div class="row secondary-nav">
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
                                <li class="breadcrumb-item active" aria-current="page">Complete</li>
                            </ol>
                        </nav>

                    </div>
                </div>
            </header>
        </div>
    </div>
    {{-- <h5 class="p-3">New Applicant</h5> --}}
    <div class="row" id="cancel-row">
        <div class="container bs-stepper stepper-form-vertical vertical linear mt-3">

            <div class="bs-stepper-content">
                <div id="verticalFormStep-Six" class="content fade dstepper-block active" role="tabpanel">
                    <h5 class="text-center">Application Submitted</h5>
                    <p>Thanks For Your Application.</p>
                    <p>After logging in with your email and password, you will be able to find the current status of your application.</p>
                    <p>Click Here For Login <a href="{{ URL::to('student-login') }}">Student Login</a></p>
                    <p>
                        We understand the time and effort it takes to complete an application, and we commend you for your dedication in preparing and submitting your materials. Your academic achievements, extracurricular involvement, and personal accomplishments showcased in your application demonstrate your commitment to excellence, and we value the opportunity to review your qualifications
                    </p>
                </div>
            </div>

        </div>
    </div>

</div>

@stop
