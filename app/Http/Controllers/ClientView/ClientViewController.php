<?php

namespace App\Http\Controllers\ClientView;

use App\Appointment;
use App\Branch;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientAppointmentRequest;
use App\Jobs\SendEmailQueueJob;
use App\Mail\InviteAppointmentMail;
use App\Staff;
use App\Visitor;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

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
        $validated["create_type"] = Appointment::$APPOINTMENT_CREATE_TYPE['FROM_CLIENT'];
        $validated["staff_id"] = $staff->id;
        $validated["staff_name"] = $staff->name;
        $validated["department"] = $staff->department_id;

        $appModel = new Appointment();
        $appointment = $appModel->creatAppointment($validated);

        if (!$appointment) {
            return back()->with('error', 'Something went wrong. Try Again');
        }

        $mailData = $this->makeEmailContent($appointment);
        Mail::to($appointment->staff_email)->queue(new InviteAppointmentMail($mailData));

        return back()->with('success', 'Succesfully Created Your Appointment, We\'ll inform later.');
    }


    public function checkStaffEmail(Request $request) {
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

    public function checkVisitor(Request $request) {
        $validated = $request->validate([
            'email' => 'string',
            'phone' => 'string',
        ]);

        if ($request->email) {
            $visitor = Visitor::where('email', $request->email)->latest()->first();
        } else {
            $visitor = Visitor::where('phone', $request->phone)->latest()->first();
        }

        if (!$visitor) {
            return response()->json([
                'isSuccess' => false
            ]);
        }

        return response()->json([
            'isSuccess' => true,
            'data' => $visitor,
        ]);
    }

    public function showConfirm() {
        return view('client.appointment-confirm');
    }


    public function makeEmailContent($appointment) {
        $dateStr = $appointment->meeting_time->format('F d Y H:i');
        $calendarFormat = Carbon::parse($appointment->meeting_time);
        // GMT+6:30
        $calendar = Calendar::create();

        $events = Event::create('Invitation: uab Meeting' . '<A' . str_pad($appointment->id, 6, '0', STR_PAD_LEFT) . '>')
                    ->startsAt(new DateTime($calendarFormat, new DateTimeZone('Asia/Rangoon')))
                    ->endsAt(new DateTime($calendarFormat->addHour(1), new DateTimeZone('Asia/Rangoon')))
                    ->address($appointment->branch->branch_name)
                    ->organizer('lwinmoepaing.dev@gmail.com', 'uab LwinMoePaing')
                    ->description($appointment->title . ' - ' . $appointment->visitors[0]->phone . ' <' . $appointment->visitors[0]->email . '> ');

        $ics = $calendar->event($events)->get();

        $extension = '.ics';
        $file = public_path() . '/calendars//' .'invite_' . $appointment->id;

        file_put_contents($file.$extension,
            mb_convert_encoding($ics , "UTF-8", "auto")
        );

        return [
            'title' => $appointment->title,
            'start_date' => $dateStr,
            'end_date' => $dateStr,
            'request_from' => $appointment->visitors[0]->name . ' (' . $appointment->visitors[0]->email . ')',
            'to_email' => $appointment->staff_email,
            'department' => $appointment->department->department_name,
            'address' => $appointment->branch->branch_address,
            'id' => $appointment->id,
            'file' => $file.$extension,
            'confirm_url' => route('appointment.client-confirm', ['appointment_id' => $appointment->id, 'is_confirmed' => 'true' ]),
            'reject_url' => route('appointment.client-confirm', ['appointment_id' => $appointment->id, 'is_confirmed' => 'false' ]),
        ];
    }
}
