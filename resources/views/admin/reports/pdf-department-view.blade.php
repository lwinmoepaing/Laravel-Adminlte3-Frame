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
                    <th scope="col">Customer</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Company</th>
                    <th scope="col" class="text-right">Appointments</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($visitors as $key => $visitor )
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $visitor->name }}</td>
                            <td>{{ $visitor->phone }}</td>
                            <td>{{ $visitor->email }}</td>
                            <td>{{ $visitor->company_name }}</td>
                            <td class="text-right">{{ $visitor->total_appointment_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
  </body>
</html>
