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
        Your Visitors Arrived.
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">Meeting title: </span>
        {{ $title }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">Appointment ID: </span>
        A{{ str_pad($id, 6, '0', STR_PAD_LEFT) }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">Room Name: </span>
        {{ $room->room_name }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">Visitor: </span>
         {{ $visitor->name }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">Visitor Email: </span>
       {{ $visitor->email }}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        <span style="display: inline-block; min-width: 120px">Visitor Phone: </span>
        {{ $visitor->phone }}
    </p>

</body>
</html>


