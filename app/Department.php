<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }
}
