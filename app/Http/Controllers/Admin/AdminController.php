<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function showRooms() {
        return view('admin.rooms', [
            'navTitle' => 'Rooms'
        ]);
    }

    public function showAppointmentDetail($appintment_id) {
        return view('admin.appointment-detail', [
            'appintment_id' => $appintment_id,
            'navTitle' => 'Appointment - ' . $appintment_id
        ]);
    }
}
