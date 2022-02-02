<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    //
    public $timestamps = true;

    protected $fillable = [
        'township_name', 'division_id'
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
