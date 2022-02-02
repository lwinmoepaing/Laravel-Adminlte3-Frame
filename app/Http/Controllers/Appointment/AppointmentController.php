<?php

namespace App\Http\Controllers\Appointment;

use App\Appointment;
use App\Http\Controllers\Controller;
use App\Mail\AcceptInvitationMail;
use App\Mail\RejectInvitationMail;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use function PHPSTORM_META\type;

class AppointmentController extends Controller
{
    //

    public function confirmFromClient(Request $request, Appointment $appointmentId)
    {
        $isConfirm = $request->query('is_confirmed') === 'true';

        if ($appointmentId->is_approve_by_officer !== 0) {
            return response()->json(['message' => 'Already Confirm This Appointment', 'statusCode' => 200]);
        }

        if (!$isConfirm) {
            $appointmentId->status = Appointment::$APPOINTMENT_STATUS_TYPE['REJECT'];
            $appointmentId->is_cancel_by_officer = 1;
            $appointmentId->save();

            foreach ($appointmentId->visitors as $key => $visitor) {
                // Mail::to($visitor->email)->send(new RejectInvitationMail($appointmentId));
            }

            return response()->json(['message' => 'Successfully Rejeced this Appointment', 'statusCode' => 200]);
        }

        $appointmentId->is_approve_by_officer = 1;
        $appointmentId->save();
        foreach ($appointmentId->visitors as $key => $visitor) {
            // Mail::to($visitor->email)->send(new AcceptInvitationMail($appointmentId));
        }
        return response()->json(['message' => 'Successfully Approve this Appointment', 'statusCode' => 200]);
    }
}
