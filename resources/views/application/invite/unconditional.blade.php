<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Invite Unconditional Offer</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      font-size: 14px;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    h2 {
      color: #ff6600;
      margin-top: 0;
    }
    p {
      margin-bottom: 10px;
    }
    .button {
      display: inline-block;
      background-color: #ff6600;
      color: #ffffff;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
    }
    .logo {
      max-width: 150px;
      display: block;
      margin-bottom: 20px;
    }
    .icon {
      display: inline-block;
      vertical-align: middle;
      margin-right: 5px;
    }
	.spn-from {
		background-color: #1fe3a1;
		color: white;
		padding: 3px;
		border-radius: 7%;
	}
	.spn-to {
		background-color: #707fe9;
		color: white;
		padding: 3px;
		border-radius: 7%;
	}
    .applicant-info {
        font-family: 'Arial', sans-serif;
        line-height: 1.9;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .applicant-info strong {
        display: inline-block;
        width: 150px;
        font-weight: bold;
    }
    .p-accept {
        font-family: 'Montserrat', sans-serif;
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;
        color: #27ae60;
        border-bottom: 2px solid #27ae60;
        transition: color 0.3s ease-in-out;
    }

    .p-accept:hover {
        color: #218c53;
        border-bottom: 2px solid #218c53;
    }
    .p-decline{
        font-family: 'Montserrat', sans-serif;
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;
        color: #e4160f;
        border-bottom: 2px solid #e4160f;
        transition: color 0.3s ease-in-out;
        margin-left: 5px;
    }
    .p-decline:hover{
        color: #a53f3f;
        border-bottom: 2px solid #a53f3f;
    }
    .p-defer{
        font-family: 'Montserrat', sans-serif;
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;
        color: #d5d830;
        border-bottom: 2px solid #d5d830;
        transition: color 0.3s ease-in-out;
        margin-left: 5px;
    }
    .p-defer:hover{
        color: #9a9c19;
        border-bottom: 2px solid #9a9c19;
    }


    .form-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 400px;
        width: 100%;
    }

    .form-heading {
        font-size: 18px;
        margin-bottom: 10px;
        color: #333;
    }

    .form-textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        resize: vertical;
    }

    .form-button {
        background-color: #3498db;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .form-button:hover {
        background-color: #2980b9;
    }
  </style>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
  <div class="container">
    <h2>Unconditional Offer Invite Page</h2><br>
    <div class="applicant-info">
        <p>
            <strong>Application Id:</strong> {{ (!empty($application_data->id))?$application_data->id:'' }}<br>
            <strong>Name:</strong> {{ (!empty($application_data->name))?$application_data->name:'' }}<br>
            <strong>Email:</strong> {{ (!empty($application_data->email))?$application_data->email:'' }}<br>
            <strong>Phone:</strong> {{ (!empty($application_data->phone))?$application_data->phone:'' }}<br>
            <strong>Date Of Birth:</strong> {{ (!empty($application_data->date_of_birth))?$application_data->date_of_birth:'' }}<br>
            <strong>University:</strong> {{ (!empty($application_data->campus->campus_name))?$application_data->campus->campus_name:'' }}<br>
            <strong>Course:</strong> {{ (!empty($application_data->course->course_name))?$application_data->course->course_name:'' }}<br>
            <strong>Intake:</strong> {{ (!empty($application_data->intake))?date('F Y',strtotime($application_data->intake)):'' }}<br>
        </p>
    </div><br>
    <p>I wish to:</p>
    <p><strong><a href="javascript:void(0)" onclick="if(confirm('Are you sure to Accept this Unconditional Offer?')) location.href='{{ URL::to('offer-accepted/'.$getData->link) }}'; return false;" class="p-accept">Accept,</a> </strong><strong><a href="javascript://" onclick="showDecline()" class="p-decline">Decline</a> </strong>or <strong><a href="javascript://" onclick="showDefer()" class="p-defer">Defer</a></strong> </p><br>
    <div style="display: none;" id="decline-form" class="form-container">
        <form method="post" action="{{ URL::to('submit-decline-offer') }}">
            @csrf
            <p class="form-heading">Make a decline note then Submit</p>
            <input type="hidden" name="decline_link" value="{{ $getData->link }}" />
            <textarea name="decline_note" class="form-textarea" rows="4" placeholder="Enter your decline note here"></textarea>
            <button class="form-button" type="submit">Submit</button>
        </form>
    </div>
    <div style="display: none;" id="defer-form" class="form-container">
        <form method="post" action="{{ URL::to('submit-defer-offer') }}">
            @csrf
            <p class="form-heading">Make a defer note then Submit</p>
            <input type="hidden" name="defer_link" value="{{ $getData->link }}"/>
            <textarea name="defer_note" class="form-textarea" rows="4" placeholder="Enter your defer note here"></textarea>
            <button class="form-button" type="submit">Submit</button>
        </form>
    </div><br><br>
    <p>Please do not sign the offer if any of the above details are incorrect.</p>
    <p>Please send us email on <a href="mailto:admissions@ukmc.ac.uk">admissions@ukmc.ac.uk</a> or call us on 01614780015  to correct your details. Once the details are updated, you will be sent a new offer letter to sign.</p><br><br>
    <p>Thank you.</p>

    <p><b>Best regards,</b><br>
      Admissions Team<br>
      UK Management College<br>
      College House<br>
      Stanley Street<br>
      Openshaw<br>
      M11 1LE
    </p>
    <img src="https://ukmcglobal.com/wp-content/uploads/2020/07/ukmc-logo.webp" alt="UKMC Logo" class="logo">

    <p>
        Email: <a href="mailto:admissions@ukmcglobal.com">admissions@ukmcglobal.com</a><br>
        Tel: <a href="tel:+4401614780015">+4401614780015</a><br>
        Web: <a target="_blank" href="http://www.ukmcglobal.com">www.ukmcglobal.com</a>
    </p>

    <small><em>Please note: The information contained in this email is intended only for the person or entity to which it is addressed and may contain confidential and/or privileged material. If you are not the intended recipient, any use, disclosure, copying, or distribution of this information is strictly prohibited. If you have received this email in error, please notify the sender immediately and delete it from your computer. While we strive to keep our network free from computer viruses, we do not guarantee that this transmission is virus-free and will not be liable for any damages resulting from any transmitted viruses.</em></small>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
     <script>
        function showDecline(){
            $('#decline-form').show();
            $('#defer-form').hide();
        }
        function showDefer(){
            $('#decline-form').hide();
            $('#defer-form').show();
        }
     </script>
</body>
</html>
