<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Staff;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    // For Showing Dashboard Screen
    public function index() {
        return view('admin.dashboard', [
            'navTitle' => 'Dashboard'
        ]);
    }

    public function showAppointment() {
        return view('admin.appointment', [
            'navTitle' => 'Appointment'
        ]);
    }

    public function showAppointmentDetail($appointment_id) {
        return view('admin.appointment-detail', [
            'appointment_id' => $appointment_id,
            'navTitle' => 'Appointment - ' . $appointment_id
        ]);
    }

}
