<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Class | Schedule Details</title>
  <link rel="icon" type="image/x-icon" href="https://mymac.ukmcglobal.com/backend/src/assets/img/favicon.ico">

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
    input[type=text], select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        }

        input[type=submit] {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        }

        input[type=submit]:hover {
        background-color: #45a049;
        }
        .custom_div {
        border-radius: 6px;
        background-color: #f2f2f2;
        padding: 20px;
        }

        .confirm-btn{
            padding: 7px;
            background: #dd210e;
            border-color: #dd210e;
            color: #efeaea;
            border-radius: 5px;
        }
        .text-danger{
           color: #dd210e !important;
        }
  </style>
</head>
<body>
  <div class="container">
    <h2>Submit Your Id And Confirm</h2>
    <div class="container">
        <div class="custom_div col-md-12">
            <form method="post" action="{{ URL::to('class/schedule/attendence-confirmation') }}" enctype="multipart/form-data">
                @csrf
                <div class="col">
                    <input type="hidden" name="class_schedule_id" value="{{ (!empty($details->id))?$details->id:'' }}" />
                    <label for="id">Student Id:</label>
                    <input type="text" name="application_id" value="" />
                    @if ($errors->has('application_id'))
                        <span class="text-danger">{{ $errors->first('application_id') }}</span><br><br>
                    @endif
                    <button class="confirm-btn" type="submit" name="Confirm">Confirm</button>
                </div>
            </form>
        </div>
    </div><br><br>
    <h2>Class Schedule Details</h2>
	<p>
		<strong>Course Name:</strong>  {{ (!empty($details->course->course_name))?$details->course->course_name:'' }} <br><br>
    <strong>Subject:</strong>  {{ (!empty($details->subject->title))?$details->subject->title:'' }}<br><br>
    <strong>Intake:</strong> {{ (!empty($details->intake_date))?date('F Y',strtotime($details->intake_date)):'' }}<br><br>
    <strong>Schedule Title:</strong> {{ (!empty($details->title))?$details->title:'' }}<br><br>
    <strong>Class Schedule Date:</strong> {{ (!empty($details->schedule_date))?date('F d Y',strtotime($details->schedule_date)):'' }}<br><br>
    <strong>Class Schedule Time:</strong> {{ (!empty($details->time_from))?$details->time_from:'' }} - {{ (!empty($details->time_to))?$details->time_to:'' }}
	</p>


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
        Web:&nbsp; <a target="_blank" href="https://www.ukmcglobal.com">www.ukmcglobal.com</a>
    </p>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css" integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    @if(Session::has('success'))
      iziToast.show({
          title: 'Success',
          message: '{{ session('success') }}',
          position: 'topRight',
          timeout: 8000,
          color: 'blue',
          balloon: true,
          close: true,
          progressBarColor: 'yellow',
      });
    @endif
    @if(Session::has('error'))
      iziToast.show({
          title: 'Error',
          message: '{{ session('error') }}',
          position: 'topRight',
          timeout: 8000,
          color: 'red',
          balloon: true,
          close: true,
          progressBarColor: 'yellow',
      });
    @endif
    @if(Session::has('info'))
    iziToast.show({
          title: 'Info',
          message: '{{ session('info') }}',
          position: 'topRight',
          timeout: 8000,
          color: 'green',
          balloon: true,
          close: true,
          progressBarColor: 'yellow',
      });
    @endif
    @if(Session::has('warning'))
    iziToast.show({
          title: 'Info',
          message: '{{ session('warning') }}',
          position: 'topRight',
          timeout: 8000,
          color: 'yellow',
          balloon: true,
          close: true,
          progressBarColor: 'yellow',
      });
    @endif
  </script>
</body>
</html>



