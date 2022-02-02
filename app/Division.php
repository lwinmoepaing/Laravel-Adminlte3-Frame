<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    //
    public $timestamps = true;

    protected $fillable = [
        'division_name',
    ];
}
