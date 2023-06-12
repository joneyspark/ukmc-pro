<!DOCTYPE html>
<html lang="en">
<head>
    @php
    if(Auth::check()){
        if(Auth::user()->role=='admin' || Auth::user()->role=='adminManager' || Auth::user()->role=='teacher'){
            $setting = App\Models\Setting\CompanySetting::where('id',1)->first();
        }elseif(Auth::user()->role=='agent'){
            $setting = App\Models\Setting\CompanySetting::where('company_id',Auth::user()->company_id)->first();
        }else{

        }

    }
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ (!empty($page_title))?$page_title:'' }}</title>
    @if(!empty($setting->favicon))
    <link rel="icon" type="image/x-icon" href="{{ asset($setting->favicon) }}" />
    @else
    <link rel="icon" type="image/x-icon" href="{{ asset('backend/src/assets/img/favicon.ico') }}" />
    @endif

    <link href="{{ asset('backend/layouts/vertical-dark-menu/css/light/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/layouts/vertical-dark-menu/css/dark/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('backend/layouts/vertical-dark-menu/loader.js') }}"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('backend/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/layouts/vertical-dark-menu/css/light/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/layouts/vertical-dark-menu/css/dark/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/plugins/src/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/light/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/light/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend/src/assets/css/light/components/modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/components/modal.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/src/stepper/bsStepper.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/assets/css/light/scrollspyNav.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/css/light/stepper/custom-bsStepper.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/assets/css/dark/scrollspyNav.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/css/dark/stepper/custom-bsStepper.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/assets/css/light/forms/switches.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css" integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/custom.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/src/tagify/tagify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/css/light/tagify/custom-tagify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/plugins/css/dark/tagify/custom-tagify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/assets/css/dark/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/assets/css/dark/editors/markdown/simplemde.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/src/assets/css/light/editors/markdown/simplemde.min.css') }}">
</head>

