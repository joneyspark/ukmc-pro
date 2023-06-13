@extends('adminpanel')
@section('admin')
    <div class="container">
        <div class="row secondary-nav">
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
                                    <li class="breadcrumb-item active" aria-current="page">Pending Applications</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="row">
                <div class="col col-md-6 mb-4">
                    <h5 class="pb-2">Personal Information</h5>
                    <div class="table-responsive">
                        <table class="table-bordered mb-4 table">
                            <tbody>
                                <tr>
                                    <td colspan="2"><img
                                            src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD//gA+Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcgSlBFRyB2NjIpLCBkZWZhdWx0IHF1YWxpdHkK/9sAQwAIBgYHBgUIBwcHCQkICgwUDQwLCwwZEhMPFB0aHx4dGhwcICQuJyAiLCMcHCg3KSwwMTQ0NB8nOT04MjwuMzQy/9sAQwEJCQkMCwwYDQ0YMiEcITIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIy/8AAEQgAWgBaAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A4Ciiiu0zCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiuq8NaJDqlnCBY/a3nuzbzyh2Bs48Ltk4IHJZvvZHyY6mhuwzlaK6TXdMsba2vVtbcwyadfLZO+8t5+Vf5jk4BzGemBhhxVKXRI4vD0esfbVaOQiJI9nzGXJ3KeeAFwd3fcox1wrgZFFdra+GLe/tbWNLMxwOlqw1ESH97JK8aPHgnb8pkPQZGznrWFq8Nm+n2moWdr9lWWaaBod7N9zYQ3zEnJEgz2yOMUKVwMeiiimIKKKKACiiigArRsdYksLfy47a2eRXMkU7ofMhYjGVII9B1BAIyMGs6igZp6jrlzqdusMsUEeXEkrxqQ0zgYDvknnGemByeOaJNcuZdJGltHCLRVUKgU/KykneOfvHcwJ9DjHAxmUUWQGp/b1ylvElvBbW8qCMNcRIQ8gQgru5xwQDwBkgZzUWp6tLqZiDQQW8Ue4rFApC7mOWbkk5OB3xwMAVQoosAUUUUCCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD/2Q=="
                                            class="" alt="..." width="90"></td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td>Pinaki chakraborty</td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>+918100222351</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>babaitheprince@gmail.com</td>
                                </tr>
                                <tr>
                                    <td>Alternate Phone</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Date of Birth</td>
                                    <td>1983-10-15</td>
                                </tr>
                                <tr>
                                    <td>Living Country</td>
                                    <td>India</td>
                                </tr>
                                <tr>
                                    <td>Living City</td>
                                    <td>KOLKATA</td>
                                </tr>
                                <tr>
                                    <td>Living State</td>
                                    <td>WEST BENGAL</td>
                                </tr>
                                <tr>
                                    <td>Zip Code</td>
                                    <td>700010</td>
                                </tr>
                                <tr>
                                    <td>Living Address Details</td>
                                    <td>61/A/12 DR. Suresh Chandra Baneerjee Rd Kol: 10</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="card no-outer-spacing no-border-custom" theme-mode-data="false">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="" data-toggle=""
                                        data-target="#withoutSpacingAccordionFive" aria-expanded=""
                                        aria-controls="withoutSpacingAccordionFive"> Lead Notes <div class="icons"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-chevron-down">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg></div>
                                    </div>
                                </section>
                            </div>
                            <div id="" class="" aria-labelledby="headingTwo2" data-parent="#withoutSpacing">
                                <div class="card-body custom-card-body">
                                    <form>
                                        <div class="col col-md-12 p-0">
                                            <div class="form-group lead-drawer-form">
                                                <textarea name="add_notes" cols="30" rows="3" placeholder="Type Lead Notes here..." class="form-control"></textarea>
                                                <!---->
                                            </div><button class="btn badge badge-info btn-sm">Save
                                                <!---->
                                            </button>
                                        </div>
                                        <hr>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card no-outer-spacing">
                        <div id="headingThree3" class="card-header">
                            <section class="mb-0 mt-0">
                                <h5>Meeting</h5>
                            </section>
                        </div>
                        <div>
                            <div class="card-body custom-card-body p-0">
                                <div class="col-col-md-12"><button class="btn btn-secondary meeting-button"> Make a
                                        Meeting <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-calendar">
                                            <rect x="3" y="4" width="18" height="18"
                                                rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg></button></div><br>
                                <!---->
                                <div class="col col-md-12 p-0">
                                    <div id="tableSimple" class="col-lg-12 col-12 p-0"><label
                                            style="font-size: 12px;">Meeting schedule</label>
                                        <div class="table-responsive meeting-table">
                                            <table id="manage_app_process" class="table-bordered mb-4 table">
                                                <thead>
                                                    <tr>
                                                        <th>Date Time</th>
                                                        <th>Done</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div data-v-b64104d7="" id="confirmationModal" class="modal confirmation-custom fade"
                                    tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
                                    aria-hidden="true">
                                    <div data-v-b64104d7="" class="modal-dialog" role="document">
                                        <div data-v-b64104d7="" class="modal-content">
                                            <div data-v-b64104d7="" class="modal-header">
                                                <h5 data-v-b64104d7="" id="confirmationModalLabel" class="modal-title">
                                                    Confirmation</h5><button data-v-b64104d7="" type="button"
                                                    class="close" data-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div data-v-b64104d7="" class="modal-body"><strong data-v-b64104d7=""
                                                    class="modal-text">Have you Complete The Meeting ?</strong></div>
                                            <div data-v-b64104d7="" class="modal-footer d-flex justify-content-center">
                                                <button data-v-b64104d7="" class="btn btn-sm" data-dismiss="modal"><i
                                                        data-v-b64104d7="" class="flaticon-cancel-12"></i> No
                                                </button><button data-v-b64104d7="" type="button"
                                                    class="btn btn-warning btn-sm">Yes</button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-md-6 mb-4">
                    <h5 class="pb-2">Useful Information</h5>
                    <div class="table-responsive">
                        <table class="table-bordered mb-4 table">
                            <tbody>
                                <tr>
                                    <td>Branch</td>
                                    <td>Kolkata Office - India</td>
                                </tr>
                                <tr>
                                    <td>Course Category</td>
                                    <td>Science</td>
                                </tr>
                                <tr>
                                    <td>Course Level</td>
                                    <td>Postgraduate</td>
                                </tr>
                                <tr>
                                    <td>Counselor</td>
                                    <td>Ratna Saha Nandi</td>
                                </tr>
                                <tr>
                                    <td>Lead Source</td>
                                    <td>
                                        <div>Hubspot</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Interested Country</td>
                                    <td>United Kingdom</td>
                                </tr>
                                <tr>
                                    <td>Intake Year</td>
                                    <td>September, 2023</td>
                                </tr>
                            </tbody>
                        </table>
                    </div><br>
                    <div class="col col-md-12">
                        <div>
                            <h5 class="pb-2">Q: Do You Have Ielts Tofel Or Pte</h5>
                            <p>Yes</p><br>
                        </div>
                        <div>
                            <h5 class="pb-2">Q: Intrested Level Of Study</h5>
                            <p>Bachelor's Degree</p><br>
                        </div>
                        <div>
                            <h5 class="pb-2">Q: Your Study Gap</h5>
                            <p>More Than 10 Years</p><br>
                        </div>
                        <div>
                            <h5 class="pb-2">Q: Your City </h5>
                            <p>Kolkata</p><br>
                        </div>
                        <div>
                            <h5 class="pb-2">Q: Preferred Time To Call You</h5>
                            <p>Morning</p><br>
                        </div>
                    </div>
                    <div class="col col-md-12"></div>
                    <h5 class="pb-2">University Information</h5>
                    <div class="table-responsive">
                        <table class="table-bordered mb-4 table">
                            <thead>
                                <tr>
                                    <th>Institute Name</th>
                                    <th>Course Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Bangor University</td>
                                    <td>BSc (Hons) Pharmacology</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card no-outer-spacing no-border-custom">
                        <div class="card-header">
                            <section class="mb-0 mt-0">
                                <h5>Follow up</h5>
                            </section>
                        </div>
                        <div class="application-follow-up-wrap">
                            <div class="card-body custom-card-body p-0">
                                <form>
                                    <div class="col col-md-12 p-0">
                                        <div class="form-group lead-drawer-form"><label>Follow up Date</label>

                                        </div>
                                        <div class="form-group lead-drawer-form">
                                            <textarea name="follow_up" cols="30" rows="3" placeholder="Follow up notes..." class="form-control"></textarea>
                                            <!---->
                                        </div><button class="btn badge badge-info btn-sm">Save
                                            <!---->
                                        </button>
                                    </div>
                                    <hr>
                                    <div class="col col-md-12 p-0">
                                        <ul class="list-group list-group-media drawer-follow-up-list"></ul>
                                    </div>
                                </form><br>
                                <div class="row">
                                    <div class="col col-md-12">
                                        <div class="lms-pagination">
                                            <div data-v-1ef4d76c="" class="flex justify-center custom-pagination">
                                                <ul data-v-1ef4d76c="" class="link-list">
                                                    <li data-v-1ef4d76c=""
                                                        class="flex border-r border-gray-200 last:border-r-0 dark:border-slate-500">
                                                        <a data-v-1ef4d76c="" aria-current="page"
                                                            href="/application-lead-info/bhe-140581#"
                                                            class="router-link-active router-link-exact-active link link-disabled">«
                                                            Previous</a></li>
                                                    <li data-v-1ef4d76c=""
                                                        class="flex border-r border-gray-200 last:border-r-0 dark:border-slate-500">
                                                        <a data-v-1ef4d76c="" aria-current="page"
                                                            href="/application-lead-info/bhe-140581?page=1"
                                                            class="router-link-active router-link-exact-active link hover:bg-gray-200 dark:hover:bg-blue-500 dark:hover:text-white link-active">1</a>
                                                    </li>
                                                    <li data-v-1ef4d76c=""
                                                        class="flex border-r border-gray-200 last:border-r-0 dark:border-slate-500">
                                                        <a data-v-1ef4d76c="" aria-current="page"
                                                            href="/application-lead-info/bhe-140581#"
                                                            class="router-link-active router-link-exact-active link link-disabled">Next
                                                            »</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-v-787d8446="" id="followupConfirmationModal" class="modal confirmation-custom fade"
                            tabindex="-1" role="dialog" aria-labelledby="followupConfirmationModalLabel"
                            aria-hidden="true">
                            <div data-v-787d8446="" class="modal-dialog" role="document">
                                <div data-v-787d8446="" class="modal-content">
                                    <div data-v-787d8446="" class="modal-header">
                                        <h5 data-v-787d8446="" id="followupConfirmationModalLabel" class="modal-title">
                                            Confirmation</h5><button data-v-787d8446="" type="button" class="close"
                                            data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div data-v-787d8446="" class="modal-body"><strong data-v-787d8446=""
                                            class="modal-text">Have you Complete The Follow up ?</strong></div>
                                    <div data-v-787d8446="" class="modal-footer d-flex justify-content-center"><button
                                            data-v-787d8446="" class="btn btn-sm" data-dismiss="modal"><i
                                                data-v-787d8446="" class="flaticon-cancel-12"></i> No </button><button
                                            data-v-787d8446="" type="button" class="btn btn-warning btn-sm">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-md-12 mb-4">
                    <h5 class="pb-2">Application Document</h5>
                    <p>No File Uploaded Yet</p>
                    <ul class="documents-files"></ul>
                </div>
            </div>
        </div>


    </div>
@stop
