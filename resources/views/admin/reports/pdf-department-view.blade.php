<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="">
            <h6 class="mt-2 mb-3">
                Visitor History List
            </h6>

            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Department</th>
                    <th scope="col" class="text-right">Appointments</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $key => $appointment )
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>
                                {{$appointment->department_name}}
                            </td>
                            <td class="text-right">
                                <b>{{ $appointment->total_appointment_count }}</b>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
  </body>
</html>
