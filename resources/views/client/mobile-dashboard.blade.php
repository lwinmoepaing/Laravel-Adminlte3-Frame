@extends('layouts.client-layout')

@section('title', 'uab | Appointment Request Form')

@section('content')

@include('common.pre-loader')

@include('common.uab-mobile-header')

<div class="container-fluid">
    {{-- Appointment Request Form --}}
    <div class="max-w-1000 mx-auto">

        <h5 class="my-3 "> Dashboard </h5 >

        @include('common.flash-message')

        <div class="d-flex">
            <div class="flex-1 mx-1 ">
                <a href="{{ route('client.appointmens-by-status', array_merge(['status' => 'active'], $generalParams)) }}">
                    <div class="card p-3 left-border-line line-success">
                        <div class="count-mobile-text text-right">{{$activeAppointmentsCount}}</div>
                        <span class="count_bottom text-right">Active</span>
                    </div>
                </a>
            </div>

            <div class="flex-1 mx-1 ">
                <a href="{{ route('client.appointmens-by-status', array_merge(['status' => 'request'], $generalParams)) }}">
                    <div class="card p-3 left-border-line line-warning">
                        <div class="count-mobile-text text-right">{{$requestAppointmentsCount}}</div>
                        <span class="count_bottom text-right">Request</span>
                    </div>
                </a>
            </div>

            <div class="flex-1 mx-1 ">
                <a href="{{ route('client.appointmens-by-status', array_merge(['status' => 'finished'], $generalParams)) }}">
                    <div class="card p-3 left-border-line line-secondary">
                        <div class="count-mobile-text text-right">{{$finishedAppointmentCount}}</div>
                        <span class="count_bottom text-right">Finished</span>
                    </div>
                </a>
            </div>
        </div>

        <h5 class="my-3 "> Today Appointments </h5 >

        <div>

            @foreach ($todayAppointments as $todayAppointment)
                <a class="card upcoming-section p-3 mb-2" href="{{ route('client.appointmen-detail', array_merge(['appointment_id' => $todayAppointment['id']], $generalParams)) }}">
                    <div class="text-center min-w-85 appointment-time">
                        <span class="d-block border p-3 rounded">
                            <b>
                                {{ date('g : i', strtotime($todayAppointment['meeting_request_time'])) }}
                            </b>
                            <br>
                            <span class="small">{{ date('A', strtotime($todayAppointment['meeting_request_time'])) }}</span>
                        </span>
                    </div>

                    <div class="w-100 ml-3">
                        <div class="row">
                            <div class="col-md-12 ">
                                <span class="mb-3">Appointments ID - {{$todayAppointment['id']}}</span>
                                <span style="justify-content: flex-end;">
                                    ({{ $todayAppointment['request_time'] }})
                                </span><br>
                                <h5 class="mt-2">
                                    <b>{{ $todayAppointment['title'] }}</b>
                                </h5>
                            </div>

                            <div class="col-md-6">
                                <h6 class="mb-0">
                                    <i class="fa fa-map-marker mr-2" style="font-size: 16px;"></i>
                                    {{ $todayAppointment['branch']['branch_name'] }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="my-3">
            <a
                class="card upcoming-section p-3 mb-2 text-center d-block"
                href="{{ route('client.join-appointment', $generalParams) }}">
                <img src="{{URL('images/auth/join_appointment.png')}}" class="uab-icon-small mr-1">
                Join Appiontment
            </a>
            <a
                class="card upcoming-section p-3 mb-2 text-center d-block"
                href="{{ route('client.make-appointment', $generalParams) }}">
                <img src="{{URL('images/auth/make_appointment.png')}}" class="uab-icon-small mr-1">
                Make Appiontment
            </a>
        </div>

    </div>
    {{-- Appointment Request Form Finished --}}
</div>



@push('body-scripts')
<script>
    $(document).ready(function () {
        $('#error_toast').toast('show');
    });
</script>
@endpush

@endsection
