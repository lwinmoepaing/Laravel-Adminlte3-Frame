@extends('layouts.admin-layout')

@section('title', 'Home Page')

@section('content')
    <a href="{{route('appointment.view')}}">Request Appointment</a>
@endsection
