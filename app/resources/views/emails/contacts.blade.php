<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2family=Poppins:wght@300;400;50;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 2%;
        }
        .email-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-header {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .email-body {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-logo">
            <img loading="lazy" src="https://wall4.in/{{$Logo}}" height="50px" alt="{{$Name}}">
        </div>
        <div class="email-header">
            Dear {{ $UserName }},
        </div>
        <div class="email-body">
            Thank you for your enquiry.  Our team is eager to discuss your needs and will reach out shortly.
        </div>
    </div>
</body>
</html>
