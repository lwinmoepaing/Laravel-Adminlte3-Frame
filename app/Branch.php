<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    public $timestamps = true;

    public function township()
    {
        return $this->belongsTo(Township::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
