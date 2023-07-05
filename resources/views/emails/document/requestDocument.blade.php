<!DOCTYPE html>
<html lang="en">
<head>
  <title>Requested Document</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container-fluid">
  <h5>Dear,</h5>
  <p>{{ (!empty($details['message']))?$details['message']:'Request For Document' }}</p><br>
  <p>Regards,</p>
  <p>{{ (!empty($details['create_by']))?$details['create_by']:'' }}</p>
</div>

</body>
</html>
