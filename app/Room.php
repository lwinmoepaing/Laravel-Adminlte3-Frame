<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // For Including Json ( For Accerrors)
    protected $appends = [
        'status_name'
    ];

    protected $fillable = [
        'room_name',
        'branch_id',
        'status',
        'seat_count',
        'area',
        'note'
    ];

    public static $APPOINTMENT_STATUS_TYPE = [
        "VACANT" => 1,
        "OCCUPIED" => 2,
        "RESERVED" => 3,
    ];

    // Custom Attributes For ACCESSORS
    public function getStatusNameAttribute() {
        return $this->status == 1 ? "Vacant" : ($this->status == 2 ? "Occupied" : "Reserved");
    }


    public function branch() {
        return $this->belongsTo(Branch::class);
    }
}

