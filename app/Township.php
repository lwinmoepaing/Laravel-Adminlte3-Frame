<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    //
    public $timestamps = true;

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
