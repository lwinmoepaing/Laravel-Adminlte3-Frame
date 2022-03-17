@extends('layouts.client-layout')

@section('title', 'uab | Appointment Request Form')

@section('content')

@include('common.pre-loader')

@include('common.uab-mobile-header')

<div class="container-fluid">
    {{-- Appointment Request Form --}}
    <div class="max-w-1000 mx-auto">

        <h5 class="my-3 "> Appointment ID -  {{ $appointment->id  }} </h5>

        <nav aria-label="breadcrumb mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('client.dashboard', $generalParams) }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.appointmens-by-status', array_merge(['status' => strtolower($current_account['appointment_status'] ?? '')], $generalParams)) }}">{{ $current_account['appointment_status'] ?? '' }}</a></li>
                <li class="breadcrumb-item"><a href="#!">{{ $appointment->id }}</a></li>
            </ol>
        </nav>

        @include('common.flash-message')

        <div class="card px-3 pt-3 mb-3">
            <div class="w-100 p-3">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="mb-3 text-primary">Appointment Integration </h5>
                        <h6 class="my-2 text-default">
                            {{ $appointment->request_time }}
                        </h6>
                        <h6 class="mb-0">
                            <i class="fa fa-map-marker mr-2" style="font-size: 16px;"></i>
                            {{ $appointment->branch->branch_name}}
                        </h6>
                        <hr>
                    </div>

                    <div class="col-md-12">
                        <span> <i class="fa fa-user mr-2 text-info" style="font-size: 16px;"></i> Organizer</span>
                        <h6 class="mt-2">
                            {{ $organizer->name }}
                        </h6>

                        <h6 class="text-default">
                            {{ $organizer->phone}}
                            @isset($organizer->company_name)
                                {{ $organizer->company_name ? ', ' . $organizer->company_name : ''}}
                            @endisset

                        </h6>
                        @isset($organizer->email)
                            <h6 class="text-default">
                                {{ $organizer->email}}
                            </h6>
                        @endisset
                        <hr>
                    </div>

                    <div class="col-md-12">
                        <span> <i class="fa fa-user-plus mr-2 text-info" style="font-size: 16px;"></i> Invited Persons ( {{$invited_person_count}} ) </span>


                        @foreach ( $invited_person as $user)
                            <div>
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <h6 class="mt-2">
                                            {{ $user['name'] }}
                                        </h6>
                                        <h6 class="text-default">
                                            {{ $user['phone'] }}
                                        </h6>
                                    </div>
                                    <div class="flex-1 text-right d-flex align-items-center justify-content-end ">
                                        <span class="badge badge-{{$user['pivot']['status'] == 1 ? 'warning' : ($user['pivot']['status'] == 2 ? 'primary' : 'danger')}} fontsize-12 px-3">
                                            {{ $user['status_name']}}
                                        </span>
                                    </div>
                                </div>
                                <hr class="mt-1">
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

        <div class="mt-1 mb-3">

            @switch($current_account['pivot']['status'])
                {{-- Pending Case --}}
                @case(1)

                    <form method="POST" class="d-block">
                        @csrf
                        <input type="hidden" name="status" value="2">
                        <button class="card upcoming-section w-100 p-3 mb-2 text-center d-block bg-primary text-white" type="submit">
                            Accept Appointment
                        </button>
                    </form>

                    <form method="POST" class="d-block">
                        @csrf
                        <input type="hidden" name="status" value="3">
                        <button class="card upcoming-section w-100 p-3 mb-2 text-center d-block text-danger" type="submit">
                            Can't Go
                        </button>
                    </form>
                @break

                @default

            @endswitch

            <a class="card upcoming-section p-3 mb-2 text-center d-block bg-secondary text-primary" href="{{ route('client.dashboard', $generalParams)}}">
                Back to Dashboard
            </a>
            {{-- <a
                class="card upcoming-section p-3 mb-2 text-center d-block bg-primary text-white"
                href="{{ route('client.appointmen-snooze', ['appointment_id' => 1]) }} ">
                Snooze Appointment
            </a> --}}
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
