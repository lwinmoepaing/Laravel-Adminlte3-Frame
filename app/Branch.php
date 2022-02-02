<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    public $timestamps = true;

    protected $fillable = [
        'branch_name', 'branch_address', 'township_id'
    ];

    public function township()
    {
        return $this->belongsTo(Township::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
