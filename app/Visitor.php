<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    //
    protected $fillable = [
        'name',
        'phone',
        'company_name',
        'email',
    ];

    public function appointments() {
        return $this->morphToMany(Appointment::class, 'appointmentable')->withPivot(['is_organizer']);
    }
}
