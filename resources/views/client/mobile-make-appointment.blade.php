@extends('layouts.client-layout')

@section('title', 'uab | Appointment Request Form')

@section('content')

@include('common.pre-loader')

@include('common.uab-mobile-header')

<div class="container-fluid">
    {{-- Appointment Request Form --}}
    <div class="max-w-1000 mx-auto">

        <h5 class="mt-3 mb-2"> Create Appointment </h5 >

        @include('common.flash-message')

        <nav aria-label="breadcrumb mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#!">Create</a></li>
            </ol>
        </nav>

        <div class="card px-3 py-3 mb-3">
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
        </div>

        <h6 class="text-default mt-1 mb-2 pl-1">Meeting Title</h6>

        <div class="form-group">
            <input autocomplete="off" type="text" class="form-control py-4 border-none" id="appointmentInput" name="appointment_id">
        </div>



        <div class="d-flex">
            <div class="flex-1 ">
                <h6 class="text-default mt-1 mb-2 pl-1">Date</h6>
                <div class="form-group mr-1">
                    <input autocomplete="off" type="text" class="form-control py-4 border-none" id="appointmentInput" name="appointment_id">
                </div>
            </div>

            <div class="flex-1 ">
                <h6 class="text-default mt-1 mb-2 pl-1">Time</h6>
                <div class="form-group ml-1">
                    <input autocomplete="off" type="text" class="form-control py-4 border-none" id="appointmentInput" name="appointment_id">
                </div>
            </div>
        </div>

        <h6 class="text-default mt-1 mb-2 pl-1">Location</h6>

        <div class="form-group">
            <select class="custom-select border-none h-50-helper" id="staff_branch" name="branch">
                <option value="1">uabTower@ Times City (Kamaryut)</option>
                <option value="2">Hledan (Kamaryut)</option>
            </select>
            <div class="invalid-feedback">
                Required Branch
            </div>
        </div>

        <h6 class="text-default mt-4 mb-3 pl-1">Invite People</h6>

        <div class="card px-3 py-2 mb-3">
            <h6 class="mt-2">
                Lwin Moe Paing
            </h6>
            <h6 class="text-default">
                09420059241
            </h6>
        </div>

        <div class="input-group">
            <input
                type="tel"
                class="form-control h-50-helper border-none visitors_0_phone placehoder-color"
                id="visitors_0_phone"
                name="visitors[0][phone]"
                autocomplete="chrome-off"
                placeholder="Phone"
            >
            <div class="input-group-append">
                <button class="btn btn-secondary px-4 right-radius h-50-helper" type="button">
                    Add
                </button>
            </div>
            <div class="invalid-feedback">Required Visitor Phone</div>
        </div>

        <div class="mb-3 pl-1">
            <div class="">
                <b style="color: #FFC107"> You can only invite uabpay user. </b>
            </div>
        </div>

        <div class="mt-1 mb-3">
            <a class="card upcoming-section p-3 mb-2 text-center d-block bg-primary text-white" href="#!">
                Create
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
