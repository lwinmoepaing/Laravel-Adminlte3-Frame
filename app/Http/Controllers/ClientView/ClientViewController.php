<?php

namespace App\Http\Controllers\ClientView;

use App\Appointment;
use App\Branch;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientAppointmentRequest;
use App\Mail\InviteAppointmentMail;
use Illuminate\Support\Facades\Mail;

class ClientViewController extends Controller
{
    //

    public function index() {
        $branches = Branch::with('township')->get();
        $departments = Department::all();

        return view('client.appointment-request', [
            'branches' => $branches,
            'departments' => $departments
        ]);
    }


    public function appointSubmit(ClientAppointmentRequest $request) {

        $validated = $request->validated();
        $appModel = new Appointment();
        $appointment = $appModel->creatAppointment($validated);

        if (!$appointment) {
            return view('errors.something-went-wrong');
        }

        Mail::to($appointment->staff_email)->send(new InviteAppointmentMail($appointment));

        return view('welcome');
    }
}
