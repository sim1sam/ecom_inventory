<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    @php
        $processedTemplate = str_replace('{{name}}', $user->name, $template);
        $processedTemplate = str_replace('{{token}}', $user->forget_password_token, $processedTemplate);
    @endphp
    {!! clean($processedTemplate) !!}
</body>
</html>
