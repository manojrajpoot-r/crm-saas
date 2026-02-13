<?php

namespace App\Models\Tenant;

class Attendance extends BaseTenantModel
{
    protected $table = 'attendances';

    protected $fillable = [
        'user_id',
        'shift_id',
        'date',
        'check_in',
        'check_out',
        'late_mark',
        'overtime_hours',
        'latitude',
        'longitude',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime:H:i:s',
        'check_out' => 'datetime:H:i:s',
        'late_mark' => 'boolean',
        'overtime_hours' => 'float',
    ];


    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }


    public function user()
    {
        return $this->belongsTo(TenantUser::class, 'user_id');
    }
}