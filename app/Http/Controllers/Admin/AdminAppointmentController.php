<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminAppointmentController extends Controller
{
    //

    // $from = date('2018-01-01');
    // $to = date('2018-05-02');
    // Reservation::whereBetween('reservation_from', [$from, $to])->get();
    // start of day in date (2021-01-01 00:00:00)
    // Carbon::now()->startOfDay()
    // // start of day in timestamp (1609459200)
    // Carbon::now()->startOfDay()->timestamp
    // // end of day in date (2021-01-01 23:59:59)
    // Carbon::now()->endOfDay()
    // // end of day in timestamp (1609545599)
    // Carbon::now()->endOfDay()->timestamp

    public function showDashboard(Request $request) {
        $startOfDay = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $endOfDay = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

        $pendingStatus = Appointment::$APPOINTMENT_STATUS_TYPE['PENDING'];
        $expiredStatus = Appointment::$APPOINTMENT_STATUS_TYPE['EXPIRED'];
        $arrivedStatus = Appointment::$APPOINTMENT_STATUS_TYPE['ARRIVED'];

        $todayRequestAppointmentCount = Appointment::where('status', $pendingStatus)
            ->whereBetween('meeting_time', [$startOfDay, $endOfDay])
            ->count();

        $upcommingAppointmentCount = Appointment::where('status', $pendingStatus)
            ->where('meeting_time', '>', $endOfDay)
            ->count();

        $occupiedAppointmentCount = Appointment::where('status', $arrivedStatus)
            ->whereBetween('meeting_time', [$startOfDay, $endOfDay])
            ->count();

        // If Expired Meeting We'll Set Expired Appointment
        $expiredAppointmentCount = Appointment::where('status', $pendingStatus)->where('meeting_time', '<', $startOfDay)->count();
        if ($expiredAppointmentCount >= 1) {
            Appointment::where('status', $pendingStatus)->where('meeting_time', '<', $startOfDay)->update(['status' => $expiredStatus]);
        }

        $todayAppointments = Appointment::where('status', $pendingStatus)
            ->with(['staff.department', 'branch', 'visitor'])
            ->whereBetween('meeting_time', [$startOfDay, $endOfDay])
            ->get();

        $responseData = [
            'todayRequestAppointmentCount' => $todayRequestAppointmentCount,
            'upcommingAppointmentCount' => $upcommingAppointmentCount,
            'expiredAppointmentCount' => $expiredAppointmentCount,
            'occupiedAppointmentCount' => $occupiedAppointmentCount,
            'todayAppointments' => $todayAppointments,
        ];

        // return response()->json($responseData);

        return view('admin.dashboard', $responseData);
    }
}
