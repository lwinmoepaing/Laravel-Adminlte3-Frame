<?php

namespace App\Http\Controllers\ClientView;

use App\Appointment;
use App\Branch;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientAppointmentRequest;
use App\Visitor;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();
        try {

            $appointment = new Appointment();
            $appointment->title = $validated['title'];
            $appointment->staff_name = $validated['staff_name'];
            $appointment->staff_email = $validated['staff_email'];
            $appointment->branch_id = $validated['branch'];
            $appointment->department_id = $validated['department'];
            $appointment->meeting_time = new DateTime($validated['date'] . ' ' . $validated['time']);
            $appointment->status = Appointment::$APPOINTMENT_STATUS_TYPE['PENDING'];
            $appointment->reason = '';
            $appointment->save();

            foreach ($validated['visitors'] as $item) {
                $visitor = new Visitor();
                $visitor->name = $item['name'] ;
                $visitor->phone = $item['phone'] ;
                $visitor->company_name = $item['company_name'] ;
                $visitor->email = $item['email'];
                $visitor->appointment_id = $appointment->id; // Get Appoint ID after inserted
                $visitor->save();
            }
            DB::commit();

        } catch (QueryException $e){
            DB::rollBack();
            return $e;
            return view('errors.something-went-wrong');
        }

        return $validated;
    }
}
