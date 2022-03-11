<?php

namespace App;

use App\Service\AppointmentService;
use Illuminate\Database\Eloquent\Model;

class Appointmentable extends Model
{
    //

    protected $fillable = [
        'is_organizer',
        'status',
    ];


    public function getStatusNameAttribute() {
        $appointmentService = new AppointmentService();
        return $appointmentService->getAppointmentStatusName($this->status);
    }
}
