@extends('layouts.client-layout')

@section('title', 'uab | Appointment Request Form')

@section('content')

@include('common.pre-loader')

@include('common.uab-mobile-header')

<div class="container-fluid">
    {{-- Appointment Request Form --}}
    <div class="max-w-1000 mx-auto">

        <h5 class="my-3 "> {{ $status ?? ''}} Appointments </h5 >

        <nav aria-label="breadcrumb mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#!">{{ $status }}</a></li>
            </ol>
        </nav>

        @include('common.flash-message')

        <div>
            <a class="card upcoming-section p-3 mb-2" href="{{ route('client.appointmen-detail', ['appointment_id' => 1]) }}">
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