<body class="layout-boxed">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <div class="header-container container-xxl">
        <header class="header navbar navbar-expand-sm expand-header">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo mt-1">
                    @if(!empty($setting->company_logo))
                    <a href="{{ URL::to('/') }}">
                        <img src="{{ asset($setting->company_logo) }}" class="" alt="logo">
                    </a>
                    @else
                    <a href="#">
                        <img src="{{ asset('backend/src/assets/img/logo.svg') }}" class="" alt="logo">
                    </a>
                    @endif

                </li>
                <li class="nav-item theme-text">
                    <a href="#" class="nav-link"> {{ (!empty($setting->company_name))?$setting->company_name:'AMS' }} </a>
                </li>
            </ul>
            <ul class="navbar-item flex-row ms-lg-auto ms-0 action-area">
                <li class="nav-item theme-toggle-item">
                    <a href="javascript:void(0);" class="nav-link theme-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon dark-mode"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun light-mode"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                    </a>
                </li>

                <li class="nav-item dropdown notification-dropdown">
                    @php
                        $notify_count = App\Models\Notification\Notification::where('is_view',0)->where('user_id',Auth::user()->id)->count();
                    @endphp
                    <a onclick="show_notifications()" href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <span id="notification-badge" class="custom-badge badge badge-success">{{ $notify_count }}</span>
                    </a>


                    <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                        <div class="drodpown-title message">
                            <a href="{{ URL::to('my-notification-list') }}"><h6 class="d-flex justify-content-between"><span class="align-self-center">Notifications</span> <span class="badge badge-primary">Show All</span></h6></a>
                        </div>
                        <div id="notification-item" class="notification-scroll">
                            <div class="dropdown-item">
                                <div class="media server-log">
                                    <img src="{{ asset('backend/src/assets/img/profile-16.jpeg') }}" class="img-fluid me-2" alt="avatar">
                                    <div class="media-body">
                                        <div class="data-info">
                                            <h6 class="">Farjana Khan</h6>
                                            <p><small class="">Updated application status<span class="text-danger"> hot</span> to <span class="text-success">potential</span> lead.</small></p>
                                            <p class="">1 hr ago</p>
                                        </div>
                                        <div class="icon-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </li>

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-container">
                            <div class="avatar avatar-sm avatar-indicators avatar-online">
                                @if(Auth::check() && !empty(Auth::user()->photo))
                                <img alt="avatar" src="{{ asset(Auth::user()->photo) }}" class="rounded-circle">
                                @else
                                <img alt="avatar" src="{{ asset('web/avatar/user.png') }}" class="rounded-circle">
                                @endif

                            </div>
                        </div>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <div class="emoji me-2">
                                    &#x1F44B;
                                </div>
                                @if(Auth::check())
                                <div class="media-body">
                                    <h5>{{ Auth::user()->name }}</h5>
                                    <p>
                                        @if(Auth::user()->role=='admin')
                                            <span>Super Admin</span>
                                        @elseif(Auth::user()->role=='adminManager')
                                            <span>Admission Manager</span>
                                        @elseif(Auth::user()->role=='teacher')
                                            <span>Teacher</span>
                                        @elseif(Auth::user()->role=='agent')
                                            <span>Agent</span>
                                        @else
                                            <span>Other</span>
                                        @endif
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="{{ URL::to('profile-settings') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>                                <span>Profile</span>
                            </a>
                        </div>
                        @if(Auth::check())
                        <div class="dropdown-item">
                            <a href="{{ URL::to('sign-out') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                <span>Log Out</span>
                            </a>
                        </div>
                        @endif
                    </div>

                </li>
            </ul>
        </header>
    </div>
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>
        <div class="sidebar-wrapper sidebar-theme">
            @include('sidebar/menulist')
        </div>
        <div id="content" class="main-content">
            @yield('admin')
            <!--  BEGIN FOOTER  -->
            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © <span class="dynamic-year">2022</span> <a target="_blank" href="https://designreset.com/cork-admin/">DesignReset</a>, All rights reserved.</p>
                </div>
            </div>
            <!--  END FOOTER  -->
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('web/js/jquery.js') }}"></script>
    <script src="{{ asset('backend/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/src/waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/layouts/vertical-dark-menu/app.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/src/highlight/highlight.pack.js') }}"></script>
    <script src="{{ asset('backend/src/assets/js/scrollspyNav.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/src/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backend/src/assets/js/dashboard/dash_1.js') }}"></script>
    <script src="{{ asset('backend/src/assets/js/dashboard/dash_2.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/tagify/tagify.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/src/tagify/custom-tagify.js') }}"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

     <!-- BEGIN PAGE LEVEL SCRIPTS -->
     <script src="{{ asset('backend/src/plugins/src/stepper/bsStepper.min.js') }}"></script>
     <script src="{{ asset('backend/src/plugins/src/stepper/custom-bsStepper.min.js') }}"></script>
     <script src="{{ asset('backend/src/editors/markdown/simplemde.min.js') }}"></script>
     <script src="{{ asset('backend/src/editors/markdown/custom-markdown.js') }}"></script>
     <!-- END PAGE LEVEL SCRIPTS -->
     <script src="{{ asset('web/js/iziToast.js') }}"></script>
     <link rel="stylesheet" type="text/css" href="{{ asset('web/css/toastr.css') }}">
	 <script src="{{ asset('web/js/toastr.js') }}"></script>
     @include('ajax.toastr')
	  <script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		</script>

        <script src="{{ asset('web/js/pusher.js') }}"></script>
        @if(Auth::user()->role=='admin' || Auth::user()->role=='adminManager')
        <script>
            Pusher.logToConsole = true;
            var pusher = new Pusher('ef4fd77f0ef3365b974c', {
            cluster: 'ap2'
            });
            var channel = pusher.subscribe('CreateLead');
            channel.bind('notice', function(data) {
                //alert(JSON.stringify(data));
                iziToast.show({
                    title: 'Hey',
                    message: data.message+' <a style="color:blue;" href="'+data.url+'">View Task</a>',
                    position: 'bottomRight',
                    timeout: 8000,
                    color: 'green',
                    balloon: true,
                    close: true,
                    progressBarColor: 'yellow',
                });
                this.get_notifications();
            });
        </script>
        @endif
        <!--task event create -->
        @include('ajax.taskUser')
        <script>
            function get_notifications(){
                $.get('{{ URL::to('get-notification-count') }}',function(data,status){
                    if(data['result']['key']===200){
                        console.log(data['result']['val']);
                        $('#notification-badge').html(data['result']['val']);
                    }
                });
            }
            function show_notifications(){
                $.get('{{ URL::to('get-my-notification') }}',function(data,status){
                    if(data['result']['key']===200){
                        console.log(data['result']['val']);
                        $('#notification-item').html(data['result']['val']);
                        $('#notification-badge').html(0);
                    }
                });
            }
            //get course data
            function getCourseData(){
                var campus_id = $('#campus_id').val();
                var course_name = $('#course_name').val();
                if(campus_id !== null){
                    window.location = "{{ URL::to('all-course?campus_id=') }}" + campus_id + "&course_name=" + course_name;
                }
            }
        </script>
        
        <script src="{{ asset('web/js/custom.js') }}"></script>
        <script src="{{ asset('web/js/addRemove.js') }}"></script>
        <script src="{{ asset('web/js/tagify.js') }}"></script>
        @include('ajax.university')
        <script src="{{ asset('web/js/iziToast.js') }}"></script>

</body>

</html>
