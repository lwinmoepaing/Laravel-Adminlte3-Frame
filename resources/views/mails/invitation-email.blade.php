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
        You have been invited Meeting. <{{ $to_email }}>
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        {{ $title }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">Appointment ID</span>  A{{ str_pad($id, 6, '0', STR_PAD_LEFT) }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">When</span>  {{ $start_date }} MM-Time
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">From</span> {{ $request_from }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">Description</span> {{ $title }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">Address</span> {{ $address }}
    </p>

    <a style="background-color: #fff; border:solid 1px; border-color:#0078D7;color: #0078D7; text-decoration: none;border-radius:2px; margin-bottom:6px; padding:8px; text-align:center; margin-right:8px; font-size: 12px; margin-top: 8px; display: inline-block;" href="{{route('appointment.checkconfirm', ['appointment_id' => $id, 'is_confirmed' => 'true' ])}}"> Confirm </a>
    <a style="background-color: #fff; border:solid 1px; border-color:red; color: red; text-decoration: none; border-radius:2px; margin-bottom:6px; padding:8px; text-align:center; margin-right:8px; font-size: 12px; margin-top: 8px; display: inline-block;" href="{{route('appointment.checkconfirm', ['appointment_id' => $id, 'is_confirmed' => 'false' ])}}"> Reject </a>

    @isset($is_back)
        <a href="/"> Back Home </a>
    @endisset


</body>
</html>


