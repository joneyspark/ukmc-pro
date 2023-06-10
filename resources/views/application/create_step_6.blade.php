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
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
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
            <div class="bs-stepper-header" role="tablist">
                <div class="step crossed" data-target="#verticalFormStep-one">
                    <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">Step One</span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step crossed" data-target="#verticalFormStep-two">
                    <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">Step Two</span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step crossed" data-target="#verticalFormStep-three">
                    <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Three</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step crossed" data-target="#verticalFormStep-four">
                    <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">4</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Four</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step crossed" data-target="#verticalFormStep-five">
                    <button type="button" class="step-trigger" role="tab" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">5</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Five</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step active" data-target="#verticalFormStep-Six">
                    <button type="button" class="step-trigger active" role="tab">
                        <span class="bs-stepper-circle">6</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Final Step</span>
                        </span>
                    </button>
                </div>
            </div>

            <div class="bs-stepper-content">
                <div id="verticalFormStep-Six" class="content fade dstepper-block active" role="tabpanel">
                    <h5 class="text-center">Interview / ELPT</h5>
                    <form class="row g-3" action="{{ URL::to('step-6-post') }}" method="post">
                        @csrf
                        <input type="hidden" name="application_id" value="{{ (!empty($application_id))?$application_id:'' }}" />
                        <input type="hidden" name="app_step6_id" value="{{ (!empty($app_step6->id))?$app_step6->id:'' }}" />
                        <div class="col-6">
                            <label for="verticalFormInputAddress" class="form-label">Inteview Date :</label>
                            <input name="interview_date" value="{{ (!empty($app_step6->interview_date))?$app_step6->interview_date:old('interview_date') }}" type="date" class="form-control" id="verticalFormInputAddress">
                            @if ($errors->has('interview_date'))
                                <span class="text-danger">{{ $errors->first('interview_date') }}</span>
                            @endif
                        </div>
                        <div class="col-6">
                            <label for="verticalFormInputAddress2" class="form-label">Interview Time :</label>
                            <input name="interview_time" value="{{ (!empty($app_step6->interview_time))?$app_step6->interview_time:old('interview_time') }}" type="time" class="form-control" id="verticalFormInputAddress2" placeholder="Apartment, studio, or floor">
                            @if ($errors->has('interview_time'))
                                <span class="text-danger">{{ $errors->first('interview_time') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="verticalFormStepInputCity" class="form-label">Results :</label>
                            <input name="results" value="{{ (!empty($app_step6->results))?$app_step6->results:old('results') }}" type="text" class="form-control" id="verticalFormStepInputCity">
                            @if ($errors->has('results'))
                                <span class="text-danger">{{ $errors->first('results') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="verticalFormStepInputState" class="form-label">No Show :</label>
                            <select name="show" id="verticalFormStepInputState" class="form-select">
                                <option value="">Choose...</option>
                                @foreach ($result_shows as $rrow)
                                    <option {{ (!empty($app_step6->show) && $app_step6->show==$rrow)?'selected':'' }} value="{{ $rrow }}">{{ $rrow }}</option>
                                @endforeach
                                <option>No</option>
                            </select>
                            @if ($errors->has('show'))
                                <span class="text-danger">{{ $errors->first('show') }}</span>
                            @endif
                        </div>
                        <div class="button-action mt-3">
                            <a href="{{ URL::to('application-create/'.$application_id.'/step-5') }}" class="btn btn-secondary btn-prev me-3">Back</a>
                            <button class="btn btn-success btn-nxt me-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

@stop
