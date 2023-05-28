@extends('adminpanel')
@section('admin')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="tab-content" id="animateLineContent-4">
                <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel"
                    aria-labelledby="animated-underline-home-tab">
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="Analytics">
                            <header class="header navbar navbar-expand-sm">
                                <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
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
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form class="section general-info">
                                <div class="info">
                                    <h5 class="py-3 text-center">Profile Information</h5>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="fullName">Profile photo</label>
                                                <input class="form-control" type="file"
                                                    class="filepond" name="filepond"
                                                    accept="image/png, image/jpeg, image/gif" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="fullName">Full Name</label>
                                                <input type="text" class="form-control mb-3"
                                                    id="fullName" placeholder="Full Name"
                                                    value="Jimmy Turner">
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <label for="profession">Profession</label>
                                                <input type="text" class="form-control mb-3"
                                                    id="profession" placeholder="Designer"
                                                    value="Web Developer">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <select class="form-select mb-3" id="country">
                                                    <option>All Countries</option>
                                                    <option selected>United States</option>
                                                    <option>India</option>
                                                    <option>Japan</option>
                                                    <option>China</option>
                                                    <option>Brazil</option>
                                                    <option>Norway</option>
                                                    <option>Canada</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control mb-3"
                                                    id="address" placeholder="Address"
                                                    value="New York">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="location">Location</label>
                                                <input type="text" class="form-control mb-3"
                                                    id="location" placeholder="Location">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control mb-3"
                                                    id="phone"
                                                    placeholder="Write your phone number here"
                                                    value="+1 (530) 555-12121">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control mb-3"
                                                    id="email"
                                                    placeholder="Write your email here"
                                                    value="Jimmy@gmail.com">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="website1">Website</label>
                                                <input type="text" class="form-control mb-3"
                                                    id="website1" placeholder="Enter URL">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-1">
                                        <div class="form-group text-start">
                                            <button class="btn btn-secondary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@stop
