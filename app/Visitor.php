<?php

namespace App;
use App\Service\AppointmentService;
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

    protected $appends = [
        'type',
        'status_name',
    ];

    // All Accessors
    public function getTypeAttribute() {
        return "visitor";
    }

    public function getStatusNameAttribute() {
        $appointmentService = new AppointmentService();
        if (isset($this->pivot->status)) {
            return $appointmentService->getAppointmentStatusName($this->pivot->status);
        }
        return '';
    }


    // All Relationshiop
    public function appointments() {
        return $this
            ->morphToMany(Appointment::class, 'appointmentable')
            ->withPivot(['is_organizer', 'status', 'status_name'])
            ->withTimestamps();
    }

}
