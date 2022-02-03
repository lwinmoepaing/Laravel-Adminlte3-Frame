@extends('layouts.admin-layout')

@section('content')
    <!-- top tiles -->
    <div class="container main-wrapper">
        <div class="row">
        <div class="col-lg-4 col-sm-12 tile_stats_count mb-3">
            <div class="card p-3">
            <span class="count_top"><img src="{{URL('/images/auth/request.png')}}" alt="request"></span>

            <div class="count text-right">{{ $todayRequestAppointmentCount }}</div>
            <span class="count_bottom text-right">Request Appointments</span>
            </div>
        </div>

        <div class="col-lg-4 col-sm-12 tile_stats_count mb-3">
            <div class="card p-3">
            <span class="count_top"><img src="{{URL('/images/auth/occupied.png')}}" alt="occupied"></span>
            <div class="count green text-right">{{ $occupiedAppointmentCount }}</div>
            <span class="count_bottom text-right">Current Occupied</span>
            </div>
        </div>

        <div class="col-lg-4 col-sm-12 tile_stats_count mb-3">
            <div class="card p-3">
            <span class="count_top"><img src="{{URL('/images/auth/upcoming.png')}}" alt="upcoming"></span>
            <div class="count text-right">{{ $upcommingAppointmentCount }}</div>
            <span class="count_bottom text-right">Upcoming Appointments</span>
            </div>
        </div>
        </div>
    </div>

    <div class="container main-wrapper">
        <div class="row">
            <div class="col-md-6 mb-2">
                <h5 class="mb-0">Upcoming Appointments</h5>
            </div>
            <div class="col-md-6 mb-2">
                <form class="form-inline mb-2" style="justify-content: flex-end;">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-primary btn_min_block my-2 my-sm-0" type="submit">
                        <i class="fa fa-search text-white"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- appointments -->
        <div class="row">
            @foreach ($todayUpcomingAppointments as $appointment)
                <div class="col-md-12 mb-2">
                    <a class="card upcoming-section p-3" href="{{ route('admin.appointment.detail', ["appintment_id" => $appointment->id]) }}">
                    <div class="text-center w-10 appointment-time">
                        <span class="d-block border p-3 rounded">
                            <b>
                                {{ date('g:i', strtotime($appointment->meeting_time)) }}
                            </b>
                            <br>
                            {{ date('A', strtotime($appointment->meeting_time)) }}
                        </span>
                    </div>

                    <div class="w-100 ml-3">
                        <div class="row">
                        <div class="col-md-12 mb-2">
                            <span class="mb-3">Appointments ID - {{ $appointment->id }}</span>
                            <span style="justify-content: flex-end;">
                                ({{ date('d M Y', strtotime($appointment->meeting_time)) }})
                            </span><br>
                            <h5 class="my-2">
                                <b>{{ $appointment->title }}</b>
                            </h5>
                        </div>

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

                        <div class="col-md-6 mb-2">
                            <h6>
                                <i class="fa fa-user mr-2" style="font-size: 16px;"></i>
                                {{ $appointment->staff->name }}
                            </h6>
                            <span>
                                {{ $appointment->staff->department->id != 1 ? $appointment->staff->department->department_name : '' }}
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
