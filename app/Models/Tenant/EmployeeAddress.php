<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends BaseTenantModel
{

    protected $fillable = [
        'employee_id',

        'present_address',
        'present_landmark',
        'present_zipcode',
        'present_country',
        'present_state',
        'present_city',

        'permanent_address',
        'permanent_landmark',
        'permanent_zipcode',
        'permanent_country',
        'permanent_state',
        'permanent_city',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }



}
