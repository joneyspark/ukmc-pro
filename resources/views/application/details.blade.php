@extends('adminpanel')
@section('admin')
    <div class="layout-px-spacing">
        <div class="container">
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
                                        <li class="breadcrumb-item"><a href="#">Application</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>

            <div class="card px-5 py-3 mt-3" style="display: block;">
                <h5 class="pt-3 text-center py-3 py-3">Application Details</h5>
                <div class="container bg-dark py-5 px-5 rounded">

                    <div id="MainContent_DV_FundedBy" class="row mb-4 px-5">
                        <div class="col">Will your fees be funded by the Student Loan Company / Student Finance England?
                            :
                        </div>
                        <div class="col"><span id="MainContent_lbl_FundedBy">Yes</span></div>
                    </div>
                    <div id="MainContent_DV_ResidentCat" class="row mb-4 px-5">
                        <div class="col">Residency Status : </div>
                        <div class="col">
                            <span id="MainContent_lbl_ResidentCat">UK Citizen - England</span>

                        </div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">EU Settlement Code : </div>
                        <div class="col"><span id="MainContent_lbl_EUSettlementCode"></span></div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Programme Group :</div>
                        <div class="col">
                            <span id="MainContent_lbl_CourseGroup">Undergraduate</span>

                        </div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Course :</div>
                        <div class="col">
                            <span id="MainContent_lbl_Course">BSc (Hons) International Business Management with Foundation
                                Year</span>

                        </div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Intake :</div>
                        <div class="col">
                            <span id="MainContent_lbl_Intake">September 2023</span>

                        </div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Delivery Pattern :</div>
                        <div class="col">
                            <span id="MainContent_lbl_DeliveryPattern">Standard</span>

                        </div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">This programme will run on one of the following site(s) :</div>
                        <div id="MainContent_dv_sites" class="col">
                            <ul>
                                <li>East India Building - ARU London, Import Building, 2 Clove Crescent, Poplar, London, E14
                                    2BE
                                </li>
                                <li>East India Building - ARU London, Export Building, 2 Clove Crescent, Poplar, London, E14
                                    2BE
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Course Level :</div>
                        <div class="col">
                            <span id="MainContent_lbl_CourseLevel">6</span>


                        </div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Entry Level :</div>
                        <div class="col">
                            <span id="MainContent_lbl_EntryLevel">4</span>

                        </div>
                    </div>

                    <div class="row mb-4 px-5">
                        <div class="col">Course fee (GBP) :</div>
                        <div class="col"><span id="MainContent_lbl_CourseFee">37000</span></div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">First year fee (GBP) :</div>
                        <div class="col"><span id="MainContent_lbl_FirstYearFee">9250</span></div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Title :</div>
                        <div class="col"><span id="MainContent_lbl_Title">Mr</span></div>
                    </div>

                    <div class="row mb-4 px-5">
                        <div class="col">Forename 1 :</div>
                        <div class="col"><span id="MainContent_lbl_FirstName">Nathaniel</span></div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Forename 2 :</div>
                        <div class="col"><span id="MainContent_lbl_Forename2">Adam</span></div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Forename 3 :</div>
                        <div class="col"><span id="MainContent_lbl_Forename3">Peter</span></div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Preferred first name :</div>
                        <div class="col"><span id="MainContent_lbl_PreferredFirstName">Nathaniel</span></div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Surname/family name :</div>
                        <div class="col"><span id="MainContent_lbl_LastName">PERKINS</span></div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Previous surname/family name at 16th birthday :</div>
                        <div class="col"><span id="MainContent_lbl_PreviousSurname"></span></div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Gender :</div>
                        <div class="col">
                            <span id="MainContent_lbl_Gender" class="LCAlblBox">Male</span>

                        </div>
                    </div>
                    <div id="MainContent_dv_email" class="row mb-4 px-5">
                        <div class="col">Email :</div>
                        <div class="col"><span id="MainContent_lbl_Email">nathamkins@gmail.com</span></div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Are you applying for advance entry (APL) :</div>
                        <div class="col"><span id="MainContent_lbl_AplyforExemption">No</span></div>
                    </div>
                    <div id="MainContent_dv_HowHearAboutUS" class="row mb-4 px-5">
                        <div class="col">How did you hear about us? :</div>
                        <div class="col"><span id="MainContent_lbl_HowHearAboutUS">No</span></div>
                    </div>
                </div>
                <h5 class="text-center py-3 p-3" id="MainContent_DV_HPersonalInfo">Personal Info</h5>
                <div class="container bg-dark py-5 px-5 rounded">
                    <div id="MainContent_dv_MobileNo" class="row mb-4 px-5">
                        <div class="col">Mobile No. :</div>
                        <div class="col"><span id="MainContent_lbl_MobileNo">07424377725</span></div>
                    </div>
                    <div id="MainContent_dv_Nationality" class="row mb-4 px-5">
                        <div class="col">Nationality :</div>
                        <div class="col">
                            <span id="MainContent_lbl_Nationality">UK National</span>


                        </div>
                    </div>
                    <div id="MainContent_dv_DualNationality" class="row mb-4 px-5">
                        <div class="col">Dual Nationality :</div>
                        <div class="col">
                            <span id="MainContent_lbl_DualNationality"></span>

                        </div>
                    </div>

                    <div id="MainContent_dv_CountryOfBirth" class="row mb-4 px-5">
                        <div class="col">Country of Birth :</div>
                        <div class="col"><span id="MainContent_lbl_CountryOfBirth">United Kingdom</span>
                        </div>
                    </div>
                    <div id="MainContent_dv_EthnicOriginID" class="row mb-4 px-5">
                        <div class="col">Ethnic Origin :</div>
                        <div class="col">
                            <span id="MainContent_lbl_EthnicOriginID">Other</span>

                        </div>
                    </div>
                    <div id="MainContent_dv_DOB" class="row mb-4 px-5">
                        <div class="col">Date of Birth :</div>
                        <div class="col"><span id="MainContent_lbl_DOB">18/09/1994</span></div>
                    </div>
                    <div id="MainContent_dv_HIghestQualificationFrom" class="row mb-4 px-5">
                        <div class="col">Highest qualification on entry :</div>
                        <div class="col"><span id="MainContent_lbl_HIghestQualificationFrom">UK</span></div>
                    </div>
                    <div id="MainContent_dv_HIghestQualification" class="row mb-4 px-5">
                        <div class="col">Your Highest Qualification :</div>
                        <div class="col">
                            <span id="MainContent_lbl_HIghestQualification">Level 3 Certificate</span>

                        </div>
                    </div>
                    <div id="MainContent_dv_LastEducationalInstitution" class="row mb-4 px-5">
                        <div class="col">Your last institution :</div>
                        <div class="col">
                            <span id="MainContent_lbl_LastEducationalInstitution">UK independent school</span>

                        </div>
                    </div>
                    <div id="MainContent_dv_WhichUKInstitute" class="row mb-4 px-5">
                        <div class="col">Institution Name :</div>
                        <div class="col">
                            <span id="MainContent_lbl_WhichUKInstitute"> </span>

                        </div>
                    </div>
                    <div id="MainContent_dv_HESA_ID" class="row mb-4 px-5">
                        <div class="col">HESA reference number :</div>
                        <div class="col"><span id="MainContent_lbl_HESA_ID"></span></div>
                    </div>
                    <div id="MainContent_dv_ULN" class="row mb-4 px-5">
                        <div class="col">Unique Learner Number (ULN) :</div>
                        <div class="col"><span id="MainContent_lbl_ULN"></span></div>
                    </div>
                    <div id="MainContent_dv_QualificationOnEntry" class="row mb-4 px-5">
                        <div class="col">Name of qualification :</div>
                        <div class="col">
                            <span id="MainContent_lbl_QualificationOnEntry">Other UK qualification at Level 3</span>

                        </div>
                    </div>
                    <div id="MainContent_dv_QualificationYear" class="row mb-4 px-5">
                        <div class="col">Year achieved/obtained :</div>
                        <div class="col"><span id="MainContent_lbl_QualificationYear">2020</span></div>
                    </div>
                    <div id="MainContent_dv_QualificationSubject" class="row mb-4 px-5">
                        <div class="col">Subject :</div>
                        <div class="col"><span id="MainContent_lbl_QualificationSubject">Electrical Maintenance.
                            </span>
                        </div>
                    </div>
                    <div id="MainContent_dv_QualificationGrade" class="row mb-4 px-5">
                        <div class="col">Grade :</div>
                        <div class="col"><span id="MainContent_lbl_QualificationGrade">Pass</span></div>
                    </div>
                    <div id="MainContent_dv_PassportNo" class="row mb-4 px-5">
                        <div class="col">Passport No. :</div>
                        <div class="col"><span id="MainContent_lbl_PassportNo"></span></div>
                    </div>
                    <div id="MainContent_dv_PassportExpiree" class="row mb-4 px-5">
                        <div class="col">Passport Expiry. :</div>
                        <div class="col"><span id="MainContent_lbl_PassportExpiree"></span></div>
                    </div>
                    <div id="MainContent_dv_PassportPlaceIssuance" class="row mb-4 px-5">
                        <div class="col">Passport Place of Issuance :</div>
                        <div class="col"><span id="MainContent_lbl_PassportPlaceIssuance">UK</span></div>
                    </div>
                    <div class="row mb-4 px-5">
                        <div class="col">Care Leaver :</div>
                        <div class="col">
                            <span id="MainContent_lbl_CareLeaver">Not a care leaver</span>

                        </div>
                    </div>
                    <div id="MainContent_dv_Disablity" class="row mb-4 px-5">
                        <div class="col">Disability/special needs :</div>
                        <div class="col">
                            <span id="MainContent_lbl_Disablity">No disability</span>

                        </div>
                    </div>
                    <div id="MainContent_dv_AlradyINUK" class="row mb-4 px-5">
                        <div class="col">Currently Living in UK :</div>
                        <div class="col"><span id="MainContent_lbl_AlradyINUK"></span></div>
                    </div>
                </div>
                <h5 class="text-center py-3" id="MainContent_dv_HPerm">Permanent Home Address</h5>
                <div class="container bg-dark py-5 px-5 rounded">
                    <div id="MainContent_dv_PermAdd1" class="row mb-4 px-5">
                        <div class="col">House Number/Name and Street :</div>
                        <div class="col"><span id="MainContent_lbl_PermAdd1">22A Kent House</span></div>
                    </div>
                    <div id="MainContent_dv_PermAdd2" class="row mb-4 px-5">
                        <div class="col">Address Line 2 :</div>
                        <div class="col"><span id="MainContent_lbl_PermAdd2"></span></div>
                    </div>

                    <div id="MainContent_dv_PermCity" class="row mb-4 px-5">
                        <div class="col">City/Town :</div>
                        <div class="col"><span id="MainContent_lbl_PermCity">London</span></div>
                    </div>
                    <div id="MainContent_dv_PermCounty" class="row mb-4 px-5">
                        <div class="col">County/State/Province :</div>
                        <div class="col"><span id="MainContent_lbl_PermCounty">London</span></div>
                    </div>
                    <div id="MainContent_dv_PermPostalCode" class="row mb-4 px-5">
                        <div class="col">Postal Code :</div>
                        <div class="col"><span id="MainContent_lbl_PermPostalCode">SE15EQ</span></div>
                    </div>
                    <div id="MainContent_dv_PerCountry" class="row mb-4 px-5">
                        <div class="col">Country :</div>
                        <div class="col">
                            <span id="MainContent_lbl_PerCountry">United Kingdom</span>

                        </div>
                    </div>
                    <div id="MainContent_dv_PermPhoneNo" class="row mb-4 px-5">
                        <div class="col">Phone No. :</div>
                        <div class="col"><span id="MainContent_lbl_PermPhoneNo"></span></div>
                    </div>
                    <div id="MainContent_dv_Domicile" class="row mb-4 px-5">
                        <div class="col">Country of permanent residence :</div>
                        <div class="col"><span id="MainContent_lbl_Domicile">United Kingdom</span></div>

                    </div>
                </div>

                <h5 class="text-center py-3" id="MainContent_dv_HCor">Current Address</h5>
                <div class="container bg-dark py-5 px-5 rounded">
                    <div id="MainContent_dv_CorAdd1" class="row mb-4 px-5">
                        <div class="col">House Number/Name and Street :</div>
                        <div class="col"><span id="MainContent_lbl_CorAdd1">22A Kent House</span></div>
                    </div>
                    <div id="MainContent_dv_CorAdd2" class="row mb-4 px-5">
                        <div class="col">Address Line 2 :</div>
                        <div class="col"><span id="MainContent_lbl_CorAdd2"></span></div>
                    </div>

                    <div id="MainContent_dv_CorCity" class="row mb-4 px-5">
                        <div class="col">City/Town :</div>
                        <div class="col"><span id="MainContent_lbl_CorCity">London</span></div>
                    </div>
                    <div id="MainContent_dv_CorCounty" class="row mb-4 px-5">
                        <div class="col">County/State/Province :</div>
                        <div class="col"><span id="MainContent_lbl_CorCounty">London</span></div>
                    </div>
                    <div id="MainContent_dv_CorPostalCode" class="row mb-4 px-5">
                        <div class="col">Postal Code :</div>
                        <div class="col"><span id="MainContent_lbl_CorPostalCode">SE15EQ</span></div>
                    </div>
                    <div id="MainContent_dv_CorCountry" class="row mb-4 px-5">
                        <div class="col">Country :</div>
                        <div class="col">
                            <span id="MainContent_lbl_CorCountry">United Kingdom</span>

                        </div>
                    </div>
                    <div id="MainContent_dv_CorPhoneNo" class="row mb-4 px-5">
                        <div class="col">Phone No. :</div>
                        <div class="col"><span id="MainContent_lbl_CorPhoneNo"></span></div>
                    </div>
                </div>
                <h5 class="text-center py-3" id="MainContent_dv_NextToKin">Next of Kin</h5>
                <div class="container bg-dark py-5 px-5 rounded">
                    <div id="MainContent_dv_NextToKinName" class="row mb-4 px-5">
                        <div class="col">Name :</div>
                        <div class="col"><span id="MainContent_lbl_NextToKinName"></span></div>
                    </div>
                    <div id="MainContent_dv_NextToKinRelation" class="row mb-4 px-5">
                        <div class="col">Relation :</div>
                        <div class="col"><span id="MainContent_lbl_NextToKinRelation"></span></div>
                    </div>
                    <div id="MainContent_dv_NextToKinHPhoneNo" class="row mb-4 px-5">
                        <div class="col">Phone No :</div>
                        <div class="col"><span id="MainContent_lbl_NextToKinHPhoneNo"></span></div>
                    </div>
                    <div id="MainContent_dv_NextToKinEmail" class="row mb-4 px-5">
                        <div class="col">Email :</div>
                        <div class="col"><span id="MainContent_lbl_NextToKinEmail"></span></div>
                    </div>
                </div>
                <h5 class="text-center py-3" id="MainContent_dv_HPersonalStatement">Personal Statement</h5>
                <div class="container bg-dark py-5 px-5 rounded">
                    <div id="MainContent_dv_PersonalStatement" class="row mb-4 px-5">
                        <div class="col"><span id="MainContent_lbl_Other_PersonalStatement"> As someone with a Level 3
                                Certificate in Electrical Maintenance, I have gained a valuable foundation of technical
                                knowledge and practical skills that I believe will be highly relevant to my studies in BSc
                                (Hons) International Business Management at ARU London. Through my education and work
                                experience, I have developed a range of transferable skills that I believe will enable me to
                                succeed in a variety of professional settings.My interest in business and management has
                                grown
                                over time, and I am excited about the opportunity to explore this field in greater depth
                                through
                                my studies at ARU London. I am particularly interested in international business, as I
                                believe
                                that the global economy presents a wealth of opportunities and challenges that will require
                                a
                                deep understanding of different cultures, customs, and business practices.In addition to my
                                technical knowledge and practical skills, I have also developed a range of soft skills that
                                I
                                believe will be highly relevant to my studies in International Business Management. These
                                include effective communication, problem-solving, and teamwork. As an electrical maintenance
                                technician, I was required to work closely with clients, suppliers, and colleagues to ensure
                                that projects were completed on time and to a high standard of quality. This experience has
                                taught me how to effectively communicate with a diverse range of stakeholders and to build
                                strong relationships based on trust and mutual respect.Furthermore, my work in electrical
                                maintenance has taught me how to solve complex problems, think critically, and adapt to
                                changing
                                situations. These skills will be highly valuable in a business context, where I will need to
                                identify and address complex challenges effectively.Overall, I am excited about the
                                opportunity
                                to apply my technical knowledge and practical skills, as well as my soft skills in
                                communication, problem-solving, and teamwork, to my studies in International Business
                                Management
                                at ARU London. I am confident that my passion for business and management, coupled with my
                                diverse range of skills and experiences, will enable me to make meaningful contributions to
                                the
                                program and achieve success in my future career. I look forward to the challenges and
                                opportunities that lie ahead, and I am committed to working hard to achieve my goals.</span>
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
                                            <th class="LCAHidden" scope="col">ID</th>
                                            <th class="LCAHidden" scope="col">Applicant ID</th>
                                            <th scope="col">Filename</th>
                                            <th scope="col">Detail</th>
                                            <th scope="col">Uploaded On</th>
                                        </tr>
                                        <tr>
                                            <td class="LCAHidden">775331</td>
                                            <td class="LCAHidden">13257442</td>
                                            <td>001_level 3.pdf</td>
                                            <td>&nbsp;</td>
                                            <td>10/05/2023 16:37:06</td>
                                        </tr>
                                        <tr>
                                            <td class="LCAHidden">775333</td>
                                            <td class="LCAHidden">13257442</td>
                                            <td>002_NathanielPeterCV.pdf</td>
                                            <td>&nbsp;</td>
                                            <td>10/05/2023 16:37:15</td>
                                        </tr>
                                        <tr>
                                            <td class="LCAHidden">775335</td>
                                            <td class="LCAHidden">13257442</td>
                                            <td>003_passport.jpg</td>
                                            <td>&nbsp;</td>
                                            <td>10/05/2023 16:37:46</td>
                                        </tr>
                                        <tr>
                                            <td class="LCAHidden">775337</td>
                                            <td class="LCAHidden">13257442</td>
                                            <td>004_ARUApplication.pdf</td>
                                            <td>Submited Application</td>
                                            <td>10/05/2023 16:39:38</td>
                                        </tr>
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
                                I agree to <span id="MainContent_UniLongName">Anglia Ruskin University London</span> (<span
                                    id="MainContent_UniAbbriv1">ARUL</span>) processing personal data contained in this
                                form or
                                other data
                                which <span id="MainContent_UniAbbriv2">ARUL</span> may obtain from other people. I agree
                                to
                                the processing of such data for any purposes connected with my
                                studies or my health and safety whilst on the premises or for any legitimate reason
                                including
                                communication with me
                                following the completion of my studies. In addition, I agree to <span
                                    id="MainContent_UniAbbriv3">ARUL</span> processing personal data described as Special
                                Category Data as defined under the General Data Protection Regulation, such processing to be
                                undertaken for any
                                purposes as indicated in the declaration above. In addition to the Privacy Notice linked to
                                this
                                form please also
                                see our Corporate Privacy Policy on our website -
                                <a href="https://www.anglia.ac.uk/privacy-and-cookies" target="_blank">
                                    <font style="color: Blue; text-decoration: underline;">
                                        https://www.anglia.ac.uk/privacy-and-cookies</font>
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
                        <div class="col"><span id="MainContent_lbl_Signed">Nathaniel</span></div>
                    </div>
                    <div id="MainContent_Div1" class="row mb-4 px-5">
                        <div class="col">Dated :</div>
                        <div class="col"><span id="MainContent_lbl_Dated">10/05/2023 16:39:36</span></div>
                    </div>
                    <div id="MainContent_DV_Btns" class="row mb-4 px-5">
                        <div class="col">
                            <input type="submit" name="ctl00$MainContent$Btn_SaveContinue" value="Back"
                                id="MainContent_Btn_SaveContinue" class="btn btn-warning">

                            <input type="submit" name="ctl00$MainContent$Btn_Download" value="Download PDF"
                                onclick="ShowDownlaod();" id="MainContent_Btn_Download" class="btn btn-success">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop
