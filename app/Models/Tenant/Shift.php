<?php

namespace App\Models\Tenant;

class Shift extends BaseTenantModel
{
    protected $table = 'shifts';

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'grace_minutes',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'shift_id');
    }

    public function userShifts()
    {
        return $this->hasMany(UserShift::class);
    }

}
