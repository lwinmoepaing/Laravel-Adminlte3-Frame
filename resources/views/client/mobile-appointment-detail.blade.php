@extends('layouts.client-layout')

@section('title', 'uab | Appointment Request Form')

@section('content')

@include('common.pre-loader')

@include('common.uab-mobile-header')

<div class="container-fluid">
    {{-- Appointment Request Form --}}
    <div class="max-w-1000 mx-auto">

        <h5 class="my-3 "> Appointment ID -  {{ $appointment_id }} </h5>

        <nav aria-label="breadcrumb mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.appointmens-by-status', ['status' => strtolower($status ?? '')]) }}">{{ $status }}</a></li>
                <li class="breadcrumb-item"><a href="#!">{{ $appointment_id }}</a></li>
            </ol>
        </nav>

        @include('common.flash-message')

        <div class="card px-3 pt-3 mb-3">
            <div class="w-100 p-3">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="mb-3 text-primary">Appointment Integration </h5>
                        <h6 class="my-2 text-default">
                            03 Mar 2022 - 10 : 09 AM
                        </h6>
                        <h6 class="mb-0">
                            <i class="fa fa-map-marker mr-2" style="font-size: 16px;"></i>
                            TimeCity uab Tower
                        </h6>
                        <hr>
                    </div>

                    <div class="col-md-12">
                        <span> <i class="fa fa-user mr-2 text-info" style="font-size: 16px;"></i> Organizer</span>
                        <h6 class="mt-2">
                            Lwin Moe Paing
                        </h6>
                        <h6 class="text-default">
                            09420059241,
                            LwinCo,
                        </h6>
                        <h6 class="text-default">
                            lwinmoepaing.dev@gmail.com
                        </h6>
                        <hr>
                    </div>

                    <div class="col-md-12">
                        <span> <i class="fa fa-user-plus mr-2 text-info" style="font-size: 16px;"></i> Invited Persons ( 3 ) </span>


                        <div>
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h6 class="mt-2">
                                        Lwin Moe Paing
                                    </h6>
                                    <h6 class="text-default">
                                        09420059241
                                    </h6>
                                </div>
                                <div class="flex-1 text-right d-flex align-items-center justify-content-end ">
                                    <span class="badge badge-danger fontsize-12 px-3">Can't Go<span>
                                </div>
                            </div>
                            <hr class="mt-1">
                        </div>
                        <div>
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h6 class="mt-2">
                                        Lwin Moe Paing
                                    </h6>
                                    <h6 class="text-default">
                                        09420059241
                                    </h6>
                                </div>
                                <div class="flex-1 text-right d-flex align-items-center justify-content-end ">
                                    <span class="badge badge-success fontsize-12 px-3">Accepted<span>
                                </div>
                            </div>
                            <hr class="mt-1">
                        </div>
                        <div>
                            <div class="d-flex">
                                <div class="flex-1">
                                    <h6 class="mt-2">
                                        Lwin Moe Paing
                                    </h6>
                                    <h6 class="text-default">
                                        09420059241
                                    </h6>
                                </div>
                                <div class="flex-1 text-right d-flex align-items-center justify-content-end ">
                                    <span class="badge badge-warning fontsize-12 px-3">Pending<span>
                                </div>
                            </div>
                            <hr class="mt-1">
                        </div>


                    </div>

                </div>
            </div>
        </div>

        <div class="mt-1 mb-3">
            <a class="card upcoming-section p-3 mb-2 text-center d-block bg-primary text-white" href="#!">
                Accept Appointment
            </a>
            <a class="card upcoming-section p-3 mb-2 text-center d-block text-danger" href="#!">
                Can't Go
            </a>
            <a class="card upcoming-section p-3 mb-2 text-center d-block bg-secondary text-primary" href="#!">
                Back to Dashboard
            </a>
            <a
                class="card upcoming-section p-3 mb-2 text-center d-block bg-primary text-white"
                href="{{ route('client.appointmen-snooze', ['appointment_id' => 1]) }} ">
                Snooze Appointment
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
