
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
                    <a href="{{ route('admin.reports.visitors') }}" role="button">Visitor History List</a>
                </li>
            </ol>
        </nav>


        <div class="card pt-3 pb-2 px-4 mt-3">
            <div class="row">

                    <div class="col-lg-6 col-sm-12">
                        <form action="" method="GET" id="SearchForm">
                            <div class="form-group">
                                <input readonly name="date" autocomplete="off" type="text" class="form-control" id="dateRangePicker" value="" placeholder="{{$startOfDay . ' - ' . $endOfDay}}"/>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-3 col-sm-12">
                        <button class="btn btn-outline-primary btn-block" id="search-form-btn"> <i class="fa fa-search"></i> Search </button>
                    </div>

                    <div class="col-lg-3 col-sm-12">
                        <div class="dropdown">
                                <button class="btn btn-secondary btn-block dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export As
                                </button>
                            <div class="dropdown-menu btn-block" aria-labelledby="dropdownMenu2">
                                <form action="{{ route('admin.reports.export-visitors') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="date" class="d-none" value="{{$startOfDay . ' - ' . $endOfDay}}">
                                    <button class="dropdown-item" type="submit" id="export-excel">Excel</button>
                                </form>

                                <form action="{{ route('admin.reports.export-visitors-pdf') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="date" class="d-none" value="{{$startOfDay . ' - ' . $endOfDay}}">
                                    <button class="dropdown-item" type="submit" id="export-pdf">PDF</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>


        <div class="card p-3 mt-2 ">
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

    </div>
@endsection

@push('body-scripts')
    <script>
        $(document).ready(function () {
            var dateRangePicker = $('#dateRangePicker');
            $(dateRangePicker).daterangepicker({
                startDate: moment("{{$startOfDay}}", 'YYYY-MM-DD').startOf('hour'),
                endDate: moment("{{$endOfDay}}", 'YYYY-MM-DD').endOf('hour'),
                minDate: moment().subtract(3, 'months').startOf('month'),
                maxDate: moment().add(1, 'day').endOf('day')
            });

            var searchFormBtn = $('#search-form-btn');
            var searchForm = $('#SearchForm');
            $(searchFormBtn).click(function() {
                $(searchForm).submit();
            });
        });
    </script>
@endpush

