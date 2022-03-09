<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentHistory extends Model
{
    //

    protected $fillable = [
        'appointment_id',
        'message',
        'appointment_history_type',
        'history_data',
    ];


    public $HistoryTypes = [
        'CREATE_APPOINTMENT',
        'UPDATE_APPOINTMENT',
        'UPDATE_APPOINTMENT_ATTENDANCE',
        'CHANGE_APPOINTMENT_STATUS',
        'CANCEL_APPOINTMENT'
    ];
}
