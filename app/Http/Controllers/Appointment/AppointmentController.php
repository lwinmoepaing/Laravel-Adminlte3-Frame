<?php

namespace App\Http\Controllers\Appointment;

use App\Appointment;
use App\Http\Controllers\Controller;
use App\Mail\AcceptInvitationMail;
use App\Mail\RejectInvitationMail;
use App\Service\AppointmentService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use function PHPSTORM_META\type;

class AppointmentController extends Controller
{
    //

    public function __construct()
    {
        $this->appointmentService = new AppointmentService();
    }

    public function confirmFromClient(Request $request, Appointment $appointmentId)
    {
        $isConfirm = $request->query('is_confirmed') === 'true';

        if ($appointmentId->is_approve_by_officer !== 0) {
            return redirect()->route('appointment.confirm-view')->with('success', 'Already Confirm This Appointment');
        }

        if (!$isConfirm) {
            $appointmentId->status = Appointment::$APPOINTMENT_STATUS_TYPE['REJECTED'];
            $appointmentId->is_cancel_by_officer = 1;
            $appointmentId->save();

            foreach ($appointmentId->visitors as $key => $visitor) {
                Mail::to($visitor->email)->queue(new RejectInvitationMail([
                        'title' => $appointmentId->title,
                        'id' => $appointmentId->id,
                ]));
            }

            return redirect()->route('appointment.confirm-view')->with('success', 'Successfully Rejeced this Appointment');
        }

        $appointmentId->is_approve_by_officer = 1;
        $appointmentId->save();
        foreach ($appointmentId->visitors as $key => $visitor) {
            Mail::to($visitor->email)->queue(new AcceptInvitationMail($appointmentId));
        }
        // return response()->json(['message' => 'Successfully Approve this Appointment', 'statusCode' => 200]);
        return redirect()->route('appointment.confirm-view')->with('success', 'Successfully Approve this Appointment');
    }
}
