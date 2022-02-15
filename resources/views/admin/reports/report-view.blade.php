
@extends('layouts.admin-layout')

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
            </ol>
        </nav>

        <div class="row justify-content-end">
            <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                <div class="card p-3 mb-2 text-center">
                    {{ $startOfDay . ' - ' . $endOfDay}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card p-3 mt-2 ">
                    <h6 class="text-left mt-2 mb-3 "> Client Visit Count </h6>
                    <canvas id="barChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card p-3 mt-2 justify-content-center d-flex ">
                    <h6 class="text-left mt-2 mb-3 "> Client Visit Percentage </h6>
                    <canvas id="donutChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card p-3 mt-2 ">
                    <h6 class="mt-2 mb-3">
                        Report By Department
                        <a  href="{{ route('admin.reports.departments') }}" class="float-right">See All</a>
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
                                    <td class="text-right">{{ $appointment->total_appointment_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card p-3 mt-2 ">
                    <h6 class="mt-2 mb-3">
                        Visitor History List
                        <a  href="#!" class="float-right">See All</a>
                    </h6>

                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">No</th>
                            <th scope="col">Customer</th>
                            <th scope="col" class="text-right">Appointments</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitors as $key => $visitor )
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $visitor->name }}</td>
                                    <td class="text-right">{{ $visitor->total_appointment_count }}</td>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.js"></script>
    <script>


        var appointments = {!! $appointments !!};
        var labels = appointments.length ? appointments.map(function (data) { return data.department_name }) : [];
        var dataCounts = appointments.length ? appointments.map(function (data) { return data.total_appointment_count }) : [];

        console.log(appointments);

        // Horizontal Bar Charts
        var areaChartData = {
            labels  : labels,
            datasets: [
                {
                    label               : 'Appointments',
                    backgroundColor     : '#686de0AF',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    barThickness: 20,
                    maxBarThickness: 10,
                    minBarLength: 0,
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : dataCounts,
                },
            ]
        }

        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        barChartData.datasets[0] = temp0

        var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : true,
            indexAxis               : 'y',
            legend: {
                display: false,
            },
            scales: {
                xAxes: [{
                    stacked: true
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }

        new Chart(barChartCanvas, {
            type: 'horizontalBar',
            data: barChartData,
            options: barChartOptions
        });

        // Donut Chat
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData = {
            labels: appointments.length ? appointments.map(function (data) {
                return calculatePercentage({{$total_appiontments}} || 0 , data.total_appointment_count || 0) + '% ' + data.department_name;
            }) : [],
            datasets: [
                {
                    data: dataCounts,
                    backgroundColor : dataCounts.map(function (value, index) { return randomColor(index) }),
                }
            ]
        }
        var donutOptions = {
            maintainAspectRatio : false,
            responsive : true,
            legend: {
                display: true,
                position: 'right',
                align: 'start',
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return ' ' + data['labels'][tooltipItem.index];
                    }
                }
            },
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        })
        function randomColor(index) {
            var colors = [
                '#686de0AF', '#eb4d4bAF', '#6ab04cAF', '#95afc0AF', '#be2eddAF', '#130f40AF', '#f9ca24AF'
            ];
            return colors[index];
        }

        function calculatePercentage(calculate, total) {
            return  Math.round((total / calculate) * 100);
        }

    </script>
@endpush


