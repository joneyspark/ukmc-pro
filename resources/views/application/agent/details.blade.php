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
                                <li class="breadcrumb-item active" aria-current="page">Create Step 5</li>
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
                <div class="step active" data-target="#verticalFormStep-five">
                    <button type="button" class="step-trigger active" role="tab">
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
                <div id="download-as-pdf">
                    <div id="verticalFormStep-five" class="container content fade dstepper-block active" role="tabpanel">
                        <h5 class="text-center mb-3">Submit Application</h5>
                        <div class="container bg-dark py-5 px-5 rounded">

                            <div id="MainContent_DV_FundedBy" class="row mb-4 px-5">
                                <div class="col">Will your fees be funded by the Student Loan Company / Student Finance England?
                                    :
                                </div>
                                <div class="col"><span id="MainContent_lbl_FundedBy">{{ (!empty($app_data->applicant_fees_funded))?$app_data->applicant_fees_funded:'' }}</span></div>
                            </div>
                            <div id="MainContent_DV_ResidentCat" class="row mb-4 px-5">
                                <div class="col">Residency Status : </div>
                                <div class="col">
                                    <span id="MainContent_lbl_ResidentCat">{{ (!empty($app_data->current_residential_status))?$app_data->current_residential_status:'' }}</span>

                                </div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Campus : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->campus->campus_name))?$app_data->campus->campus_name:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Course : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->course->course_name))?$app_data->course->course_name:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Course Fee Local : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->course->course_fee))?$app_data->course->course_fee:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Course Fee International : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->course->international_course_fee))?$app_data->course->international_course_fee:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Course Programme :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_CourseGroup">{{ (!empty($app_data->course_program))?$app_data->course_program:'' }}</span>

                                </div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Course Intake :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_CourseGroup">{{ (!empty($app_data->intake))?$app_data->intake:'' }}</span>

                                </div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Course Level :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_CourseGroup">{{ (!empty($app_data->course_level))?$app_data->course_level:'' }}</span>

                                </div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Delivery Pattern :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_Course">{{ (!empty($app_data->delivery_pattern))?$app_data->delivery_pattern:'' }}</span>
                                </div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Name :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_Intake">{{ (!empty($app_data->name))?$app_data->name:'' }}</span>

                                </div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Gender :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_Intake">{{ (!empty($app_data->gender))?$app_data->gender:'' }}</span>

                                </div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Date Of Birth :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_Intake">{{ (!empty($app_data->date_of_birth))?$app_data->date_of_birth:'' }}</span>

                                </div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Email :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_Intake">{{ (!empty($app_data->email))?$app_data->email:'' }}</span>

                                </div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Phone :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_Intake">{{ (!empty($app_data->phone))?$app_data->phone:'' }}</span>
                                </div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Are you applying for advance entry (APL) :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_DeliveryPattern">{{ (!empty($app_data->is_applying_advanced_entry))?$app_data->is_applying_advanced_entry:'' }}</span>

                                </div>
                            </div>
                        </div>
                        <h5 class="text-center py-3 p-3" id="MainContent_DV_HPersonalInfo">Personal Info</h5>
                        <div class="container bg-dark py-5 px-5 rounded">
                            <div id="MainContent_dv_Nationality" class="row mb-4 px-5">
                                <div class="col">Nationality :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_Nationality">{{ (!empty($app_data->step2Data->nationality))?$app_data->step2Data->nationality:'' }}</span>
                                </div>
                            </div>
                            <div id="MainContent_dv_DualNationality" class="row mb-4 px-5">
                                <div class="col">Other Nationality :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_DualNationality">{{ (!empty($app_data->step2Data->other_nationality))?$app_data->step2Data->other_nationality:'' }}</span>

                                </div>
                            </div>
                            <div id="MainContent_dv_DualNationality" class="row mb-4 px-5">
                                <div class="col">Ethnic Origin :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_DualNationality">{{ (!empty($app_data->step2Data->ethnic_origin))?$app_data->step2Data->ethnic_origin:'' }}</span>

                                </div>
                            </div>

                            <div id="MainContent_dv_CountryOfBirth" class="row mb-4 px-5">
                                <div class="col">Country of Birth :</div>
                                <div class="col"><span id="MainContent_lbl_CountryOfBirth">{{ (!empty($app_data->step2Data->country))?$app_data->step2Data->country:'' }}</span>
                                </div>
                            </div>
                            <div id="MainContent_dv_EthnicOriginID" class="row mb-4 px-5">
                                <div class="col">Highest qualification on entry :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_EthnicOriginID">{{ (!empty($app_data->step2Data->highest_qualification_entry))?$app_data->step2Data->highest_qualification_entry:'' }}</span>
                                </div>
                            </div>
                            <div id="MainContent_dv_DOB" class="row mb-4 px-5">
                                <div class="col">Highest Qualification :</div>
                                <div class="col"><span id="MainContent_lbl_DOB">{{ (!empty($app_data->step2Data->highest_qualification))?$app_data->step2Data->highest_qualification:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_HIghestQualificationFrom" class="row mb-4 px-5">
                                <div class="col">Last Institution You Attended :</div>
                                <div class="col"><span id="MainContent_lbl_HIghestQualificationFrom">{{ (!empty($app_data->step2Data->last_institution_you_attended))?$app_data->step2Data->last_institution_you_attended:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_HIghestQualification" class="row mb-4 px-5">
                                <div class="col">Unique Learner Number (ULN) :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_HIghestQualification">{{ (!empty($app_data->step2Data->unique_learner_number))?$app_data->step2Data->unique_learner_number:'' }}</span>

                                </div>
                            </div>
                            <div id="MainContent_dv_LastEducationalInstitution" class="row mb-4 px-5">
                                <div class="col">Name of qualification :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_LastEducationalInstitution">{{ (!empty($app_data->step2Data->name_of_qualification))?$app_data->step2Data->name_of_qualification:'' }}</span>

                                </div>
                            </div>
                            <div id="MainContent_dv_WhichUKInstitute" class="row mb-4 px-5">
                                <div class="col">Year achieved/obtained :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_WhichUKInstitute">{{ (!empty($app_data->step2Data->you_obtained))?$app_data->step2Data->you_obtained:'' }}</span>
                                </div>
                            </div>
                            <div id="MainContent_dv_HESA_ID" class="row mb-4 px-5">
                                <div class="col">Subject :</div>
                                <div class="col"><span id="MainContent_lbl_HESA_ID">{{ (!empty($app_data->step2Data->subject))?$app_data->step2Data->subject:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_ULN" class="row mb-4 px-5">
                                <div class="col">Grade :</div>
                                <div class="col"><span id="MainContent_lbl_ULN">{{ (!empty($app_data->step2Data->grade))?$app_data->step2Data->grade:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_QualificationOnEntry" class="row mb-4 px-5">
                                <div class="col">Passport No :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_QualificationOnEntry">{{ (!empty($app_data->step2Data->passport_no))?$app_data->step2Data->passport_no:'' }}</span>
                                </div>
                            </div>
                            <div id="MainContent_dv_QualificationYear" class="row mb-4 px-5">
                                <div class="col">Passport Expiry :</div>
                                <div class="col"><span id="MainContent_lbl_QualificationYear">{{ (!empty($app_data->step2Data->passport_expiry))?$app_data->step2Data->passport_expiry:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_QualificationYear" class="row mb-4 px-5">
                                <div class="col">Passport Place of Issuance :</div>
                                <div class="col"><span id="MainContent_lbl_QualificationYear">{{ (!empty($app_data->step2Data->passport_place))?$app_data->step2Data->passport_place:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_QualificationYear" class="row mb-4 px-5">
                                <div class="col">Have you spent any time in public care up to the age of 18? :</div>
                                <div class="col"><span id="MainContent_lbl_QualificationYear">{{ (!empty($app_data->step2Data->spent_public_care))?$app_data->step2Data->spent_public_care:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_QualificationYear" class="row mb-4 px-5">
                                <div class="col">Disability/special needs :</div>
                                <div class="col"><span id="MainContent_lbl_QualificationYear">{{ (!empty($app_data->step2Data->disability))?$app_data->step2Data->disability:'' }}</span></div>
                            </div>
                        </div>
                        <h5 class="text-center py-3" id="MainContent_dv_HPerm">Permanent Home Address</h5>
                        <div class="container bg-dark py-5 px-5 rounded">
                            <div id="MainContent_dv_PermAdd1" class="row mb-4 px-5">
                                <div class="col">House Number/Name and Street :</div>
                                <div class="col"><span id="MainContent_lbl_PermAdd1">{{ (!empty($app_data->step2Data->house_number))?$app_data->step2Data->house_number:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PermAdd2" class="row mb-4 px-5">
                                <div class="col">Address Line 2 :</div>
                                <div class="col"><span id="MainContent_lbl_PermAdd2">{{ (!empty($app_data->step2Data->address_line_2))?$app_data->step2Data->address_line_2:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PermCounty" class="row mb-4 px-5">
                                <div class="col">State/Province :</div>
                                <div class="col"><span id="MainContent_lbl_PermCounty">{{ (!empty($app_data->step2Data->state))?$app_data->step2Data->state:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PermCity" class="row mb-4 px-5">
                                <div class="col">City/Town :</div>
                                <div class="col"><span id="MainContent_lbl_PermCity">{{ (!empty($app_data->step2Data->city))?$app_data->step2Data->city:'' }}</span></div>
                            </div>

                            <div id="MainContent_dv_PermPostalCode" class="row mb-4 px-5">
                                <div class="col">Postal Code :</div>
                                <div class="col"><span id="MainContent_lbl_PermPostalCode">{{ (!empty($app_data->step2Data->postal_code))?$app_data->step2Data->postal_code:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PerCountry" class="row mb-4 px-5">
                                <div class="col">Country :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_PerCountry">{{ (!empty($app_data->step2Data->address_country))?$app_data->step2Data->address_country:'' }}</span>
                                </div>
                            </div>
                        </div>

                        <h5 class="text-center py-3" id="MainContent_dv_HCor">Current Address</h5>
                        <div class="container bg-dark py-5 px-5 rounded">
                            <div id="MainContent_dv_PermAdd1" class="row mb-4 px-5">
                                <div class="col">House Number/Name and Street :</div>
                                <div class="col"><span id="MainContent_lbl_PermAdd1">{{ (!empty($app_data->step2Data->current_house_number))?$app_data->step2Data->current_house_number:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PermAdd2" class="row mb-4 px-5">
                                <div class="col">Address Line 2 :</div>
                                <div class="col"><span id="MainContent_lbl_PermAdd2">{{ (!empty($app_data->step2Data->current_address_line_2))?$app_data->step2Data->current_address_line_2:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PermCounty" class="row mb-4 px-5">
                                <div class="col">State/Province :</div>
                                <div class="col"><span id="MainContent_lbl_PermCounty">{{ (!empty($app_data->step2Data->current_state))?$app_data->step2Data->current_state:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PermCity" class="row mb-4 px-5">
                                <div class="col">City/Town :</div>
                                <div class="col"><span id="MainContent_lbl_PermCity">{{ (!empty($app_data->step2Data->current_city))?$app_data->step2Data->current_city:'' }}</span></div>
                            </div>

                            <div id="MainContent_dv_PermPostalCode" class="row mb-4 px-5">
                                <div class="col">Postal Code :</div>
                                <div class="col"><span id="MainContent_lbl_PermPostalCode">{{ (!empty($app_data->step2Data->current_postal_code))?$app_data->step2Data->current_postal_code:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PerCountry" class="row mb-4 px-5">
                                <div class="col">Country :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_PerCountry">{{ (!empty($app_data->step2Data->current_country))?$app_data->step2Data->current_country:'' }}</span>
                                </div>
                            </div>
                        </div>
                        <h5 class="text-center py-3" id="MainContent_dv_NextToKin">Next of Kin</h5>
                        <div class="container bg-dark py-5 px-5 rounded">
                            <div id="MainContent_dv_NextToKinName" class="row mb-4 px-5">
                                <div class="col">Name :</div>
                                <div class="col"><span id="MainContent_lbl_NextToKinName">{{ (!empty($app_data->step2Data->kin_name))?$app_data->step2Data->kin_name:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_NextToKinRelation" class="row mb-4 px-5">
                                <div class="col">Relation :</div>
                                <div class="col"><span id="MainContent_lbl_NextToKinRelation">{{ (!empty($app_data->step2Data->kin_relation))?$app_data->step2Data->kin_relation:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_NextToKinHPhoneNo" class="row mb-4 px-5">
                                <div class="col">Phone No :</div>
                                <div class="col"><span id="MainContent_lbl_NextToKinHPhoneNo">{{ (!empty($app_data->step2Data->kin_email))?$app_data->step2Data->kin_email:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_NextToKinEmail" class="row mb-4 px-5">
                                <div class="col">Email :</div>
                                <div class="col"><span id="MainContent_lbl_NextToKinEmail">{{ (!empty($app_data->step2Data->kin_phone))?$app_data->step2Data->kin_phone:'' }}</span></div>
                            </div>
                        </div>
                        <h5 class="text-center py-3" id="MainContent_dv_HPersonalStatement">Personal Statement</h5>
                        <div class="container bg-dark py-5 px-5 rounded">
                            <div id="MainContent_dv_PersonalStatement" class="row mb-4 px-5">
                                <div class="col"><span id="MainContent_lbl_Other_PersonalStatement">{{ (!empty($app_data->step3Data->personal_statement))?$app_data->step3Data->personal_statement:'' }}</span>
                                </div>
                            </div>
                        </div>
                        <h5 class="text-center py-3" id="MainContent_dv_AttachedFiles">Attached Files</h5>
                        <div class="container bg-dark py-5 px-5 rounded">
                            <div id="MainContent_dv_GridView4" class="row mb-4 px-5">
                                <div class="col">
                                    <div class="text-white">
                                        <table class="text-white table" cellspacing="0" rules="all" border="1"
                                            id="MainContent_GridView4" style="border-collapse:collapse;">
                                            <tbody class="text-center">
                                                <tr class="">
                                                    <th class="LCAHidden" scope="col">Applicant ID</th>
                                                    <th scope="col">Document Type</th>
                                                    <th scope="col">Uploaded On</th>
                                                    <th scope="col">Open</th>
                                                </tr>

                                                @forelse ($app_data->applicationDocuments as $row)
                                                <tr>
                                                    <td class="LCAHidden">UKMC-{{ (!empty($row->application_id))?$row->application_id:'' }}</td>
                                                    <td>{{ (!empty($row->document_type))?$row->document_type:'' }}</td>
                                                    <td>{{ date('F d Y',strtotime($row->created_at)) }}</td>
                                                    <td><a download href="{{ asset($row->doc) }}">Download</a></td>
                                                </tr>
                                                @empty
                                                <tr>No Data Found</tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="text-center py-3" id="MainContent_dv_HDeclaration_Text">Declaration<span style="color: Red;">
                                *</span></h5>
                        <div class="container bg-dark py-5 px-5 rounded ">
                            <div id="MainContent_dv_Declaration_Text" class="row mb-4 px-5">
                                <div class="col">
                                    <p id="MainContent_Declaration_Text" class="text-white">
                                        I agree to <span id="MainContent_UniLongName">{{ (!empty($app_data->campus->campus_name))?$app_data->campus->campus_name:'' }}</span> (<span
                                            id="MainContent_UniAbbriv1">{{ (!empty($app_data->campus->campus_name))?$app_data->campus->campus_name:'' }}</span>) processing personal data contained in this
                                        form or
                                        other data
                                        which <span id="MainContent_UniAbbriv2">{{ (!empty($app_data->campus->campus_name))?$app_data->campus->campus_name:'' }}</span> may obtain from other people. I agree
                                        to
                                        the processing of such data for any purposes connected with my
                                        studies or my health and safety whilst on the premises or for any legitimate reason
                                        including
                                        communication with me
                                        following the completion of my studies. In addition, I agree to <span
                                            id="MainContent_UniAbbriv3">{{ (!empty($app_data->campus->campus_name))?$app_data->campus->campus_name:'' }}</span> processing personal data described as Special
                                        Category Data as defined under the General Data Protection Regulation, such processing to be
                                        undertaken for any
                                        purposes as indicated in the declaration above. In addition to the Privacy Notice linked to
                                        this
                                        form please also
                                        see our Corporate Privacy Policy on our website -
                                        <a href="{{ (!empty($app_data->campus->website))?$app_data->campus->website:'' }}" target="_blank">
                                            <font style="color: Blue; text-decoration: underline;">
                                                {{ (!empty($app_data->campus->website))?$app_data->campus->website:'' }}</font>
                                        </a>.
                                    </p>
                                </div>
                            </div>
                            <div id="MainContent_dv_Declaration_cb1_IAcceptStatement" class="row mb-4 px-5 ">
                                <div class="col">
                                    <span class="aspNetDisabled" style="margin: 0;">
                                    <input class="checkbox "
                                        id="MainContent_Declaration_cb1_IAcceptStatement" type="checkbox"
                                        name="ctl00$MainContent$Declaration_cb1_IAcceptStatement" checked="checked"
                                        disabled="disabled">
                                        <label class="text-white" for="MainContent_Declaration_cb1_IAcceptStatement">I
                                        understand
                                        and accept this statement</label>
                                    </span>
                                </div>
                            </div>
                            <div id="MainContent_dv_Declaration_cb2_ICertifyInfoTrue" class="row mb-4 px-5 chkICertifyInfoTrue">
                                <div class="col"><span class="aspNetDisabled" style="margin: 0;"><input class="checkbox"
                                            id="MainContent_Declaration_cb2_ICertifyInfoTrue" type="checkbox"
                                            name="ctl00$MainContent$Declaration_cb2_ICertifyInfoTrue" checked="checked"
                                            disabled="disabled">
                                            <label class="text-white" for="MainContent_Declaration_cb2_ICertifyInfoTrue">I
                                            confirm
                                            that the information I have provided on this application is true, complete and
                                            accurate</label></span></div>
                            </div>
                            <div id="MainContent_dv_Declaration_cb3_ICertifyQualification"
                                class="row mb-4 px-5 chkICertifyQualification">
                                <div class="col"><span class="aspNetDisabled" style="margin: 0;"><input class="checkbox"
                                            id="MainContent_Declaration_cb3_ICertifyQualification" type="checkbox"
                                            name="ctl00$MainContent$Declaration_cb3_ICertifyQualification" checked="checked"
                                            disabled="disabled">
                                            <label class="text-white" for="MainContent_Declaration_cb3_ICertifyQualification">I
                                            confirm that have I have declared all previous study and have listed my highest
                                            qualification</label></span></div>
                            </div>
                            <div id="MainContent_DV_Signed" class="row mb-4 px-5">
                                <div class="col">Signed And Submitted By :</div>
                                <div class="col"><span id="MainContent_lbl_Signed">{{ (!empty($app_data->name))?$app_data->name:'' }}</span></div>
                            </div>
                            <div id="MainContent_Div1" class="row mb-4 px-5">
                                <div class="col">Dated :</div>
                                <div class="col"><span id="MainContent_lbl_Dated">{{ date('F d Y',strtotime($app_data->created_at)) }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="button-action mt-3 ms-3">
                        <a href="{{ URL::to('agent-applications') }}" class="btn btn-secondary btn-prev me-3">Back</a>
                        <a onclick="window.print()" class="btn btn-warning">Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title></title>');
        printWindow.document.write('<style>@media print { body * { display: none; } #print-content { display: block; } }</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<div id="print-content">' + printContents + '</div>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
  </script>
<style>
    @media print {
      body *:not(#download-as-pdf):not(#download-as-pdf *){
        visibility: hidden;
      }
      #download-as-pdf{
        position: absolute;
        top: 0;
        left: 0;
      }
    }
  </style>
@stop
