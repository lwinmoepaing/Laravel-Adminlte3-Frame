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
use Illuminate\Http\Request;
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
        $staff = Staff::with(['branch'])->where('email', $validated['staff_email'])->first();
        $validated["is_request_from_client"] = 1;
        $validated["staff_id"] = $staff->id;

        $appModel = new Appointment();
        $appointment = $appModel->creatAppointment($validated);

        if (!$appointment) {
            return view('errors.something-went-wrong');
        }

        // Mail::to($appointment->staff_email)->send(new InviteAppointmentMail($appointment));

        return back()->with('success', 'Succesfully Created Your Appointment, We\'ll inform later.');
    }


    public function checkEmail(Request $request) {
        $validated = $request->validate([
            'email' => 'email|required'
        ]);

        $staff = Staff::where('email', $request->email)->first();

        if (!$staff) {
            return response()->json([
                'isSuccess' => false
            ]);
        }

        return response()->json([
            'isSuccess' => true,
            'data' => $staff,
        ]);
    }
}
