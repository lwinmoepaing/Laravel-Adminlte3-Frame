@extends('layouts.admin-layout')

@section('content')

    <div class="container main-wrapper mt-2">

        <nav aria-label="breadcrumb" class="mx-auto max-w-600">
            <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route('admin.index') }}" role="button">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route('admin.rooms.index') }}" role="button">Room</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detail
            </li>
            </ol>
        </nav>

        <div class="card p-3 mt-3 mx-auto max-w-600">
            <div class="w-100 ">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <div> ID </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div> {{ $room->id }} </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <div> Name </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div> {{ $room->room_name }} </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <div> Current Status </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div> {{ $room->status_name }} </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <div> Branch </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div> {{ $room->branch->branch_name }} </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <div> Branch Address </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div> {{ $room->branch->branch_address }} </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <div> Seat Count </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div> {{ $room->seat_count ?? '-' }} </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <div> Area </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div> {{ $room->area ?? '-' }} </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <div> Note </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div> {{ $room->note ?? '-' }} </div>
                </div>
            </div>

            @isset($current_appointment)
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <div>
                        <a href="{{ route('admin.appointment.appointment-detail', ['appointment_id' => $current_appointment->id]) }}"> Go Current Appointment </a>
                    </div>
                </div>
            </div>
            @endisset
            <div class="row mb-2">
                <div class="col-sm-12">
                    <a href="{{ route('admin.rooms.room-edit', ['id' => $room->id ]) }}" role="button" type="button" class="btn btn-block btn-primary icon-btn-position mt-2"><i class="fa text-white fa-edit"></i> Edit Room </a>
                </div>
                <div class="col-sm-12">
                    <a href="{{ route('admin.rooms.index')}}" role="button" class="btn btn-secondary btn-block icon-btn-position mt-2"> Go to Room List </a>
                </div>
            </div>
            </div>
        </div>

    </div>

    <form id="remove-staff-form" action="{{route('admin.data.staff-remove', ['id' => '0'])}}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endsection




@push('body-scripts')
<script>
    $(document).ready(function () {
        $('.deleteStaff').click(function() {
            var url = '{{route('admin.data.staff-remove', ['id' => '0'])}}';
            var id = $(this).data('id');
            var isTrue = confirm('Are you sure to delete?');
            var form = $('#remove-staff-form');
            $(form).attr('action', url + id)
            if (isTrue) $(form).submit();
        });
    });
</script>
@endpush
