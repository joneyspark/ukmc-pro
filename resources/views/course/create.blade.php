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
                                        <li class="breadcrumb-item"><a href="#">Application</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <form enctype="multipart/form-data">
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
                                                for="represent_country">Select Country</label><select
                                                class="form-control" id="represent_country" name="represent_country">
                                                <option disabled="" value="">Select Represent
                                                    Country</option>
                                                <option value="1">United Kingdom</option>
                                                <option value="2">Australia</option>
                                                <option value="3">United States</option>
                                                <option value="4">Canada</option>
                                                <option value="cc62d0833e6545c79e32089c78bf41bc">New
                                                    Zealand</option>
                                                <option value="ce9d34b2590d4c2886a15126b9e61c2b">
                                                    Ireland</option>
                                                <option value="e0fd049e09d84782a14558530ae2c317">
                                                    Germany</option>
                                            </select>
                                            <ul data-v-6fe86a0f=""  >
                                                <!---->
                                            </ul>
                                        </div>
                                        <!---->
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Name</label><input
                                            type="text" class="form-control" name="course_name">
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Category</label><select
                                            class="form-control">
                                            <option disabled="" value="">Select a Category
                                            </option>
                                            <option value="19">Accounting, Business Management
                                                &amp; Economics</option>
                                            <option value="3">Accounting, Finance and Economics
                                            </option>
                                            <option value="45">Aerospace Engineering</option>
                                            <option value="65">Animation and Illustration</option>
                                            <option value="26">Architecture</option>
                                            <option value="38">Arts</option>
                                            <option value="48">Biological and Medical Sciences
                                            </option>
                                            <option value="5">Built Environment and Construction
                                            </option>
                                            <option value="28">Business Administration and
                                                Management</option>
                                            <option value="30">Business Data Analytics</option>
                                            <option value="41">Communication</option>
                                            <option value="44">Community Development</option>
                                            <option value="63">Computer Science</option>
                                            <option value="17">Computer Security Systems
                                                Information Security</option>
                                            <option value="6">Computing</option>
                                            <option value="27">Criminology</option>
                                            <option value="16">Data Analytics</option>
                                            <option value="64">Designing</option>
                                            <option value="66">Digital Technology</option>
                                            <option value="32">Economics and International
                                                Relations</option>
                                            <option value="33">Economics and Politics</option>
                                            <option value="21">Education</option>
                                            <option value="7">Engineering</option>
                                            <option value="37">English literature</option>
                                            <option value="58">Fashion Business &amp; Management
                                            </option>
                                            <option value="62">Food and Nutrition</option>
                                            <option value="14">Healthcare and Nursing</option>
                                            <option value="55">Hospitality, Events and Tourism
                                            </option>
                                            <option value="12">Human Resource Management and
                                                Psychology</option>
                                            <option value="57">Humanities and Social Sciences
                                            </option>
                                            <option value="1">Law</option>
                                            <option value="61">Marketing</option>
                                            <option value="2">Media and Journalism</option>
                                            <option value="56">Music and Performance</option>
                                            <option value="42">Pharmaceutical</option>
                                            <option value="9">Politics and International
                                                Development</option>
                                            <option value="18">Project Management</option>
                                            <option value="11">Psychology</option>
                                            <option value="20">Science</option>
                                            <option value="52">Social Work and Community</option>
                                            <option value="54">Sociology</option>
                                            <option value="50">Sports</option>
                                            <option value="51">Teaching and Education</option>
                                        </select>
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Level</label><select
                                            class="form-control">
                                            <option disabled="" value="">Select Course Level
                                            </option>
                                            <option value="1">Undergraduate</option>
                                            <option value="11">HNC/HND - Level 4 &amp; 5</option>
                                            <option value="2">Postgraduate</option>
                                            <option value="3">Foundation</option>
                                            <option value="3a302819542b48999287e2ad0547b68a">Grade 12
                                            </option>
                                            <option value="4">Postgraduate Research (PhD /DBA)
                                            </option>
                                            <option value="5">Level 3</option>
                                            <option value="7">Level 5</option>
                                            <option value="8">Level 4</option>
                                            <option value="b9aa89da45bd41aba5e043e28ce54d84">
                                                Pre-Master's</option>
                                            <option value="ebf62c2957cf4d52ac7411242f9a9495">Diploma
                                            </option>
                                        </select>
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Duration</label><input
                                            type="text" class="form-control"
                                            name="course_duration">
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4 col-md-10"><label
                                            for="exampleFormControlInput1">Campus Name</label><input
                                            type="text" class="form-control" name="campus_name">
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="Icon-outside field-wrapper form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Fee (For
                                            Local)</label>
                                        <!----><input type="text"
                                            class="course-fee-input form-control" name="course_fee">
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="Icon-outside form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Fee (For
                                            International Students)</label>
                                        <!----><input type="text"
                                            class="course-fee-input form-control" name="course_fee">
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Course Intake</label><input
                                            type="text" class="form-control" name="course_intake">
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Awarding Body</label><input
                                            type="text" class="form-control" name="awarding_body">
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlInput1">Is Language Mendatory</label><input
                                            type="text" class="form-control"
                                            placeholder="Yes or No" name="is_lang_mendatory">
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                {{-- <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="lang_requirements">Language Requirements</label>
                                        <div class="editor-container">
                                            <div class="editor-toolbox"><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                        class="icon">
                                                        <path
                                                            d="M321.1 242.4C340.1 220.1 352 191.6 352 160c0-70.59-57.42-128-128-128L32 32.01c-17.67 0-32 14.31-32 32s14.33 32 32 32h16v320H32c-17.67 0-32 14.31-32 32s14.33 32 32 32h224c70.58 0 128-57.41 128-128C384 305.3 358.6 264.8 321.1 242.4zM112 96.01H224c35.3 0 64 28.72 64 64s-28.7 64-64 64H112V96.01zM256 416H112v-128H256c35.3 0 64 28.71 64 63.1S291.3 416 256 416z">
                                                        </path>
                                                    </svg></button><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                        class="icon">
                                                        <path
                                                            d="M384 64.01c0 17.69-14.31 32-32 32h-58.67l-133.3 320H224c17.69 0 32 14.31 32 32s-14.31 32-32 32H32c-17.69 0-32-14.31-32-32s14.31-32 32-32h58.67l133.3-320H160c-17.69 0-32-14.31-32-32s14.31-32 32-32h192C369.7 32.01 384 46.33 384 64.01z">
                                                        </path>
                                                    </svg></button><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                        class="icon">
                                                        <path
                                                            d="M416 448H32c-17.69 0-32 14.31-32 32s14.31 32 32 32h384c17.69 0 32-14.31 32-32S433.7 448 416 448zM48 64.01H64v160c0 88.22 71.78 159.1 160 159.1s160-71.78 160-159.1v-160h16c17.69 0 32-14.32 32-32s-14.31-31.1-32-31.1l-96-.0049c-17.69 0-32 14.32-32 32s14.31 32 32 32H320v160c0 52.94-43.06 95.1-96 95.1S128 276.1 128 224v-160h16c17.69 0 32-14.31 32-32s-14.31-32-32-32l-96 .0049c-17.69 0-32 14.31-32 31.1S30.31 64.01 48 64.01z">
                                                        </path>
                                                    </svg></button><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                        class="icon">
                                                        <path
                                                            d="M88 48C101.3 48 112 58.75 112 72V120C112 133.3 101.3 144 88 144H40C26.75 144 16 133.3 16 120V72C16 58.75 26.75 48 40 48H88zM480 64C497.7 64 512 78.33 512 96C512 113.7 497.7 128 480 128H192C174.3 128 160 113.7 160 96C160 78.33 174.3 64 192 64H480zM480 224C497.7 224 512 238.3 512 256C512 273.7 497.7 288 480 288H192C174.3 288 160 273.7 160 256C160 238.3 174.3 224 192 224H480zM480 384C497.7 384 512 398.3 512 416C512 433.7 497.7 448 480 448H192C174.3 448 160 433.7 160 416C160 398.3 174.3 384 192 384H480zM16 232C16 218.7 26.75 208 40 208H88C101.3 208 112 218.7 112 232V280C112 293.3 101.3 304 88 304H40C26.75 304 16 293.3 16 280V232zM88 368C101.3 368 112 378.7 112 392V440C112 453.3 101.3 464 88 464H40C26.75 464 16 453.3 16 440V392C16 378.7 26.75 368 40 368H88z">
                                                        </path>
                                                    </svg></button>
                                                <div class="header-div"><svg xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 448 512" class="icon cursor-pointer">
                                                        <path
                                                            d="M448 448c0 17.69-14.33 32-32 32h-96c-17.67 0-32-14.31-32-32s14.33-32 32-32h16v-144h-224v144H128c17.67 0 32 14.31 32 32s-14.33 32-32 32H32c-17.67 0-32-14.31-32-32s14.33-32 32-32h16v-320H32c-17.67 0-32-14.31-32-32s14.33-32 32-32h96c17.67 0 32 14.31 32 32s-14.33 32-32 32H112v112h224v-112H320c-17.67 0-32-14.31-32-32s14.33-32 32-32h96c17.67 0 32 14.31 32 32s-14.33 32-32 32h-16v320H416C433.7 416 448 430.3 448 448z">
                                                        </path>
                                                    </svg>
                                                    <!---->
                                                </div>
                                            </div>
                                            <div>
                                                <div contenteditable="true" translate="no"
                                                    class="ProseMirror w-full prose prose-stone p-2 md:p-4 dark:prose-invert focus:outline-none"
                                                    tabindex="0">
                                                    <p><br class="ProseMirror-trailingBreak"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div> --}}
                                {{-- <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="general_eligibility">General Eligibility</label>
                                        <div class="editor-container">
                                            <div class="editor-toolbox"><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                        class="icon">
                                                        <path
                                                            d="M321.1 242.4C340.1 220.1 352 191.6 352 160c0-70.59-57.42-128-128-128L32 32.01c-17.67 0-32 14.31-32 32s14.33 32 32 32h16v320H32c-17.67 0-32 14.31-32 32s14.33 32 32 32h224c70.58 0 128-57.41 128-128C384 305.3 358.6 264.8 321.1 242.4zM112 96.01H224c35.3 0 64 28.72 64 64s-28.7 64-64 64H112V96.01zM256 416H112v-128H256c35.3 0 64 28.71 64 63.1S291.3 416 256 416z">
                                                        </path>
                                                    </svg></button><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                        class="icon">
                                                        <path
                                                            d="M384 64.01c0 17.69-14.31 32-32 32h-58.67l-133.3 320H224c17.69 0 32 14.31 32 32s-14.31 32-32 32H32c-17.69 0-32-14.31-32-32s14.31-32 32-32h58.67l133.3-320H160c-17.69 0-32-14.31-32-32s14.31-32 32-32h192C369.7 32.01 384 46.33 384 64.01z">
                                                        </path>
                                                    </svg></button><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                        class="icon">
                                                        <path
                                                            d="M416 448H32c-17.69 0-32 14.31-32 32s14.31 32 32 32h384c17.69 0 32-14.31 32-32S433.7 448 416 448zM48 64.01H64v160c0 88.22 71.78 159.1 160 159.1s160-71.78 160-159.1v-160h16c17.69 0 32-14.32 32-32s-14.31-31.1-32-31.1l-96-.0049c-17.69 0-32 14.32-32 32s14.31 32 32 32H320v160c0 52.94-43.06 95.1-96 95.1S128 276.1 128 224v-160h16c17.69 0 32-14.31 32-32s-14.31-32-32-32l-96 .0049c-17.69 0-32 14.31-32 31.1S30.31 64.01 48 64.01z">
                                                        </path>
                                                    </svg></button><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                        class="icon">
                                                        <path
                                                            d="M88 48C101.3 48 112 58.75 112 72V120C112 133.3 101.3 144 88 144H40C26.75 144 16 133.3 16 120V72C16 58.75 26.75 48 40 48H88zM480 64C497.7 64 512 78.33 512 96C512 113.7 497.7 128 480 128H192C174.3 128 160 113.7 160 96C160 78.33 174.3 64 192 64H480zM480 224C497.7 224 512 238.3 512 256C512 273.7 497.7 288 480 288H192C174.3 288 160 273.7 160 256C160 238.3 174.3 224 192 224H480zM480 384C497.7 384 512 398.3 512 416C512 433.7 497.7 448 480 448H192C174.3 448 160 433.7 160 416C160 398.3 174.3 384 192 384H480zM16 232C16 218.7 26.75 208 40 208H88C101.3 208 112 218.7 112 232V280C112 293.3 101.3 304 88 304H40C26.75 304 16 293.3 16 280V232zM88 368C101.3 368 112 378.7 112 392V440C112 453.3 101.3 464 88 464H40C26.75 464 16 453.3 16 440V392C16 378.7 26.75 368 40 368H88z">
                                                        </path>
                                                    </svg></button>
                                                <div class="header-div"><svg xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 448 512" class="icon cursor-pointer">
                                                        <path
                                                            d="M448 448c0 17.69-14.33 32-32 32h-96c-17.67 0-32-14.31-32-32s14.33-32 32-32h16v-144h-224v144H128c17.67 0 32 14.31 32 32s-14.33 32-32 32H32c-17.67 0-32-14.31-32-32s14.33-32 32-32h16v-320H32c-17.67 0-32-14.31-32-32s14.33-32 32-32h96c17.67 0 32 14.31 32 32s-14.33 32-32 32H112v112h224v-112H320c-17.67 0-32-14.31-32-32s14.33-32 32-32h96c17.67 0 32 14.31 32 32s-14.33 32-32 32h-16v320H416C433.7 416 448 430.3 448 448z">
                                                        </path>
                                                    </svg>
                                                    <!---->
                                                </div>
                                            </div>
                                            <div>
                                                <div contenteditable="true" translate="no"
                                                    class="ProseMirror w-full prose prose-stone p-2 md:p-4 dark:prose-invert focus:outline-none"
                                                    tabindex="0">
                                                    <p><br class="ProseMirror-trailingBreak"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div> --}}
                            </div>
                            {{-- <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlTextarea1">Course Benifits</label>
                                        <div class="editor-container">
                                            <div class="editor-toolbox"><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                        class="icon">
                                                        <path
                                                            d="M321.1 242.4C340.1 220.1 352 191.6 352 160c0-70.59-57.42-128-128-128L32 32.01c-17.67 0-32 14.31-32 32s14.33 32 32 32h16v320H32c-17.67 0-32 14.31-32 32s14.33 32 32 32h224c70.58 0 128-57.41 128-128C384 305.3 358.6 264.8 321.1 242.4zM112 96.01H224c35.3 0 64 28.72 64 64s-28.7 64-64 64H112V96.01zM256 416H112v-128H256c35.3 0 64 28.71 64 63.1S291.3 416 256 416z">
                                                        </path>
                                                    </svg></button><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                        class="icon">
                                                        <path
                                                            d="M384 64.01c0 17.69-14.31 32-32 32h-58.67l-133.3 320H224c17.69 0 32 14.31 32 32s-14.31 32-32 32H32c-17.69 0-32-14.31-32-32s14.31-32 32-32h58.67l133.3-320H160c-17.69 0-32-14.31-32-32s14.31-32 32-32h192C369.7 32.01 384 46.33 384 64.01z">
                                                        </path>
                                                    </svg></button><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                        class="icon">
                                                        <path
                                                            d="M416 448H32c-17.69 0-32 14.31-32 32s14.31 32 32 32h384c17.69 0 32-14.31 32-32S433.7 448 416 448zM48 64.01H64v160c0 88.22 71.78 159.1 160 159.1s160-71.78 160-159.1v-160h16c17.69 0 32-14.32 32-32s-14.31-31.1-32-31.1l-96-.0049c-17.69 0-32 14.32-32 32s14.31 32 32 32H320v160c0 52.94-43.06 95.1-96 95.1S128 276.1 128 224v-160h16c17.69 0 32-14.31 32-32s-14.31-32-32-32l-96 .0049c-17.69 0-32 14.31-32 31.1S30.31 64.01 48 64.01z">
                                                        </path>
                                                    </svg></button><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                        class="icon">
                                                        <path
                                                            d="M88 48C101.3 48 112 58.75 112 72V120C112 133.3 101.3 144 88 144H40C26.75 144 16 133.3 16 120V72C16 58.75 26.75 48 40 48H88zM480 64C497.7 64 512 78.33 512 96C512 113.7 497.7 128 480 128H192C174.3 128 160 113.7 160 96C160 78.33 174.3 64 192 64H480zM480 224C497.7 224 512 238.3 512 256C512 273.7 497.7 288 480 288H192C174.3 288 160 273.7 160 256C160 238.3 174.3 224 192 224H480zM480 384C497.7 384 512 398.3 512 416C512 433.7 497.7 448 480 448H192C174.3 448 160 433.7 160 416C160 398.3 174.3 384 192 384H480zM16 232C16 218.7 26.75 208 40 208H88C101.3 208 112 218.7 112 232V280C112 293.3 101.3 304 88 304H40C26.75 304 16 293.3 16 280V232zM88 368C101.3 368 112 378.7 112 392V440C112 453.3 101.3 464 88 464H40C26.75 464 16 453.3 16 440V392C16 378.7 26.75 368 40 368H88z">
                                                        </path>
                                                    </svg></button>
                                                <div class="header-div"><svg xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 448 512" class="icon cursor-pointer">
                                                        <path
                                                            d="M448 448c0 17.69-14.33 32-32 32h-96c-17.67 0-32-14.31-32-32s14.33-32 32-32h16v-144h-224v144H128c17.67 0 32 14.31 32 32s-14.33 32-32 32H32c-17.67 0-32-14.31-32-32s14.33-32 32-32h16v-320H32c-17.67 0-32-14.31-32-32s14.33-32 32-32h96c17.67 0 32 14.31 32 32s-14.33 32-32 32H112v112h224v-112H320c-17.67 0-32-14.31-32-32s14.33-32 32-32h96c17.67 0 32 14.31 32 32s-14.33 32-32 32h-16v320H416C433.7 416 448 430.3 448 448z">
                                                        </path>
                                                    </svg>
                                                    <!---->
                                                </div>
                                            </div>
                                            <div>
                                                <div contenteditable="true" translate="no"
                                                    class="ProseMirror w-full prose prose-stone p-2 md:p-4 dark:prose-invert focus:outline-none"
                                                    tabindex="0">
                                                    <p><br class="ProseMirror-trailingBreak"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <ul data-v-6fe86a0f=""  >
                                            <!---->
                                        </ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-4"><label
                                            for="exampleFormControlTextarea1"> Part Time Work Details</label>
                                        <div class="editor-container">
                                            <div class="editor-toolbox"><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                        class="icon">
                                                        <path
                                                            d="M321.1 242.4C340.1 220.1 352 191.6 352 160c0-70.59-57.42-128-128-128L32 32.01c-17.67 0-32 14.31-32 32s14.33 32 32 32h16v320H32c-17.67 0-32 14.31-32 32s14.33 32 32 32h224c70.58 0 128-57.41 128-128C384 305.3 358.6 264.8 321.1 242.4zM112 96.01H224c35.3 0 64 28.72 64 64s-28.7 64-64 64H112V96.01zM256 416H112v-128H256c35.3 0 64 28.71 64 63.1S291.3 416 256 416z">
                                                        </path>
                                                    </svg></button><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                        class="icon">
                                                        <path
                                                            d="M384 64.01c0 17.69-14.31 32-32 32h-58.67l-133.3 320H224c17.69 0 32 14.31 32 32s-14.31 32-32 32H32c-17.69 0-32-14.31-32-32s14.31-32 32-32h58.67l133.3-320H160c-17.69 0-32-14.31-32-32s14.31-32 32-32h192C369.7 32.01 384 46.33 384 64.01z">
                                                        </path>
                                                    </svg></button><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                        class="icon">
                                                        <path
                                                            d="M416 448H32c-17.69 0-32 14.31-32 32s14.31 32 32 32h384c17.69 0 32-14.31 32-32S433.7 448 416 448zM48 64.01H64v160c0 88.22 71.78 159.1 160 159.1s160-71.78 160-159.1v-160h16c17.69 0 32-14.32 32-32s-14.31-31.1-32-31.1l-96-.0049c-17.69 0-32 14.32-32 32s14.31 32 32 32H320v160c0 52.94-43.06 95.1-96 95.1S128 276.1 128 224v-160h16c17.69 0 32-14.31 32-32s-14.31-32-32-32l-96 .0049c-17.69 0-32 14.31-32 31.1S30.31 64.01 48 64.01z">
                                                        </path>
                                                    </svg></button><button type="button" class="editor-btn"><svg
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                        class="icon">
                                                        <path
                                                            d="M88 48C101.3 48 112 58.75 112 72V120C112 133.3 101.3 144 88 144H40C26.75 144 16 133.3 16 120V72C16 58.75 26.75 48 40 48H88zM480 64C497.7 64 512 78.33 512 96C512 113.7 497.7 128 480 128H192C174.3 128 160 113.7 160 96C160 78.33 174.3 64 192 64H480zM480 224C497.7 224 512 238.3 512 256C512 273.7 497.7 288 480 288H192C174.3 288 160 273.7 160 256C160 238.3 174.3 224 192 224H480zM480 384C497.7 384 512 398.3 512 416C512 433.7 497.7 448 480 448H192C174.3 448 160 433.7 160 416C160 398.3 174.3 384 192 384H480zM16 232C16 218.7 26.75 208 40 208H88C101.3 208 112 218.7 112 232V280C112 293.3 101.3 304 88 304H40C26.75 304 16 293.3 16 280V232zM88 368C101.3 368 112 378.7 112 392V440C112 453.3 101.3 464 88 464H40C26.75 464 16 453.3 16 440V392C16 378.7 26.75 368 40 368H88z">
                                                        </path>
                                                    </svg></button>
                                                <div class="header-div"><svg xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 448 512" class="icon cursor-pointer">
                                                        <path
                                                            d="M448 448c0 17.69-14.33 32-32 32h-96c-17.67 0-32-14.31-32-32s14.33-32 32-32h16v-144h-224v144H128c17.67 0 32 14.31 32 32s-14.33 32-32 32H32c-17.67 0-32-14.31-32-32s14.33-32 32-32h16v-320H32c-17.67 0-32-14.31-32-32s14.33-32 32-32h96c17.67 0 32 14.31 32 32s-14.33 32-32 32H112v112h224v-112H320c-17.67 0-32-14.31-32-32s14.33-32 32-32h96c17.67 0 32 14.31 32 32s-14.33 32-32 32h-16v320H416C433.7 416 448 430.3 448 448z">
                                                        </path>
                                                    </svg>
                                                    <!---->
                                                </div>
                                            </div>
                                            <div>
                                                <div contenteditable="true" translate="no"
                                                    class="ProseMirror w-full prose prose-stone p-2 md:p-4 dark:prose-invert focus:outline-none"
                                                    tabindex="0">
                                                    <p><br class="ProseMirror-trailingBreak"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
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
                                                        type="file" class="form-control-file"></label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row d-flex align-items-center">
                                        <div class="col col-md-8">
                                            <div class="form-group mb-4"><label
                                                     >Course Module PDF</label><label
                                                    class="custom-file-container__custom-file"><input
                                                        type="file" class="form-control-file"></label></div>
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
                                        <div class="col col-md-10">
                                            <div class="form-group mb-4"><label
                                                    for="personName">Course Additional Information ( If have )</label>
                                                <textarea id="exampleFormControlTextarea1" class="form-control" rows="3"
                                                    spellcheck="false" name="course_additionals.0.course_additional_infos"></textarea>
                                            </div>
                                        </div>
                                        <div class="col col-md-12 text-right">
                                            <div class="row ml-4">
                                                <div  ><button
                                                        class="btn btn-warning btn-rounded mb-2 mr-2"><svg
                                                            xmlns="http://www.w3.org/2000/svg"
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
                                                        </svg></button></div>
                                                <div style="display: none;"><button
                                                        class="btn btn-danger btn-rounded mb-2 mr-2"><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-x-circle">
                                                            <circle cx="12" cy="12"
                                                                r="10"></circle>
                                                            <line x1="15" y1="9"
                                                                x2="9" y2="15"></line>
                                                            <line x1="9" y1="9"
                                                                x2="15" y2="15"></line>
                                                        </svg></button></div>
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
                                    <h4  >Upload Additional Multiple file</h4><br  >
                                </div>
                                <div class="col col-md-12">
                                    <div class="form-group mb-4">
                                        <div class="form-group mb-4"><label
                                                class="custom-file-container__custom-file"><input
                                                    type="file" class="form-control-file" multiple=""></label>
                                            <div class="custom-file-container__image-preview"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col mt-5"><button type="button"
                                                class="btn btn-warning btn-lg me-2"> Cancel </button><button
                                                type="submit" class="btn btn-primary btn-lg mr-2"
                                                > Submit </button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
