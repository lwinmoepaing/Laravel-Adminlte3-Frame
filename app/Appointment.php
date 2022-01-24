<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    ];


    public static $APPOINTMENT_STATUS_TYPE = [
        "PENDING" => 1,
        "APPROVE" => 2,
        "REJECT" => 3,
    ];


    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }
}
