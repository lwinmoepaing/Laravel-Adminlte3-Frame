<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'department_name',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }
}
