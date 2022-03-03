<?php

namespace App\Http\Controllers\ClientView;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ClientMobileController extends Controller
{
    //

    public function showDashboard() {
        return view('client.mobile-dashboard');
    }

    public function showAppointmentByStatus(Request $request, $status) {
        $statusList =  new Collection(['active', 'request', 'finished']);

        if (!$statusList->contains($status)) {
            return redirect()->back();
        }

        return view('client.mobile-appointments-by-status', [
            'status' => ucfirst($status),
        ]);
    }

    public function showAppointmentDetail($appointment_id) {

        $status = $appointment_id == 1 ? 'active' : 'pending';

        return view('client.mobile-appointment-detail', [
            'appointment_id' => $appointment_id,
            'status' =>  ucfirst($status),
        ]);
    }

    public function showSnoozeAppointment($appointment_id) {
        $status = $appointment_id == 1 ? 'active' : 'pending';

        return view('client.mobile-appointment-snooze', [
            'appointment_id' => $appointment_id,
            'status' =>  ucfirst($status),
        ]);
    }

    public function showJoinAppointment() {
        return view('client.mobile-join-appointment', []);
    }

    public function showMakeAppointment() {
        return view('client.mobile-make-appointment', []);
    }
}
