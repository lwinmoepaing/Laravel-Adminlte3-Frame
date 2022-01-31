<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //

    public static $APPOINTMENT_STATUS_TYPE = [
        "VACANT" => 1,
        "OCCUPIED" => 2,
        "RESERVED" => 3,
    ];


}

