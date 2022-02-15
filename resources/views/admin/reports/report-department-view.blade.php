
@extends('layouts.admin-layout')


@push('head-scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@section('content')

    <div class="container main-wrapper mt-2">

        <nav aria-label="breadcrumb" class="mx-auto">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route('admin.index') }}" role="button">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('admin.reports.dashboard') }}" role="button">Reports</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('admin.reports.departments') }}" role="button">Department List</a>
                </li>
            </ol>
        </nav>


        <div class="card pt-3 pb-2 px-4 mt-3">
            <form action="" method="GET">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <input readonly name="date" autocomplete="off" type="text" class="form-control" id="dateRangePicker" value="" placeholder="{{$startOfDay . ' - ' . $endOfDay}}"/>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <button type="submit" class="btn btn-outline-primary btn-block"> <i class="fa fa-search"></i> Search </button>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-block dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Export As
                            </button>
                            <div class="dropdown-menu btn-block" aria-labelledby="dropdownMenu2">
                                <button class="dropdown-item" type="button">Excel</button>
                                <button class="dropdown-item" type="button" id="export-pdf">PDF</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card p-3 mt-2 ">
                    <h6 class="mt-2 mb-3">
                        Report By Department
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
                                    <td>{{ $appointment->department_name }}</td>
                                    <td class="text-right">
                                        <b>{{ $appointment->total_appointment_count }}</b>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('body-scripts')
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> --}}

    <script>
        $(document).ready(function () {
            var dateRangePicker = $('#dateRangePicker');
            $(dateRangePicker).daterangepicker({
                startDate: moment("{{$startOfDay}}", 'YYYY-MM-DD').startOf('hour'),
                endDate: moment("{{$endOfDay}}", 'YYYY-MM-DD').endOf('hour'),
                minDate: moment().subtract(3, 'months').startOf('month'),
                maxDate: moment().add(1, 'day').endOf('day')
            });
        });
    </script>
@endpush

