<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
</head>
<body>
    {!! clean($template) !!}
    
    <p>Please click the link below to verify your email address:</p>
    <a href="{{ $verificationUrl }}" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Verify Email Address</a>
    
    <p>If the button doesn't work, you can copy and paste this link into your browser:</p>
    <p>{{ $verificationUrl }}</p>
</body>
</html>
