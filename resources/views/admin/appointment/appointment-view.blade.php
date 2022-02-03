@extends('layouts.admin-layout')

@section('content')

<div class="container-fluid border-bottom bg-white height-57">
    <div class="d-flex main-wrapper mt-0 px-0" style="justify-content: space-between;;">
      <ul class="nav nav-tabs my-navtabs" id="myTab" role="tablist" style="border-bottom: o !important;">
        <li class="nav-item">
            <a class="nav-link height-57 text-flex-center {{ (!$showTab || $showTab == 'request') ? 'active' : '' }}" id="home-tab" data-toggle="tab" href="#request" role="tab" aria-controls="request" aria-selected="true">
                Request

                @if ($todayRequestAppointmentCount)
                    <span class="ml-2 py-1 px-2 badge badge-warning">{{ $todayRequestAppointmentCount }}</span>
                @endif

            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link height-57 text-flex-center {{ ($showTab == 'upcoming') ? 'active' : '' }}" id="upcoming-tab" data-toggle="tab" href="#upcoming" role="tab" aria-controls="upcoming" aria-selected="false">
                Upcoming
                @if ($upcommingAppointmentCount)
                    <span class="ml-2 py-1 px-2 badge badge-primary">{{ $upcommingAppointmentCount }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link height-57 text-flex-center {{ ($showTab == 'occupied') ? 'active' : '' }}" id="occupied-tab" data-toggle="tab" href="#occupied" role="tab" aria-controls="occupied" aria-selected="false">
                Occupied
                @if ($occupiedAppointmentCount)
                    <span class="ml-2 py-1 px-2 badge badge-success">{{ $occupiedAppointmentCount }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link height-57 text-flex-center {{ ($showTab == 'finished') ? 'active' : '' }}" id="finished-tab" data-toggle="tab" href="#finished" role="tab" aria-controls="finished" aria-selected="false">
                Finished
                @if ($finishedAppointmentCount)
                    <span class="ml-2 py-1 px-2 badge badge-info text-white">{{ $finishedAppointmentCount }}</span>
                @endif
            </a>
        </li>
      </ul>

      <a class="btn btn-primary btn-sm text-white custom-appointment-btn " href="{{ route('admin.appointment.appointment-create') }}">Create Appointment</a>
    </div>
  </div>

  <div class="px-3 d-block d-lg-none">
    <a class="btn btn-primary btn-block my-3 btn-sm text-white " href="{{ route('admin.appointment.appointment-create') }}">Create Appointment</a>
  </div>

  <div class="container main-wrapper mt-0">
    <div class="row">
      <div class="col-12">
        <div class="tab-content" id="myTabContent">

          <div class="tab-pane fade {{ (!$showTab || $showTab == 'request') ? 'show active' : ''  }}" id="request" role="tabpanel" aria-labelledby="request-tab">
            <div class="row my-3">
                @foreach ( $todayRequestAppointments as $appointment)
                    <div class="col-md-6 mb-2">
                        <a class="card upcoming-section p-3" href="{{ route('admin.appointment.appointment-detail', ["appointment_id" => $appointment->id]) }}">
                        <div class="text-center min-w-85 appointment-time">
                            <span class="d-block border p-3 rounded">

                                <b>
                                    {{ date('g : i', strtotime($appointment->meeting_time)) }}
                                </b>
                                <br>
                                {{ date('A', strtotime($appointment->meeting_time)) }}

                            </span>
                        </div>
                        <div class="w-100 ml-3">
                            <div class="row">
                            <div class="col-md-12">
                                <h5 class="my-2">
                                <b>{{ $appointment->title ?? '-' }}</b>
                                <div class="badge badge-secondary float-right">{{ $appointment->status_name }}</div>
                                </h5>
                            </div>
                            <div class="col-md-12 my-3">
                                <span>Client</span>
                                <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>{{ $appointment->visitor->name }}</h6>
                                <span>
                                    {{ $appointment->visitor->phone }},
                                    {{ $appointment->visitor->company_name }},
                                    {{ $appointment->visitor->email }}
                                </span>
                            </div>

                            <div class="col-md-12 my-3">
                                <span>uab officer</span>
                                <h6 class="mt-2">
                                    <i class="fa fa-user mr-2" style="font-size: 16px;"></i>
                                    {{ $appointment->staff->name }}
                                </h6>
                                <span>
                                    {{ $appointment->staff->department->id != 1 ? $appointment->staff->department->department_name : '' }}
                                </span>
                            </div>

                            <div class="col-md-12 my-3">
                                <span>Request Time</span>
                                <h6 class="mt-2">
                                    <i class="fa fa-calendar mr-2" style="font-size: 16px;"></i>
                                    {{ date('d M Y - g : i A', strtotime($appointment->meeting_time)) }}
                                </h6>
                            </div>
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
          </div>


          <div class="tab-pane fade {{ ($showTab == 'upcoming') ? 'show active' : ''  }}" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            <div class="row my-3">
                @foreach ( $todayUpcomingAppointments as $appointment)
                    <div class="col-md-6 mb-2">
                        <a class="card upcoming-section p-3" href="{{ route('admin.appointment.appointment-detail', ["appointment_id" => $appointment->id]) }}">
                        <div class="text-center min-w-85 appointment-time">
                            <span class="d-block border p-3 rounded">

                                <b>
                                    {{ date('g : i', strtotime($appointment->meeting_time)) }}
                                </b>
                                <br>
                                {{ date('A', strtotime($appointment->meeting_time)) }}

                            </span>
                        </div>
                        <div class="w-100 ml-3">
                            <div class="row">
                            <div class="col-md-12">
                                <h5 class="my-2">
                                <b>{{ $appointment->title ?? '-' }}</b>
                                {{-- <div class="badge badge-secondary float-right">{{ $appointment->status_name }}</div> --}}
                                </h5>
                            </div>
                            <div class="col-md-12 my-3">
                                <span>Client</span>
                                <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>{{ $appointment->visitor->name }}</h6>
                                <span>
                                    {{ $appointment->visitor->phone }},
                                    {{ $appointment->visitor->company_name }},
                                    {{ $appointment->visitor->email }}
                                </span>
                            </div>

                            <div class="col-md-12 my-3">
                                <span>uab officer</span>
                                <h6 class="mt-2">
                                    <i class="fa fa-user mr-2" style="font-size: 16px;"></i>
                                    {{ $appointment->staff->name }}
                                </h6>
                                <span>
                                    {{ $appointment->staff->department->id != 1 ? $appointment->staff->department->department_name : '' }}
                                </span>
                            </div>

                            <div class="col-md-12 my-3">
                                <span>Request Time</span>
                                <h6 class="mt-2">
                                    <i class="fa fa-calendar mr-2" style="font-size: 16px;"></i>
                                    {{ date('d M Y - g : i A', strtotime($appointment->meeting_time)) }}
                                </h6>
                            </div>
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
          </div>
          <!-- end upcoming -->


          <!-- occupied -->
          <div class="tab-pane fade {{ ($showTab == 'occupied') ? 'show active' : ''  }}" id="occupied" role="tabpanel" aria-labelledby="occupied-tab">
            <div class="row my-3">
                @foreach ( $todayOccupiedAppointments as $appointment)
                    <div class="col-md-6 mb-2">
                        <a class="card upcoming-section p-3" href="{{ route('admin.appointment.appointment-detail', ["appointment_id" => $appointment->id]) }}">
                        <div class="text-center min-w-85 appointment-time">
                            <span class="d-block border p-3 rounded">

                                <b>
                                    {{ date('g : i', strtotime($appointment->meeting_time)) }}
                                </b>
                                <br>
                                {{ date('A', strtotime($appointment->meeting_time)) }}

                            </span>

                            <div class="mt-2 d-block py-2 badge badge-primary">
                                {{ $appointment->room->room_name ?? ''}}
                            </div>
                        </div>
                        <div class="w-100 ml-3">
                            <div class="row">
                            <div class="col-md-12">
                                <h5 class="my-2">
                                <b>{{ $appointment->title ?? '-' }}</b>
                                <div class="badge badge-secondary float-right">{{ $appointment->status_name }}</div>
                                </h5>
                            </div>
                            <div class="col-md-12 my-3">
                                <span>Client</span>
                                <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>{{ $appointment->visitor->name }}</h6>
                                <span>
                                    {{ $appointment->visitor->phone }},
                                    {{ $appointment->visitor->company_name }},
                                    {{ $appointment->visitor->email }}
                                </span>
                            </div>

                            <div class="col-md-12 my-3">
                                <span>uab officer</span>
                                <h6 class="mt-2">
                                    <i class="fa fa-user mr-2" style="font-size: 16px;"></i>
                                    {{ $appointment->staff->name }}
                                </h6>
                                <span>
                                    {{ $appointment->staff->department->id != 1 ? $appointment->staff->department->department_name : '' }}
                                </span>
                            </div>

                            <div class="col-md-12 my-3">
                                <span>Request Time</span>
                                <h6 class="mt-2">
                                    <i class="fa fa-calendar mr-2" style="font-size: 16px;"></i>
                                    {{ date('d M Y - g : i A', strtotime($appointment->meeting_time)) }}
                                </h6>
                            </div>
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
          </div>
          <!-- end occupied -->

          <!-- finished -->
          <div class="tab-pane fade {{ ($showTab == 'finished') ? 'show active' : ''  }}" id="finished" role="tabpanel" aria-labelledby="finished-tab">
            <div class="row my-3">
                @foreach ( $finishedAppointments as $appointment)
                    <div class="col-md-6 mb-2">
                        <a class="card upcoming-section p-3" href="{{ route('admin.appointment.appointment-detail', ["appointment_id" => $appointment->id]) }}">
                        <div class="text-center min-w-85 appointment-time">
                            <span class="d-block border p-3 rounded">

                                <b>
                                    {{ date('g : i', strtotime($appointment->meeting_time)) }}
                                </b>
                                <br>
                                {{ date('A', strtotime($appointment->meeting_time)) }}
                            </span>

                            <div class="my-2 d-block py-2 badge badge-primary">
                                {{ $appointment->room->room_name ?? '-'}}
                            </div>

                            <span class="d-block border p-3 rounded">
                                <b>
                                    {{ date('g : i', strtotime($appointment->meeting_leave_time)) }}
                                </b>
                                <br>
                                {{ date('A', strtotime($appointment->meeting_leave_time)) }}
                            </span>

                        </div>
                        <div class="w-100 ml-3">
                            <div class="row">
                            <div class="col-md-12">
                                <h5 class="my-2">
                                <b>{{ $appointment->title ?? '-' }}</b>
                                <div class="badge badge-secondary float-right">{{ $appointment->status_name }}</div>
                                </h5>
                            </div>
                            <div class="col-md-12 my-3">
                                <span>Client</span>
                                <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>{{ $appointment->visitor->name }}</h6>
                                <span>
                                    {{ $appointment->visitor->phone }},
                                    {{ $appointment->visitor->company_name }},
                                    {{ $appointment->visitor->email }}
                                </span>
                            </div>

                            <div class="col-md-12 my-3">
                                <span>uab officer</span>
                                <h6 class="mt-2">
                                    <i class="fa fa-user mr-2" style="font-size: 16px;"></i>
                                    {{ $appointment->staff->name }}
                                </h6>
                                <span>
                                    {{ $appointment->staff->department->id != 1 ? $appointment->staff->department->department_name : '' }}
                                </span>
                            </div>

                            <div class="col-md-12 my-3">
                                <span>Request Time</span>
                                <h6 class="mt-2">
                                    <i class="fa fa-calendar mr-2" style="font-size: 16px;"></i>
                                    {{ date('d M Y - g : i A', strtotime($appointment->meeting_time)) }}
                                </h6>
                            </div>
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
          </div>
          <!-- end finished -->
        </div>
      </div>
    </div>
  </div>
@endsection
