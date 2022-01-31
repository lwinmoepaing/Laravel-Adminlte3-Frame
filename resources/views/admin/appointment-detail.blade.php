@extends('layouts.admin-layout')

@section('title', 'Appointment - ' . $appintment_id)

@section('content')

<div class="container main-wrapper">
    <div class="row">
        <div class="col-md-6 offset-md-3">
        <nav aria-label="breadcrumb mb-2">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="appointment.html">Appointments</a></li>
            <li class="breadcrumb-item active" aria-current="page"> {{ $appintment_id }} </li>
            </ol>
        </nav>

        <div class="card p-3">
            <div class="w-100 p-3">
            <div class="row">
                <div class="col-md-12">
                <span class="mb-3">Appointments ID -  {{ $appintment_id }} </span><br>
                <h5 class="my-2">
                    <b>API Integration</b>
                </h5>
                </div>
                <div class="col-md-12 my-3">
                <span>Client</span>
                <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>Aung Aung</h6>
                <span>09 782417621, Sein Gay Har, aungaung@gmail.com</span>
                </div>

                <div class="col-md-12 my-3">
                <span>uab officer</span>
                <h6 class="mt-2"><i class="fa fa-user mr-2" style="font-size: 16px;"></i>Zaw Zaw</h6>
                <span>Fintech &amp; Digital</span>
                </div>

                <div class="col-md-12 my-3">
                <span>Request Time</span>
                <h6 class="mt-2">
                    <i class="fa fa-calendar mr-2" style="font-size: 16px;"></i>04 Feb 2022   -    10:30 AM
                </h6>
                </div>

                <div class="col-md-12 my-3">

                <form class="form-flex">
                    <label class="my-1 mr-2" for="status">Appointment Status</label><br>
                    <select class="custom-select my-1 mr-sm-2" id="status">
                    <option value="pending">Pending</option>
                    <option value="occupied">Occupied</option>
                    <option value="finished">Finished</option>
                    </select>

                    <div class="d-flex my-2" style="justify-content: space-evenly;">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="room1" value="room1" checked="">
                        <label class="form-check-label" for="room1">
                        Room 1
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="room2" value="room2">
                        <label class="form-check-label" for="room2">
                        Room 2
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="room3" value="room3">
                        <label class="form-check-label" for="room3">
                        Room 3
                        </label>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-5 w-100">Update Status</button>
                    <a  role="button" href="{{ route('admin.appointment') }}" class="btn btn-outline-danger mt-2 w-100 mb-0">Cancel Appointment</a>
                </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection
