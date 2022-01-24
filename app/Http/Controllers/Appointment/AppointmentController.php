<?php

namespace App\Http\Controllers\Appointment;

use App\Appointment;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class AppointmentController extends Controller
{
    //

    public function checkConfirm(Request $request, Appointment $appointmentId)
    {
        $isConfirm = $request->query('is_confirmed') === 'true';
        $statusCode = 200;

        if ($appointmentId->status !== Appointment::$APPOINTMENT_STATUS_TYPE['PENDING']) {
            return response()->json(['message' => 'Already Confirm This Appointment', 'statusCode' => 200]);
        }

        if (!$isConfirm) {
            $appointmentId->status = Appointment::$APPOINTMENT_STATUS_TYPE['REJECT'];
            $appointmentId->save();
            return response()->json(['message' => 'Successfully Rejeced this Appointment', 'statusCode' => 200]);
        }

        $appointmentId->status = Appointment::$APPOINTMENT_STATUS_TYPE['APPROVE'];
        $appointmentId->save();
        return response()->json(['message' => 'Successfully Approve this Appointment', 'statusCode' => 200]);
    }
}
