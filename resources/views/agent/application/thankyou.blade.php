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
                    <h5 class="text-center">Agent Request Submitted</h5>
                    <p>Thank you for submitting your Agent Request. We are excited to assist you with your query and provide the information you need.</p>
                    <p>Our team is currently reviewing your request, and you can expect a response within the next 24 to 48 hours. We assure you that we will do our best to address your inquiry promptly and efficiently.</p>
                    <p>If you have any additional information to add or urgent updates regarding your request, please feel free to reply to this email <a href="mailto:info@ukmcglobal.com">info@ukmcglobal.com</a></p>
                    <p>
                        Thank you for choosing our services. We look forward to assisting you.
                    </p>
                </div>
            </div>

        </div>
    </div>

</div>

@stop
