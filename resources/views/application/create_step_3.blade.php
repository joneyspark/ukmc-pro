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
                <div class="step active" data-target="#verticalFormStep-three">
                    <button type="button" class="step-trigger active" role="tab">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Three</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#verticalFormStep-four">
                    <button type="button" class="step-trigger" role="tab">
                        <span class="bs-stepper-circle">4</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Four</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#verticalFormStep-five">
                    <button type="button" class="step-trigger" role="tab">
                        <span class="bs-stepper-circle">5</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Step Five</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#verticalFormStep-Six">
                    <button type="button" class="step-trigger" role="tab">
                        <span class="bs-stepper-circle">6</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Final Step</span>
                        </span>
                    </button>
                </div>
            </div>

            <div class="bs-stepper-content">
                <div id="verticalFormStep-three" class="content fade dstepper-block active" role="tabpanel">
                    <form method="post" action="{{ URL::to('step-3-post') }}" class=" row g-3">
                        @csrf
                        <h5 class="text-center">Personal Statement</h5>
                        <hr>
                        <div class="col-12">
                            <input type="hidden" name="application_id" value="{{ (!empty($application_id))?$application_id:'' }}" />
                            <input type="hidden" name="application_step3_id" value="{{ (!empty($app_data3->id))?$app_data3->id:'' }}" />
                            <p class="text-white">A personal statement should be included here. It should be approximately 500 words. You should state why you want to undertake this course, any relevant experience, skills and attributes, and your
                                long term plans. 1 Words</p>
                            <textarea name="personal_statement" class="text-justify form-control" rows="2" cols="20" style="height: 350px; width: 100%;">
                                {{ (!empty($app_data3->personal_statement))?$app_data3->personal_statement:'I have always believed that successful business quests are what take huma lives further and I have constantly observed this at my Managers. I have observed them manage people, make intelligent decisions and work hard to ensure that the business runs good. It has constantly motivated and intrigued me to grow and become a businesswoman myself. I also understand that the world of business management is markedly dynamic and volatile. With the conviction and willingness to toil hard to reach my career goal, I seek admission to the under graduate program in business management from the University , I have always been a hard-working student who never discounted away from carrying out my academic obligations.

                                I was very responsible for my academic performance and as such, I have always paid attention to my classes , done my homework and never flinched away from submitting my projects, and I am passing these values to my children as well. Anglia ruskin university is a very well reputed university with experienced and highly skilled staffs, which I believe will let me grow professionally and as a person. The diverse cultural exposure and the facilities of the universities is highly talked about. I have finished my diploma de Baccalaureate from Romania, which is my highest qualification currently and now I want to step higher and learn about the business world in a global and international perspective. I was always surrounded by businesspeople, which nurtured in me the entrepreneurial spirit.' }}
                            </textarea>
                            @if ($errors->has('personal_statement'))
                                <span class="text-danger">{{ $errors->first('personal_statement') }}</span>
                            @endif
                            <p class="text-danger">Statements will be scrutinised for plagiarism and if found plagiarised, your application may be delayed or rejected.</p>
                        </div>
                        <div class="col-12">

                        </div>
                        <div class="button-action mt-3">
                            <a href="{{ URL::to('application-create/'.$application_id.'/step-2') }}" class="btn btn-secondary btn-prev me-3">Prev</a>
                            <button class="btn btn-secondary btn-nxt">Next</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

@stop
