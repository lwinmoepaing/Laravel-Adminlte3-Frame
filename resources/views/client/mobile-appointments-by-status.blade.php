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
                <li class="breadcrumb-item"><a href="{{ route('client.dashboard', $generalParams) }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#!">{{ $status }}</a></li>
            </ol>
        </nav>

        @include('common.flash-message')

        <div>
            @foreach ($appointmentData as $appointment)
                <a class="card upcoming-section p-3 mb-2" href="{{ route('client.appointmen-detail', array_merge(['appointment_id' => $appointment['id']], $generalParams)) }}">
                    <div class="text-center min-w-85 appointment-time">
                        <span class="d-block border p-3 rounded">
                            <b>
                                {{ date('g : i', strtotime($appointment['meeting_request_time'])) }}
                            </b>
                            <br>
                            <span class="small">{{ date('A', strtotime($appointment['meeting_request_time'])) }}</span>
                        </span>
                    </div>

                    <div class="w-100 ml-3">
                        <div class="row">
                            <div class="col-md-12 ">
                                <span class="mb-3">Appointments ID - {{$appointment['id']}}</span>
                                <span style="justify-content: flex-end;">
                                    ({{ $appointment['request_time'] }})
                                </span><br>
                                <h5 class="mt-2">
                                    <b>{{ $appointment['title'] }}</b>
                                </h5>
                            </div>

                            <div class="col-md-6">
                                <h6 class="mb-0">
                                    <i class="fa fa-map-marker mr-2" style="font-size: 16px;"></i>
                                    {{ $appointment['branch']['branch_name'] }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
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
