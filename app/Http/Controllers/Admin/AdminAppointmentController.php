<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminAppointmentController extends Controller
{

    public function showDashboard(Request $request) {
        $startOfDay = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $endOfDay = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

        $pendingStatus = Appointment::$APPOINTMENT_STATUS_TYPE['PENDING'];
        $expiredStatus = Appointment::$APPOINTMENT_STATUS_TYPE['EXPIRED'];
        $arrivedStatus = Appointment::$APPOINTMENT_STATUS_TYPE['OCCUPIED'];

        $todayRequestAppointmentCount = Appointment::where('status', $pendingStatus)
            ->whereBetween('meeting_time', [$startOfDay, $endOfDay])
            ->where('is_approve_by_officer', 0)
            ->count();

        $upcommingAppointmentCount = Appointment::where('status', $pendingStatus)
            ->whereBetween('meeting_time', [$startOfDay, $endOfDay])
            ->where('is_approve_by_officer', 1)
            ->count();

        $occupiedAppointmentCount = Appointment::where('status', $arrivedStatus)
            ->whereBetween('meeting_time', [$startOfDay, $endOfDay])
            ->count();

        // If Expired Meeting We'll Set Expired Appointment
        $expiredAppointmentCount = Appointment::where('status', $pendingStatus)->where('meeting_time', '<', $startOfDay)->count();
        if ($expiredAppointmentCount >= 1) {
            Appointment::where('status', $pendingStatus)->where('meeting_time', '<', $startOfDay)->update(['status' => $expiredStatus]);
        }

        $todayUpcomingAppointments = Appointment::where('status', $pendingStatus)
            ->with(['staff.department', 'branch', 'visitor'])
            ->whereBetween('meeting_time', [$startOfDay, $endOfDay])
            ->where('is_approve_by_officer', 1)
            ->orderBy('id', 'DESC')
            ->get();

        $responseData = [
            'todayRequestAppointmentCount' => $todayRequestAppointmentCount,
            'upcommingAppointmentCount' => $upcommingAppointmentCount,
            'expiredAppointmentCount' => $expiredAppointmentCount,
            'occupiedAppointmentCount' => $occupiedAppointmentCount,
            'todayUpcomingAppointments' => $todayUpcomingAppointments,
        ];

        // return response()->json($responseData);

        return view('admin.dashboard', $responseData);
    }

    public function showAppointment(Request $request) {
        $startOfDay = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $endOfDay = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

        $pendingStatus = Appointment::$APPOINTMENT_STATUS_TYPE['PENDING'];
        $expiredStatus = Appointment::$APPOINTMENT_STATUS_TYPE['EXPIRED'];
        $arrivedStatus = Appointment::$APPOINTMENT_STATUS_TYPE['OCCUPIED'];


        $branchQuery = Appointment::where('status', $pendingStatus)
            ->whereBetween('meeting_time', [$startOfDay, $endOfDay])
            ->where('is_approve_by_officer', 1)
            ->get();
        if ($branchQuery) {
            $branchQuery->where('email', $branchQuery);
        }
    }
}
