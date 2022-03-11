<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Service\AppointmentService;

class Staff extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'department_id',
        'branch_id',
        'staff_role_id',
        'email',
        'phone',
        'secondary_phone',
        'deleted_at',
    ];

    protected $appends = [
        'type',
        'status_name',
    ];

    // All Accessors
    public function getTypeAttribute() {
        return "staff";
    }

    public function getStatusNameAttribute() {
        $appointmentService = new AppointmentService();

        if (isset($this->pivot->status)) {
            return $appointmentService->getAppointmentStatusName($this->pivot->status);
        }
        return '';
    }


    // All Relationships
    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function role() {
        return $this->belongsTo(StaffRole::class, 'staff_role_id');
    }

    public function appointments() {
        return $this
        ->morphToMany(Appointment::class, 'appointmentable')
        ->withPivot(['is_organizer', 'status', 'department_id', 'status_name'])
        ->withTimestamps();
    }
}
