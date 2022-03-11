@extends('layouts.client-layout')

@section('title', 'uab | Appointment Request Form')

@section('content')

@include('common.pre-loader')

@include('common.uab-mobile-header')

<div class="container-fluid">
    <div class="max-w-1000 mx-auto">

            <h5 class="mt-3 mb-4"> Join Appointment </h5 >

            @include('common.flash-message')

            <nav aria-label="breadcrumb mb-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('client.dashboard', $generalParams) }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#!">Join Appointment</a></li>
                </ol>
            </nav>

            <h6 class="text-default mt-4 mb-3 pl-1">Appointment ID</h6>

            <form  method="POST">
                @csrf

                <div class="form-group">
                    <input autocomplete="off"
                        type="text"
                        class="form-control py-4 border-none @error('appointment_id') is-invalid @enderror"
                        id="appointmentInput"
                        name="appointment_id"
                        value="{{old('appointment_id')}}"
                    >
                    <div class="invalid-feedback">
                        Appointment ID is required.
                    </div>
                </div>

                <div class="my-3">
                    <button class="card upcoming-section d-block w-100 p-3 mb-2 text-center d-block bg-primary text-white" type="submit">
                        Join Appiontment
                    </button>


                    <a class="card upcoming-section p-3 mb-2 text-center d-block" href="{{ route('client.dashboard', $generalParams) }}">
                        Back to Dashboard
                    </a>
                </div>
            </form>
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
