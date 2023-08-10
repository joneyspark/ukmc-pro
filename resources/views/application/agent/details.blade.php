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
                                <li class="breadcrumb-item active" aria-current="page">Details</li>
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
                <div id="download-as-pdf">
                    <div id="verticalFormStep-five" class="container content fade dstepper-block active" role="tabpanel">
                        <h5 class="text-center mb-3">Application Details ({{ ($app_data->is_academic==1)?'Academic':'Non-academic' }})</h5>
                        <div class="container bg-dark py-5 px-5 rounded">
                            @if($app_data->company_id > 0)
                            <div id="MainContent_DV_FundedBy" class="row mb-4 px-5">
                                <div class="col">Agent</div>
                                <div class="col"><span id="MainContent_lbl_FundedBy">{{ (!empty($app_data->company->company_name))?$app_data->company->company_name:'' }}</span></div>
                            </div>
                            @endif
                            @if(!empty($app_data->reference))
                            <div id="MainContent_DV_ResidentCat" class="row mb-4 px-5">
                                <div class="col">Reference : </div>
                                <div class="col">
                                    <span id="MainContent_lbl_ResidentCat">{{ (!empty($app_data->reference))?$app_data->reference:'' }}</span>
                                </div>
                            </div>
                            @endif
                            <div class="row mb-4 px-5">
                                <div class="col">Name : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->name))?$app_data->name:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Gender : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->gender))?$app_data->gender:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Date Of Birth : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->date_of_birth))?$app_data->date_of_birth:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Email : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->email))?$app_data->email:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Phone : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->phone))?$app_data->phone:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">NI Number : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->ni_number))?$app_data->ni_number:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Emergency Contact Name : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->emergency_contact_name))?$app_data->emergency_contact_name:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Emergency Contact Number : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->emergency_contact_number))?$app_data->emergency_contact_number:'' }}</span></div>
                            </div>
                            @if(!empty($app_data->nationality) && $app_data->nationality!="Other")
                            <div class="row mb-4 px-5">
                                <div class="col">Nationality : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->nationality))?$app_data->nationality:'' }}</span></div>
                            </div>
                            @else
                            <div class="row mb-4 px-5">
                                <div class="col">Other Nationality : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->other_nationality))?$app_data->other_nationality:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Visa Category : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->visa_category))?$app_data->visa_category:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Date Entry Of UK : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->date_entry_of_uk))?$app_data->date_entry_of_uk:'' }}</span></div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Ethnic Origin : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->ethnic_origin))?$app_data->ethnic_origin:'' }}</span></div>
                            </div>
                            @endif
                            <div class="row mb-4 px-5">
                                <div class="col">University : </div>
                                <div class="col"><span id="MainContent_lbl_EUSettlementCode">{{ (!empty($app_data->university->title))?$app_data->university->title:'' }}</span></div>
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
                                <div class="col">Course Intake :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_CourseGroup">{{ (!empty($app_data->intake))?date('F Y',strtotime($app_data->intake)):'' }}</span>

                                </div>
                            </div>
                            <div class="row mb-4 px-5">
                                <div class="col">Delivery Pattern :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_Course">{{ (!empty($app_data->delivery_pattern))?$app_data->delivery_pattern:'' }}</span>
                                </div>
                            </div>
                        </div>
                        <h5 class="text-center py-3" id="MainContent_dv_HPerm">Permanent Address</h5>
                        <div class="container bg-dark py-5 px-5 rounded">
                            <div id="MainContent_dv_PermAdd1" class="row mb-4 px-5">
                                <div class="col">House Number/Name and Street :</div>
                                <div class="col"><span id="MainContent_lbl_PermAdd1">{{ (!empty($app_data->house_number))?$app_data->house_number:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PermAdd2" class="row mb-4 px-5">
                                <div class="col">Address Line 2 :</div>
                                <div class="col"><span id="MainContent_lbl_PermAdd2">{{ (!empty($app_data->address_line_2))?$app_data->address_line_2:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PermCounty" class="row mb-4 px-5">
                                <div class="col">State/Province :</div>
                                <div class="col"><span id="MainContent_lbl_PermCounty">{{ (!empty($app_data->state))?$app_data->state:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PermCity" class="row mb-4 px-5">
                                <div class="col">City/Town :</div>
                                <div class="col"><span id="MainContent_lbl_PermCity">{{ (!empty($app_data->city))?$app_data->city:'' }}</span></div>
                            </div>

                            <div id="MainContent_dv_PermPostalCode" class="row mb-4 px-5">
                                <div class="col">Postal Code :</div>
                                <div class="col"><span id="MainContent_lbl_PermPostalCode">{{ (!empty($app_data->postal_code))?$app_data->postal_code:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PerCountry" class="row mb-4 px-5">
                                <div class="col">Country :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_PerCountry">{{ (!empty($app_data->address_country))?$app_data->address_country:'' }}</span>
                                </div>
                            </div>
                        </div>

                        <h5 class="text-center py-3" id="MainContent_dv_HCor">Current Address</h5>
                        <div class="container bg-dark py-5 px-5 rounded">
                            <div id="MainContent_dv_PermAdd1" class="row mb-4 px-5">
                                <div class="col">House Number/Name and Street :</div>
                                <div class="col"><span id="MainContent_lbl_PermAdd1">{{ (!empty($app_data->current_house_number))?$app_data->current_house_number:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PermAdd2" class="row mb-4 px-5">
                                <div class="col">Address Line 2 :</div>
                                <div class="col"><span id="MainContent_lbl_PermAdd2">{{ (!empty($app_data->current_address_line_2))?$app_data->current_address_line_2:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PermCounty" class="row mb-4 px-5">
                                <div class="col">State/Province :</div>
                                <div class="col"><span id="MainContent_lbl_PermCounty">{{ (!empty($app_data->current_state))?$app_data->current_state:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PermCity" class="row mb-4 px-5">
                                <div class="col">City/Town :</div>
                                <div class="col"><span id="MainContent_lbl_PermCity">{{ (!empty($app_data->current_city))?$app_data->current_city:'' }}</span></div>
                            </div>

                            <div id="MainContent_dv_PermPostalCode" class="row mb-4 px-5">
                                <div class="col">Postal Code :</div>
                                <div class="col"><span id="MainContent_lbl_PermPostalCode">{{ (!empty($app_data->current_postal_code))?$app_data->current_postal_code:'' }}</span></div>
                            </div>
                            <div id="MainContent_dv_PerCountry" class="row mb-4 px-5">
                                <div class="col">Country :</div>
                                <div class="col">
                                    <span id="MainContent_lbl_PerCountry">{{ (!empty($app_data->current_country))?$app_data->current_country:'' }}</span>
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
                                        I hereby, confirm that the information provided on this application form is accurate. I accept that the UKMC/Partner University reserves the right to cancel my application if any of the information that I have submitted is subsequently found to be false or inaccurate and that by signing this declaration, I am bound by the terms and conditions as outlined by the UKMC/Partner University. I give consent to the UKMC/Partner University to process the information on, and submitted with, this form for administrative purposes and for consideration of my application, but only insofar as it is permitted to do so within the constraints imposed by the Data Protection Act 1998.
                                    </p>
                                    <p id="MainContent_Declaration_Text" class="text-white">
                                        In particular, I understand that the UKMC/Partner University may continue to process this information even if I am refused admission or if it should decline an offer of admission. I also give consent to the University/UKMC to contact the Home Office to seek information regarding my immigration status if required, whether to make an assessment of my application or at any time in the future. 
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
                    <form method="post" action="{{ URL::to('step-3-post') }}">
                        
                        <div class="button-action mt-3 ms-3">
                            <a onclick="window.print()" class="btn btn-warning">Print</a>
                        </div>
                    </form>
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
