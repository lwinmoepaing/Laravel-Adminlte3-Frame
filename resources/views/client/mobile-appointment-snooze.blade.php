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
                <li class="breadcrumb-item"><a href="{{ route('client.appointmen-detail', ['appointment_id' => $appointment_id]) }}">{{ $appointment_id }}</a></li>
                <li class="breadcrumb-item"><a href="#!">Snooze</a></li>
            </ol>
        </nav>

        @include('common.flash-message')

        <h6 class="text-default mt-4 mb-3 pl-1">Snooze Time</h6>

        <div class="d-flex">
            <div class="flex-1 mx-1">
                <div data-value="15 Mins" class="card timerClick isLink  active p-3">
                    <h5 class="text-center m-0">15 Mins</h5>
                </div>
            </div>

            <div class="flex-1 mx-1 ">
                <div data-value="30 Mins" class="card timerClick isLink p-3">
                    <h5 class="text-center m-0">30 Mins</h5>
                </div>
            </div>

            <div class="flex-1 mx-1 ">
                <div data-value="1 Hour" class="card timerClick isLink p-3">
                    <h5 class="text-center m-0">1 Hour</h5>
                </div>
            </div>
        </div>

        <h6 class="text-default mt-4 mb-3 pl-1">Description</h6>

        <div class="form-group">
            <textarea class="form-control" rows="4" style="resize: none;"></textarea>
        </div>


        <div class="mt-3 mb-3">
            <a class="card upcoming-section p-3 mb-2 text-center d-block bg-primary text-white" href="#!">
                Snooze
            </a>
        </div>

    </div>
    {{-- Appointment Request Form Finished --}}
</div>



@push('body-scripts')
<script>
    $(document).ready(function () {
        $('#error_toast').toast('show');

        $('.timerClick').click(function () {
            var val = $(this).data('value');
            console.log(val);
            removeActive();

            $(this).addClass('active');
        });

        function removeActive() {
            var allCliclableTimers = $('.timerClick');
            console.log(allCliclableTimers);
            $(allCliclableTimers).each(function(index, data) {
                $(data).removeClass('active');
            });
        }
    });
</script>
@endpush

@endsection
