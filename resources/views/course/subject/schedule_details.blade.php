<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Class Schedule Details</title>
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
  </style>
</head>
<body>
  <div class="container">
    <h2>Class Schedule Details</h2>
    <div class="col-md-12">
        {!! QrCode::size(120)->style('round')->backgroundColor(251,255,255)->generate('RemoteStack') !!}
    </div>
	<p>
		<strong>Course Name:</strong>  {{ (!empty($details->course->course_name))?$details->course->course_name:'' }} <br><br>
    <strong>Subject:</strong>  {{ (!empty($details->subject->title))?$details->subject->title:'' }}<br><br>
    <strong>Intake:</strong> {{ (!empty($details->intake_date))?date('F Y',strtotime($details->intake_date)):'' }}<br><br>
    <strong>Schedule Title:</strong> {{ (!empty($details->title))?$details->title:'' }}<br><br>
    <strong>Class Schedule Date:</strong> {{ (!empty($details->schedule_date))?date('F d Y',strtotime($details->schedule_date)):'' }}<br><br>
    <strong>Class Schedule Time:</strong> {{ (!empty($details->time_from))?$details->time_from:'' }} - {{ (!empty($details->time_to))?$details->time_to:'' }}
	</p>
	<p>Note: Please scan the QR code using your mobile device, then proceed to submit your ID to officially record your attendance.</p>

    <p>Thank you.</p>

    <p><b>Best regards,</b><br>
      Admissions Team<br>
      UK Management College<br>
      College House<br>
      Stanley Street<br>
      Openshaw<br>
      M11 1LE
    </p>
    <img src="https://ukmc.ac.uk/img/home/logo_ukmc.png" alt="UKMC Logo" class="logo">
    <p>
        Email: <a href="mailto:admissions@ukmcglobal.com">admissions@ukmcglobal.com</a><br>
        Tel:&nbsp;&nbsp;&nbsp; <a href="tel:+4401614780015">+4401614780015</a><br>
        Web:&nbsp; <a target="_blank" href="http://www.ukmcglobal.com">www.ukmcglobal.com</a>
    </p>
  </div>
</body>
</html>



