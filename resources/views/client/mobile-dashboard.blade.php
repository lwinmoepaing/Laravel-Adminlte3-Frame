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
                <a href="{{ route('client.appointmens-by-status', ['status' => 'active']) }}">
                    <div class="card p-3 left-border-line line-success">
                        <div class="count-mobile-text text-right">0</div>
                        <span class="count_bottom text-right">Active</span>
                    </div>
                </a>
            </div>

            <div class="flex-1 mx-1 ">
                <a href="{{ route('client.appointmens-by-status', ['status' => 'request']) }}">
                    <div class="card p-3 left-border-line line-warning">
                        <div class="count-mobile-text green text-right">0</div>
                        <span class="count_bottom text-right">Request</span>
                    </div>
                </a>
            </div>

            <div class="flex-1 mx-1 ">
                <a href="{{ route('client.appointmens-by-status', ['status' => 'finished']) }}">
                    <div class="card p-3 left-border-line line-secondary">
                        <div class="count-mobile-text text-right">0</div>
                        <span class="count_bottom text-right">Finished</span>
                    </div>
                </a>
            </div>
        </div>

        <h5 class="my-3 "> Today Appointments </h5 >

        <div>
            <a class="card upcoming-section p-3 mb-2" href="{{ route('client.appointmen-detail', array_merge(['appointment_id' => 1], $generalParams)) }}">
                <div class="text-center min-w-85 appointment-time">
                    <span class="d-block border p-3 rounded">
                        <b>
                            22 FEB
                        </b>
                        <br>
                        <span class="small">4 : 11 PM</span>
                    </span>
                </div>

                <div class="w-100 ml-3">
                    <div class="row">
                        <div class="col-md-12 ">
                            <span class="mb-3">Appointments ID - 4</span>
                            <span style="justify-content: flex-end;">
                                (01 Mar 2022)
                            </span><br>
                            <h5 class="mt-2">
                                <b>zz</b>
                            </h5>
                        </div>

                        <div class="col-md-6">
                            <h6 class="mb-0">
                                <i class="fa fa-map-marker mr-2" style="font-size: 16px;"></i>
                                Fintech And Digital

                            </h6>
                        </div>
                    </div>
                </div>
            </a>
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
