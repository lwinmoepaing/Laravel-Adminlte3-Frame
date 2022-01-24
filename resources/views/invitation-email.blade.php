<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body style="border: 1px solid #dfdfdf; box-sizing: border-box; padding: 10px; margin: 0">
    <p style="margin: .5rem 0; color: #090">
        You have been invited to meet. <{{ $to_email }}>
    </p>
    <p style="margin: .5rem 0;">
        {{ $title }}
    </p>
    <p style="margin: .5rem 0;">
        <span style="display: inline-block; min-width: 100px">When</span> 7 March 2022 7:30pm - 8:30pm
    </p>

    <p style="margin: .5rem 0;">
        <span style="display: inline-block; min-width: 100px">From</span> {{ $request_from }}
    </p>

    <p style="margin: .5rem 0;">
        <span style="display: inline-block; min-width: 100px">Description</span> Some Testing Description
    </p>

    @isset($is_back)
        <a href="/"> Back Home </a>
    @endisset


</body>
</html>


