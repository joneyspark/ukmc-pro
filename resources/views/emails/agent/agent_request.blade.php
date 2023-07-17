<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>New Agent Request</title>
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
    <h2>New Agent Request</h2>
    <p>Hello,</p>

    <p>Here are the details of the new agent information..</p>
	<h3>Company Information</h3>
    <table style="width:65%" border="0">
        <tr>
            <td>Company Name</td>
            <td>{{ (!empty($details['company_info']->company_name))?$details['company_info']->company_name:'' }}</td>
        </tr>
        <tr>
            <td>Company Registration Number</td>
            <td>{{ (!empty($details['company_info']->company_registration_number))?$details['company_info']->company_registration_number:'' }}</td>
        </tr>
		<tr>
            <td>Company Establish Date</td>
            <td>{{ (!empty($details['company_info']->company_establish_date))?$details['company_info']->company_establish_date:'' }}</td>
        </tr>
		<tr>
            <td>Company Trade License Number</td>
            <td>{{ (!empty($details['company_info']->company_trade_license_number))?$details['company_info']->company_trade_license_number:'' }}</td>
        </tr>
		<tr>
            <td>Company Email</td>
            <td>{{ (!empty($details['company_info']->company_email))?$details['company_info']->company_email:'' }}</td>
        </tr>
		<tr>
            <td>Company Phone</td>
            <td>{{ (!empty($details['company_info']->company_phone))?$details['company_info']->company_phone:'' }}</td>
        </tr>
		<tr>
            <td>Company Country</td>
            <td>{{ (!empty($details['company_info']->country))?$details['company_info']->country:'' }}</td>
        </tr>
		<tr>
            <td>Company State</td>
            <td>{{ (!empty($details['company_info']->state))?$details['company_info']->state:'' }}</td>
        </tr>
        <tr>
            <td>Company City</td>
            <td>{{ (!empty($details['company_info']->city))?$details['company_info']->city:'' }}</td>
        </tr>
        <tr>
            <td>Zip Code</td>
            <td>{{ (!empty($details['company_info']->zip_code))?$details['company_info']->zip_code:'' }}</td>
        </tr>
		<tr>
            <td>Company Address</td>
            <td>{{ (!empty($details['company_info']->address))?$details['company_info']->address:'' }}</td>
        </tr>

    </table>
	<h3>Director,s Information</h3>
    <table style="width:65%" border="0">
        <tr>
            <td>Director’s Name</td>
            <td>{{ (!empty($details['company_info']->company_director->director_name))?$details['company_info']->company_director->director_name:'' }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ (!empty($details['company_info']->company_director->phone))?$details['company_info']->company_director->phone:'' }}</td>
        </tr>
		<tr>
            <td>Email</td>
            <td>{{ (!empty($details['company_info']->company_director->email))?$details['company_info']->company_director->email:'' }}</td>
        </tr>
		<tr>
            <td>Passport Number</td>
            <td>{{ (!empty($details['company_info']->company_director->passport_number))?$details['company_info']->company_director->passport_number:'' }}</td>
        </tr>
		<tr>
            <td>Nationality</td>
            <td>{{ (!empty($details['company_info']->company_director->nationality))?$details['company_info']->company_director->nationality:'' }}</td>
        </tr>
		<tr>
            <td>Address</td>
            <td>{{ (!empty($details['company_info']->company_director->address))?$details['company_info']->company_director->address:'' }}</td>
        </tr>
		<tr>
            <td>City</td>
            <td>{{ (!empty($details['company_info']->company_director->city))?$details['company_info']->company_director->city:'' }}</td>
        </tr>
		<tr>
            <td>Key Contact’s Name</td>
            <td>{{ (!empty($details['company_info']->company_director->key_contact_name))?$details['company_info']->company_director->key_contact_name:'' }}</td>
        </tr>
		<tr>
            <td>Key Contact’s Phone Number</td>
            <td>{{ (!empty($details['company_info']->company_director->key_contact_number))?$details['company_info']->company_director->key_contact_number:'' }}</td>
        </tr>
    </table>
    @if(count($details['company_info']->company_reference) > 0)
    @foreach ($details['company_info']->company_reference as $key=>$reference)
    <div>
        <h3>Reference {{ $key+1 }}</h3>
        <table style="width:65%" border="0">
            <tr>
                <td>Company Name</td>
                <td>{{ (!empty($reference->company_name))?$reference->company_name:'' }}</td>
            </tr>
            <tr>
                <td>Referee’s Name</td>
                <td>{{ (!empty($reference->referee_name))?$reference->referee_name:'' }}</td>
            </tr>
            <tr>
                <td>Referee’s Job Title</td>
                <td>{{ (!empty($reference->referee_job_title))?$reference->referee_job_title:'' }}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{{ (!empty($reference->address))?$reference->address:'' }}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>{{ (!empty($reference->phone))?$reference->phone:'' }}</td>
            </tr>
            <tr>
                <td>Contact Email Address</td>
                <td>{{ (!empty($reference->contact_email_address))?$reference->contact_email_address:'' }}</td>
            </tr>
        </table>
    </div>
    @endforeach
    @endif

    @if(count($details['company_info']->company_document) > 0)
    <h3>Document List</h3>
    <table style="width:65%" border="0">
        @foreach ($details['company_info']->company_document as $document)
        <tr>
            <td>{{ (!empty($document->title))?$document->title:'' }}</td>
            <td>{{ (!empty($document->title))?'Yes':'No' }}</td>
			<td><a download href="{{ asset($document->document) }}">Download</a></td>
        </tr>
        @endforeach
    </table>
    @endif


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
