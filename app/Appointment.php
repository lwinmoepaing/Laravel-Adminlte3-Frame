<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Appointment extends Model
{
    // For Including Json ( For Accerrors)
    protected $appends = [
        'status_name'
    ];

    //
    protected $fillable = [
        'title',
        'staff_name',
        'staff_email',
        'branch_id',
        'department_id',
        'meeting_time',
        'meeting_leave_time',
        'status',
        'reason',
        'description',
        'created_type',
        'room_id',
        'is_approve_by_officer',
        'is_cancel_by_officer',
    ];


    public static $APPOINTMENT_STATUS_TYPE = [
        "PENDING" => 1,
        "OCCUPIED" => 2, // Occupied or Arrived
        "REJECTED" => 3,
        "FINISHED" => 4,
        "EXPIRED" => 5,
    ];


    public static $APPOINTMENT_CREATE_TYPE = [
        "FROM_CLIENT" => 1,
        "FROM_RECIPIENT" => 2,
        "FROM_ADMIN" => 3,
    ];

    // Custom Attributes For ACCESSORS
       public function getStatusNameAttribute() {
        if ($this->status == $this::$APPOINTMENT_STATUS_TYPE['PENDING']) {
            return "Pending";
        }
        if ($this->status == $this::$APPOINTMENT_STATUS_TYPE['OCCUPIED']) {
            return "Occupied";
        }
        if ($this->status == $this::$APPOINTMENT_STATUS_TYPE['REJECTED']) {
            return "Rejected";
        }
        if ($this->status == $this::$APPOINTMENT_STATUS_TYPE['FINISHED']) {
            return "Finished";
        }
        if ($this->status == $this::$APPOINTMENT_STATUS_TYPE['EXPIRED']) {
            return "Expired";
        }

        return "Expired";
    }


    // Create Appoint Method
    public function creatAppointment($data, $status = 1, $created_type = 1)
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
            $appointment->status = $status;
            $appointment->staff_id = $data["staff_id"];
            $appointment->reason = '';
            $appointment->create_type = $created_type;
            $appointment->is_approve_by_officer = 0;
            $appointment->is_cancel_by_officer = 0;
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
            // dd($e->getMessage());
            return false;
        }
    }


    // All Relationships
    public function staff() {
        return $this->belongsTo(Staff::class);
    }

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

    public function visitor()
    {
        return $this->hasOne(Visitor::class)->oldest();
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
