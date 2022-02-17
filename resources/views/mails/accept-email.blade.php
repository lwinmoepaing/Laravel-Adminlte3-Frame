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
        Invitation Meeting {{ $isInvite == true ? '' : 'Acceptance' }}. <{{ $to_email }}>
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
       <span style="display: inline-block; min-width: 120px">Meeting Title: </span> {{ $title }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">Appointment ID: </span>  A{{ str_pad($id, 6, '0', STR_PAD_LEFT) }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">When: </span>  {{ $start_date }} MM-Time
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">{{ $isInvite == true ? 'To' : 'From' }}: </span> {{ $request_from }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">Description: </span> {{ $title }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">Address: </span> {{ $address }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        Thank you for using uab Recipient Appointment Platform.
    </p>



</body>
</html>


