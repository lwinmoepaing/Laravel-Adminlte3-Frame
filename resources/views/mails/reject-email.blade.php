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

    <p style="margin: .5rem 0; color: #0078D7">
        Thank you for using uab Recipient Appointment Platform.
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
       Unfortunately we reject your invitation. You can try for appointment request.
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
       Meeting title: {{ $title }} {{ '<' }} A{{ str_pad($id, 6, '0', STR_PAD_LEFT)  . '>'}}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
       Appointment ID: {{ '<' }} A{{ str_pad($id, 6, '0', STR_PAD_LEFT)  . '>'}}
    </p>

    <p style="margin: .5rem 0; font-size: 13px;">
        Regret.
    </p>

    <a style="background-color: #fff; border:solid 1px; border-color:#0078D7;color: #0078D7; text-decoration: none;border-radius:2px; margin-bottom:6px; padding:8px; text-align:center; margin-right:8px; font-size: 12px; margin-top: 8px; display: block;" href="{{route('appointment.view')}}"> Go Appointment </a>

</body>
</html>


