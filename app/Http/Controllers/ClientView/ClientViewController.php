<?php

namespace App\Http\Controllers\ClientView;

use App\Appointment;
use App\Branch;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientAppointmentRequest;
use App\Mail\InviteAppointmentMail;
use App\Staff;
use App\User;
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
        $staff = Staff::where('email', $validated['staff_email'])->first();
        if (!$staff) {
            return dd('Staff Not Found');
        }

        $validated["is_request_from_client"] = 1;
        $validated["staff_id"] = $staff->id;

        $appModel = new Appointment();
        $appointment = $appModel->creatAppointment($validated);

        if (!$appointment) {
            return view('errors.something-went-wrong');
        }

        Mail::to($appointment->staff_email)->send(new InviteAppointmentMail($appointment));

        return view('welcome');
    }
}
