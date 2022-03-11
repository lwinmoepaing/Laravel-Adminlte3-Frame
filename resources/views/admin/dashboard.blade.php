@extends('layouts.admin-layout')

@section('content')
    <!-- top tiles -->
    <div class="container main-wrapper">
        <div class="row">
        <div class="col-lg-4 col-sm-12 tile_stats_count mb-3">
            <a href="{{ route('admin.appointment.appointment-view', ['showTab' => 'request']) }}">
                <div class="card p-3">
                    <span class="count_top"><img src="{{URL('/images/auth/request.png')}}" alt="request"></span>
                    <div class="count text-right">{{ $todayRequestAppointmentCount }}</div>
                    <span class="count_bottom text-right">Request Appointments</span>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-sm-12 tile_stats_count mb-3">
            <a href="{{ route('admin.appointment.appointment-view', ['showTab' => 'occupied']) }}">
                <div class="card p-3">
                    <span class="count_top"><img src="{{URL('/images/auth/occupied.png')}}" alt="occupied"></span>
                    <div class="count green text-right">{{ $occupiedAppointmentCount }}</div>
                    <span class="count_bottom text-right">Current Occupied</span>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-sm-12 tile_stats_count mb-3">
            <a href="{{ route('admin.appointment.appointment-view', ['showTab' => 'upcoming']) }}">
                    <div class="card p-3">
                        <span class="count_top"><img src="{{URL('/images/auth/upcoming.png')}}" alt="upcoming"></span>
                        <div class="count text-right">{{ $upcommingAppointmentCount ?? 0}}</div>
                        <span class="count_bottom text-right">Upcoming Appointments</span>
                    </div>
            </a>
        </div>
        </div>
    </div>

    <div class="container main-wrapper">
        <div class="row justify-content-between">
            <div class="col-12 col-xl-6 mb-2">
                <h5 class="mb-2">Upcoming Appointments</h5>
            </div>
            <div class="col-12 col-xl-6 mb-2">
                <form method="GET" action="" class="mb-2 d-flex">
                    <input class="form-control datetimepicker-input d-inline-block mr-2" type="text" name="search_date" placeholder="Date" aria-label="Date" data-toggle="datetimepicker" data-target="#datePicker" id="datePicker">
                    <input class="form-control d-inline-block mr-2" type="text" name="search_name" placeholder="Search" aria-label="Search" value="{{$queryName}}">
                    <button class="btn btn-primary d-md-block" type="submit">
                        <i class="fa fa-search text-white"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- appointments -->
        <div class="row">
            @foreach ($todayUpcomingAppointments as $appointment)
                <div class="col-md-12 mb-2">
                    <a class="card upcoming-section p-3" href="{{ route('admin.appointment.appointment-detail', ["appointment_id" => $appointment->id]) }}">
                    <div class="text-center min-w-85 appointment-time">
                        <span class="d-block border p-3 rounded">
                            <b>
                                {{ date('g : i', strtotime($appointment->meeting_time)) }}
                            </b>
                            <br>
                            {{ date('A', strtotime($appointment->meeting_time)) }}
                        </span>
                    </div>

                    <div class="w-100 ml-3">
                        <div class="row">
                        <div class="col-md-12 ">
                            <span class="mb-3">Appointments ID - {{ $appointment->id }}</span>
                            <span style="justify-content: flex-end;">
                                ({{ date('d M Y', strtotime($appointment->meeting_time)) }})
                            </span><br>
                            <h5 class="my-2">
                                <b>{{ $appointment->title }}</b>
                            </h5>
                        </div>

                        {{-- @if($appointment->visitor)
                            <div class="col-md-6 mb-2">
                                <h6>
                                    <i class="fa fa-user mr-2" style="font-size: 16px;"></i>
                                    {{ $appointment->visitor->name }}
                                </h6>
                                <span>
                                    {{ $appointment->visitor->phone }},
                                    {{ $appointment->visitor->company_name }},
                                    {{ $appointment->visitor->email }}
                                </span>
                            </div>
                        @endif --}}

                        <div class="col-md-6 mb-2">
                            {{-- <h6>
                                <i class="fa fa-user mr-2" style="font-size: 16px;"></i>
                                {{ $appointment->organizer_name }}
                            </h6> --}}
                            <span>
                                {{ $appointment->branch->branch_name }}
                            </span>
                        </div>
                        </div>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <!-- /top tiles -->
@endsection

@push('body-scripts')
    <script>
            $(document).ready(function() {
                var datePicker = $('#datePicker');

                $(datePicker).datetimepicker({
                    format: 'L',
                });

                $(datePicker).val(moment('{{$searchDate}}', 'YYYY/MM/DD').format('MM/DD/YYYY'));
            });
    </script>
@endpush
