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

        return view('invitation-email', [
            'title' => $appointment->title,
            'start_date' => $appointment->meeting_time->format('Y-m-d'),
            'request_from' => $appointment->visitors[0]->name . ' (' .$appointment->visitors[0]->email . ')',
            'to_email' => $appointment->staff_email,
            'department' => $appointment->department->department_name,
            'address' => $appointment->branch->branch_address,
            'id' => $appointment->id,
        ]);
    }
}
