<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    //
    protected $fillable = [
        'appointment_id',
        'name',
        'phone',
        'company_name',
        'email',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
