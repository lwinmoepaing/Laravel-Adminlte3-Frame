<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function role() {
        return $this->belongsTo(StaffRole::class, 'staff_role_id');
    }
}
