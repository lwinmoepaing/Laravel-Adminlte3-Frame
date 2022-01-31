<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Appointment extends Model
{
    //
    protected $fillable = [
        'title',
        'staff_name',
        'staff_email',
        'branch_id',
        'department_id',
        'meeting_time',
        'status',
        'reason',
        'is_approve_by_officer',
        'is_cancel_by_officer',
        'is_request_from_client',
    ];


    public static $APPOINTMENT_STATUS_TYPE = [
        "PENDING" => 1,
        "ARRIVED" => 2,
        "REJECT" => 3,
        "FINISHED" => 4,
    ];


    public static $APPOINTMENT_CREATE_TYPE = [
        "FROM_CLIENT" => 1,
        "FROM_RECIPIENT" => 2,
    ];


    // Create Appoint Method
    public function creatAppointment($data)
    {
        DB::beginTransaction();
        try {
            $appointment = new Appointment();
            $appointment->title = $data['title'];
            $appointment->staff_name = $data['staff_name'];
            $appointment->staff_email = $data['staff_email'];
            $appointment->branch_id = $data['branch'];
            $appointment->department_id = $data['department'];
            $appointment->meeting_time = new DateTime($data['date'] . ' ' . $data['time']);
            $appointment->status = Appointment::$APPOINTMENT_STATUS_TYPE['PENDING'];
            $appointment->staff_id = $data["staff_id"];
            $appointment->is_request_from_client = $data["is_request_from_client"] ? $data["is_request_from_client"] : 0;
            $appointment->reason = '';
            $appointment->save();

            foreach ($data['visitors'] as $item) {
                $visitor = new Visitor();
                $visitor->name = $item['name'] ;
                $visitor->phone = $item['phone'] ;
                $visitor->company_name = $item['company_name'] ;
                $visitor->email = $item['email'];
                $visitor->appointment_id = $appointment->id; // Get Appoint ID after inserted
                $visitor->save();
            }
            DB::commit();
            return $appointment;
        } catch (QueryException $e){
            DB::rollBack();
            dd($e);
            return false;
        }
    }


    // All Relationships
    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
