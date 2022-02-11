@extends('layouts.admin-layout')

@section('title', 'Appointment - ' . $appointment->id)

@section('content')


<form class="form-flex" action="{{ route('admin.appointment.appointment-status-update', ['appointment_id' => $appointment->id]) }}" method="POST">
    @csrf

<div class="container main-wrapper">
    <div class="row">
        <div class="col-md-6 offset-md-3">

        <nav aria-label="breadcrumb mb-2">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.appointment.appointment-view') }}">Appointments</a></li>
            <li class="breadcrumb-item active" aria-current="page"> {{ $appointment->id }} </li>
            </ol>
        </nav>

        @include('common.flash-message')

        <div class="card p-3">
            <div class="w-100 p-3">
            <div class="row">
                <div class="col-md-12">
                <span class="mb-3">Appointments ID -  {{ $appointment->id }} </span>

                @if ($appointment->status === 1)
                    <div class="float-right">
                        <a href="{{ route('admin.appointment.appointment-edit', ["appointment_id" => $appointment->id]) }}"> Edit Appointment </a>
                    </div>
                @endif

                <br>
                <h5 class="my-2">
                    <b>{{ $appointment->title ?? '-'}}</b>
                </h5>
                </div>
                <div class="col-md-12 my-3">
                <span>Client</span>
                <h6 class="mt-2">
                    <i class="fa fa-user mr-2" style="font-size: 16px;"></i>
                    {{ $appointment->visitor->name }}
                </h6>
                <span>
                    {{ $appointment->visitor->phone }},
                    {{ $appointment->visitor->company_name }},
                    {{ $appointment->visitor->email }}
                </span>
                </div>

                <div class="col-md-12 my-3">
                <span>uab officer</span>
                <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>{{ $appointment->staff->name }}</h6>
                <span>
                    {{ $appointment->staff->department->id != 1 ? $appointment->staff->department->department_name : '' }}
                </span>
                </div>

                <div class="col-md-12 my-3">
                    <span>Request Time</span>
                    <h6 class="mt-2">
                        <i class="fa fa-calendar mr-2" style="font-size: 16px;"></i>{{ date('d M Y - g : i A', strtotime($appointment->meeting_time)) }}
                    </h6>
                </div>

                @if ($appointment->meeting_leave_time)
                    <div class="col-md-12 my-3">
                        <span>Finished Time</span>
                        <h6 class="mt-2">
                            <i class="fa fa-calendar mr-2" style="font-size: 16px;"></i>{{ date('d M Y - g : i A', strtotime($appointment->meeting_leave_time)) }}
                        </h6>
                    </div>
                @endif

                @if ($appointment->room)
                    <div class="col-md-12 my-3">
                        <span>Room Detail</span>
                        <h6 class="mt-2">
                            <i class="fa fa-clone mr-2" style="font-size: 16px;"></i> {{ $appointment->room->room_name ? $appointment->room->room_name . ' ,' : ' - '}} {{ $appointment->branch->branch_name}}
                        </h6>
                    </div>
                @endif



                    <div class="col-md-12 mt-3">

                        <label class="mt-1 mr-2" for="status">Appointment Status</label><br>

                        <select
                            class="
                                custom-select mt-1 mr-sm-2
                                @if ($hasChangeStatus = Session::get('pendingError'))
                                    is-invalid
                                @endif
                            "
                            id="status" name="status"
                            {{ $appointment->status == 1 || $appointment->status == 2 ? '' : 'disabled' }}
                        >
                            @foreach ($appointmentStatusList as $statusName => $statusValue)
                                <option value="{{ $statusValue }}" {{ $appointment->status === $statusValue ? 'selected' : ''}}>{{ $statusName }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            @if ($hasChangeStatus)
                                {{ $hasChangeStatus }}
                            @endif
                        </div>


                    </div>

                    <div class="col-md-12 my-3">
                        @if ($appointment->status == 1)
                            <label class="my-1 mr-2" >Available Rooms</label><br>
                            <div class="d-flex mt-2" style="justify-content: space-evenly;">
                                @foreach ($rooms as $roomKey => $room)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="room_id" id="room_{{ $room->id }}" value="{{ $room->id }}" {{ $roomKey == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="room_{{ $room->id }}">
                                            {{ $room->room_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            @if (count($rooms) == 0)
                                <p class="mt-0 pb-0">
                                    There is no available room.
                                </p>
                            @endif
                        @endif

                        @if ($roomError = Session::get('roomError'))
                            <div class="text-danger ">
                                {{ $roomError }}
                            </div>
                        @endif

                        @if ($appointment->status == 1 || $appointment->status == 2)
                            <button type="submit" class="btn btn-primary mt-5 w-100">Update Status</button>
                        @endif

                        <a  role="button" href="{{ route('admin.appointment.appointment-view') }}" class="btn btn-secondary mt-2 w-100 mb-0">Go to Today Appointment</a>
                    </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
</form>


@endsection
