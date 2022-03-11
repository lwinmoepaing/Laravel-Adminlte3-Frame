<?php

namespace App;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Appointment extends Model
{
    // For Including Json ( For Accerrors)
    protected $appends = [
        'status_name',
        'create_type_name',
        'meeting_date',
        'meeting_timer',
        'request_time',
    ];

    //
    protected $fillable = [
        'title',
        'staff_name',
        'staff_email',
        'branch_id',
        'department_id',
        'request_meeting_time',
        'meeting_leave_time',
        'meeting_start_time',
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

    public static $USER_STATUS = [
        "REQUEST" => 1,
        "GOING" => 2,
        "CANTGO" => 3,
    ];


    public static $APPOINTMENT_CREATE_TYPE = [
        "FROM_CLIENT" => 1,
        "FROM_RECIPIENT" => 2,
        "FROM_OFFICER" => 3,
        "FROM_ADMIN" => 4,
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

    public function getCreateTypeNameAttribute() {
        if ($this->create_type == $this::$APPOINTMENT_CREATE_TYPE['FROM_CLIENT']) {
            return "Visitor";
        }

        if ($this->create_type == $this::$APPOINTMENT_CREATE_TYPE['FROM_RECIPIENT']) {
            return "Staff";
        }

        if ($this->create_type == $this::$APPOINTMENT_CREATE_TYPE['FROM_OFFICER']) {
            return "Officer";
        }

        return "Unknown";
    }

    public function getMeetingDateAttribute() {
        return Carbon::parse($this->meeting_request_time)->format('m/d/Y');
    }

    public function getMeetingTimerAttribute() {
        return Carbon::parse($this->meeting_request_time)->format('g:i A');
    }

    public function getRequestTimeAttribute() {
        return Carbon::parse($this->meeting_request_time)->format('d M Y - g : i A');
    }


    // Create Appoint Method
    public function creatAppointment($data, $status = 1, $created_type = 1)
    {
        DB::beginTransaction();
        try {
            $appointment = new Appointment();
            $appointment->title = $data['title'];
            $appointment->organizer_name = $data['organizer_name'];
            $appointment->readable_id = $data['organizer_name'];
            $appointment->branch_id = $data['branch'];
            $appointment->department_id = $data['department'];
            $appointment->meeting_request_time = new DateTime($data['date'] . ' ' . $data['time']);
            $appointment->status = $status; // Status 1 Pending Appointment
            $appointment->create_type = $created_type;
            $appointment->save();

            // foreach ($data['visitors'] as $item) {
            //     $visitor = new Visitor();
            //     $visitor->name = $item['name'] ;
            //     $visitor->phone = $item['phone'] ;
            //     $visitor->company_name = $item['company_name'] ;
            //     $visitor->email = $item['email'];
            //     $visitor->appointment_id = $appointment->id; // Get Appoint ID after inserted
            //     $visitor->save();
            // }

            DB::commit();
            return $appointment;
        } catch (QueryException $e){
            DB::rollBack();
            // dd($e->getMessage());
            return false;
        }
    }

    // All Relationships
    public function staffs()
    {
        return $this->morphedByMany(Staff::class, 'appointmentable')->withPivot(['is_organizer', 'status']);
    }

    public function visitors()
    {
        return $this->morphedByMany(Visitor::class, 'appointmentable')->withPivot(['is_organizer', 'status']);
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
