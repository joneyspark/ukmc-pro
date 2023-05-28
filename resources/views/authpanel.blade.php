<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ (!empty($page_title))?$page_title:'' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('backend/src/assets/img/favicon.ico') }}"/>
    <link href="{{ asset('backend/layouts/vertical-dark-menu/css/light/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/layouts/vertical-dark-menu/css/dark/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('backend/layouts/vertical-dark-menu/loader.js') }}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('backend/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend/layouts/vertical-dark-menu/css/light/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/light/authentication/auth-boxed.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend/layouts/vertical-dark-menu/css/dark/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/src/assets/css/dark/authentication/auth-boxed.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

</head>
<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">
            @yield('auth')
        </div>

    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('backend/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- END PAGE LEVEL SCRIPTS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
       @if(Session::has('success'))
       toastr.options =
       {
           "closeButton" : true,
           "progressBar" : true,
           "timeOut": "10000",
           "extendedTimeOut": "1000",
           "showEasing": "swing",
           "hideEasing": "linear",
       }
               toastr.success("{{ session('success') }}");
       @endif

       @if(Session::has('error'))
       toastr.options =
       {
           "closeButton" : true,
           "progressBar" : true,
           "timeOut": "10000",
           "positionClass": "toast-top-right",
           "extendedTimeOut": "1000",
           "showEasing": "swing",
           "hideEasing": "linear",
       }
               toastr.error("{{ session('error') }}");
       @endif

       @if(Session::has('info'))
       toastr.options =
       {
           "closeButton" : true,
           "progressBar" : true,
           "timeOut": "10000",
           "extendedTimeOut": "1000",
           "showEasing": "swing",
           "hideEasing": "linear",
       }
               toastr.info("{{ session('info') }}");
       @endif

       @if(Session::has('warning'))
       toastr.options =
       {
           "closeButton" : true,
           "progressBar" : true,
           "timeOut": "10000",
           "extendedTimeOut": "1000",
           "showEasing": "swing",
           "hideEasing": "linear",
       }
               toastr.warning("{{ session('warning') }}");
       @endif
     </script>
     <script type="text/javascript">
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
     </script>
</body>
</html>
