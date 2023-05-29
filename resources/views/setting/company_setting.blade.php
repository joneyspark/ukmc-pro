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
                                        <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Company Settings</li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <form method="post" action="{{ URL::to('company-setting-post') }}" enctype="multipart/form-data">
                @csrf
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-4">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h5>Company Information</h5>
                                    </div><br>
                                </div>
                                <div class="col col-md-6">
                                    <div class="form-group mb-2"><label for="personName">Company Name</label>
                                        <input id="personName" type="text" class="form-control" value="{{ (!empty($company_data->company_name))?$company_data->company_name:'' }}" name="company_name">
                                    </div>
                                </div>
                                <div class="col col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="personName">Company Country</label>
                                        <select name="country" class="form-control">
                                            <option value="">--Select Company Country--</option>
                                            @foreach ($countries as $country)
                                                <option {{ (!empty($company_data->country) && $company_data->country==$country)?'selected':'' }} value="{{ $country }}">{{ $country }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col col-md-7">
                                    <div class="form-group mb-2"><label for="exampleFormControlInput1">Address</label>
                                        <textarea name="address" id="exampleFormControlTextarea1" class="form-control" rows="3" spellcheck="false" name="institute_important_notes">{{ (!empty($company_data->address))?$company_data->address:'' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col col-md-4">
                                    <div class="form-group mb-2"><label for="personName">State</label>
                                        <input id="state" type="text" class="form-control" value="{{ (!empty($company_data->state))?$company_data->state:'' }}" name="state">
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div class="form-group mb-2"><label for="personName">City</label>
                                        <input id="city" type="text" class="form-control" value="{{ (!empty($company_data->city))?$company_data->city:'' }}" name="city">
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div class="form-group mb-2"><label for="personName">Zip Code<Code></Code></label>
                                        <input id="zip_code" type="text" class="form-control" value="{{ (!empty($company_data->zip_code))?$company_data->zip_code:'' }}" name="zip_code">
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="row d-flex align-items-center">
                                        <div class="col col-md-4">
                                            <div class="form-group mb-2">
                                                <label>Company Logo</label>
                                                    <input type="file"
                                                        class="form-control-file" accept="image/*"
                                                        name="company_logo">
                                                @if(!empty($company_data->company_logo))
                                                    <img width="34" height="34" src="{{ asset($company_data->company_logo) }}" class="custom-file-container__image-preview"/>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col col-md-4">
                                            <div class="form-group mb-2">
                                                <label>Favicon Icon</label>
                                                    <input type="file"
                                                        class="form-control-file" accept="image/*"
                                                        name="favicon">
                                                @if(!empty($company_data->favicon))
                                                    <img width="34" height="34" src="{{ asset($company_data->favicon) }}" class="custom-file-container__image-preview"/>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col col-md-4">
                                            <div class="form-group mb-2">
                                                <label>Company Banner(for email)</label>
                                                <input type="file"
                                                    class="form-control-file" accept="image/*"
                                                    name="company_banner">
                                            @if(!empty($company_data->company_banner))
                                                <img width="250" height="80" src="{{ asset($company_data->company_banner) }}" class="custom-file-container__image-preview"/>
                                            @endif
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col col-md-4">
                                    <div class="form-group mb-2"><label for="personName">Email</label>
                                        <input id="email" type="text" class="form-control" value="{{ (!empty($company_data->email))?$company_data->email:'' }}" name="email">
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div class="form-group mb-2"><label for="personName">Phone</label>
                                        <input id="phone" type="text" class="form-control" value="{{ (!empty($company_data->phone))?$company_data->phone:'' }}" name="phone">
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div class="form-group mb-2"><label for="personName">Website<Code></Code></label>
                                        <input id="website" type="text" class="form-control" value="{{ (!empty($company_data->website))?$company_data->website:'' }}" name="website">
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-4">
                                <div class="col col-md-6">
                                    <div class="form-group mb-2"><label for="personName">CRM Website</label>
                                        <input id="crm_website" type="text" class="form-control" value="{{ (!empty($company_data->crm_website))?$company_data->crm_website:'' }}" name="crm_website">
                                    </div>
                                </div>
                                <div class="col col-md-6">
                                    <div class="form-group mb-2"><label for="personName">Contact Us</label>
                                        <input id="contact_us" type="text" class="form-control" value="{{ (!empty($company_data->contact_us))?$company_data->contact_us:'' }}" name="contact_us">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col col-md-6">
                                    <div class="form-group mb-2"><label for="personName">Privacy Policy Link</label>
                                        <input id="privacy_policy" type="text" class="form-control" value="{{ (!empty($company_data->privacy_policy))?$company_data->privacy_policy:'' }}" name="privacy_policy">
                                    </div>
                                </div>
                                <div class="col col-md-6">
                                    <div class="form-group mb-2"><label for="personName">Terms And Condition Link</label>
                                        <input id="terms_and_condition" type="text" class="form-control" value="{{ (!empty($company_data->terms_and_condition))?$company_data->terms_and_condition:'' }}" name="terms_and_condition">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col col-md-3">
                                    <div class="form-group mb-2"><label for="personName">Facebook</label>
                                        <input id="facebook" type="text" class="form-control" value="{{ (!empty($company_data->facebook))?$company_data->facebook:'' }}" name="facebook">
                                    </div>
                                </div>
                                <div class="col col-md-3">
                                    <div class="form-group mb-2"><label for="personName">Instagram</label>
                                        <input id="instagram" type="text" class="form-control" value="{{ (!empty($company_data->instagram))?$company_data->instagram:'' }}" name="instagram">
                                    </div>
                                </div>
                                <div class="col col-md-3">
                                    <div class="form-group mb-2"><label for="personName">Linkedin</label>
                                        <input id="linkedin" type="text" class="form-control" value="{{ (!empty($company_data->linkedin))?$company_data->linkedin:'' }}" name="linkedin">
                                    </div>
                                </div>
                                <div class="col col-md-3">
                                    <div class="form-group mb-2"><label for="personName">Twitter</label>
                                        <input id="twitter" type="text" class="form-control" value="{{ (!empty($company_data->twitter))?$company_data->twitter:'' }}" name="twitter">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col col-md-4">
                                    <div class="form-group mb-2"><label for="personName">Pinterest</label>
                                        <input id="pinterest" type="text" class="form-control" value="{{ (!empty($company_data->pinterest))?$company_data->pinterest:'' }}" name="pinterest">
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div class="form-group mb-2"><label for="personName">Youtube</label>
                                        <input id="youtube" type="text" class="form-control" value="{{ (!empty($company_data->youtube))?$company_data->youtube:'' }}" name="youtube">
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div class="form-group mb-2"><label for="personName">Whatsapp</label>
                                        <input id="whatsapp" type="text" class="form-control" value="{{ (!empty($company_data->whatsapp))?$company_data->whatsapp:'' }}" name="whatsapp">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="card_1" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row mb-4 mb-2">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Contact Person</h4><br>
                                </div>
                                <div class="col col-md-12">
                                    <div class="row mb-4">
                                        <div class="col col-md-3">
                                            <div class="form-group mb-2"><label for="personName">Contact Person
                                                    Name</label><input id="contact_person_name" type="text"
                                                    class="form-control" value="{{ (!empty($company_data->contact_person_name))?$company_data->contact_person_name:'' }}" name="contact_person_name">
                                            </div>
                                        </div>
                                        <div class="col col-md-3">
                                            <div class="form-group mb-2"><label for="email">Email</label><input
                                                    type="email" class="form-control" value="{{ (!empty($company_data->contact_person_email))?$company_data->contact_person_email:'' }}" name="contact_person_email">
                                            </div>
                                        </div>
                                        <div class="col col-md-3">
                                            <div class="form-group mb-2"><label for="phone">Phone</label><input
                                                    type="text" value="{{ (!empty($company_data->contact_person_phone))?$company_data->contact_person_phone:'' }}" class="form-control" name="contact_person_phone">
                                            </div>
                                        </div>
                                        <div class="col col-md-3">
                                            <div class="form-group mb-2"><label for="alternate_phone">Alternate
                                                    Phone</label><input type="text" name="contact_person_alternative" value="{{ (!empty($company_data->contact_person_alternative))?$company_data->contact_person_alternative:'' }}" class="form-control"
                                                    name="contacts.0.alternate_phone">
                                                <ul>
                                                    <!---->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4 mt-5">
                                        <div class="col"><button type="button" class="btn btn-warning btn-lg me-2">
                                                Cancel </button><button type="submit" class="btn btn-primary btn-lg mr-2"
                                                > Submit </button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
