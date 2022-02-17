<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        @page {
            margin: 0px !important;
        }
    </style>
  </head>
  <body>
    <div class="">
            <h6 class="mt-2 mb-3">
                {{ $visitor_email }} Report List
            </h6>

            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Staff</th>
                    <th scope="col">Date Time</th>
                    <th scope="col" class="text-right">Room</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visitors as $key => $visitor )
                        <tr>
                            <th scope="row" style="font-size: 12px">{{ $key + 1 }}</th>
                            <td style="font-size: 12px">{{ $visitor->appointment->title }}</td>

                            <td style="font-size: 12px">
                                {{ $visitor->appointment->staff->name }}
                                <br>
                                {{ $visitor->appointment->staff->phone}}, {{ $visitor->appointment->staff->email}}
                            </td>
                            <td style="font-size: 12px">
                                {{ $visitor->name }}   <br>
                                {{ $visitor->phone}}, {{ $visitor->email}}
                            </td>

                            <td style="font-size: 12px">{{ $visitor->appointment->request_time }}</td>
                            <td class="text-right" style="font-size: 12px">{{ $visitor->appointment->room ? $visitor->appointment->room->room_name : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
  </body>
</html>
