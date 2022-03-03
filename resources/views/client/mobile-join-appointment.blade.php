@extends('layouts.client-layout')

@section('title', 'uab | Appointment Request Form')

@section('content')

@include('common.pre-loader')

@include('common.uab-mobile-header')

<div class="container-fluid">
    {{-- Appointment Request Form --}}
    <div class="max-w-1000 mx-auto">

        <h5 class="mt-3 mb-4"> Join Appointment </h5 >

        @include('common.flash-message')

        <nav aria-label="breadcrumb mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#!">Join Appointment</a></li>
            </ol>
        </nav>

        <h6 class="text-default mt-4 mb-3 pl-1">Appointment ID</h6>

        <div class="form-group">
            <input autocomplete="off" type="text" class="form-control py-4 border-none" id="appointmentInput" name="appointment_id">
        </div>

        <div class="my-3">
            <a class="card upcoming-section p-3 mb-2 text-center d-block bg-primary text-white" href="#!">
                Join Appiontment
            </a>
            <a class="card upcoming-section p-3 mb-2 text-center d-block" href="{{ route('client.dashboard') }}">
                Back to Dashboard
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
