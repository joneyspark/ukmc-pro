<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Conditional Offer</title>
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
  </style>
</head>
<body>
  <div class="container">
    <h2>Application Status Updated</h2><br>
    <p>Dear {{ (!empty($details['application_data']->name))?$details['application_data']->name:'' }},</p><br><br>
    <p>We are delighted to inform that you have been issued a <span class="spn-from">Conditional offer</span> letter to study at UK Management College in partnership with CCCU.</p>

    <p>
      <strong>Application Id:</strong> {{ (!empty($details['application_data']->id))?$details['application_data']->id:'' }}<br>
	    <strong>Course Title:</strong> {{ (!empty($details['application_data']->course->course_name))?$details['application_data']->course->course_name:'' }}<br>
	    <strong>University Campus:</strong> {{ (!empty($details['application_data']->campus->campus_name))?$details['application_data']->campus->campus_name:'' }}<br>
      <strong>Intake:</strong> {{ (!empty($details['application_data']->intake))?date('F Y',strtotime($details['application_data']->intake)):'' }}
    </p><br><br>
    <p>To be able to get an unconditional offer, you will have to meet following conditions:</p>
    <span>
        <strong>{{ (!empty($details['offer_letter_text']))?$details['offer_letter_text']:'' }}</strong>
    </span><br><br>
    <p>Please note that you must provide all pending documents within 7 working days to secure your place for the intake. Failure to meet the deadline can result in your application being rejected or deferred for the next intake.</p>
    <p>Once we have received all the required documents and they have been verified, we will send you unconditional offer .</p>
    <p>Once you have accepted unconditional offer, you will receive further instructions on how to complete your registration and enrolment.</p><br><br><br>

    <p>If you have any queries and would like to discuss with us, please email us </p>
    <p>at <a href="mailto:admissions@ukmc.ac.uk">admissions@ukmc.ac.uk</a> or call us on 01614780015</p>


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
        Email: <a href="mailto:{{ (!empty($details['company']->email))?$details['company']->email:'' }}">{{ (!empty($details['company']->email))?$details['company']->email:'' }}</a><br>
        Tel: <a href="tel:{{ (!empty($details['company']->phone))?$details['company']->phone:'' }}">{{ (!empty($details['company']->phone))?$details['company']->phone:'' }}</a><br>
        Web: <a target="_blank" href="http://www.ukmcglobal.com">www.ukmcglobal.com</a>
    </p>

    <small><em>Please note: The information contained in this email is intended only for the person or entity to which it is addressed and may contain confidential and/or privileged material. If you are not the intended recipient, any use, disclosure, copying, or distribution of this information is strictly prohibited. If you have received this email in error, please notify the sender immediately and delete it from your computer. While we strive to keep our network free from computer viruses, we do not guarantee that this transmission is virus-free and will not be liable for any damages resulting from any transmitted viruses.</em></small>
  </div>

  <script>
    // Add animation or interactive elements using JavaScript or libraries like jQuery
    // Example: fade in effect
    document.addEventListener("DOMContentLoaded", function(event) {
      var container = document.querySelector(".container");
      container.style.opacity = 0;
      var fadeIn = function() {
        var op = 0.1;
        var timer = setInterval(function() {
          if (op >= 1) {
            clearInterval(timer);
          }
          container.style.opacity = op;
          container.style.filter = "alpha(opacity=" + op * 100 + ")";
          op += op * 0.1;
        }, 10);
      };
      fadeIn();
    });
  </script>
</body>
</html>
