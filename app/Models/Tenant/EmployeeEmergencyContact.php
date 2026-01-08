<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class EmployeeEmergencyContact extends BaseTenantModel
{
    protected $table = 'employee_emergency_contacts';
    protected $fillable = [
        'employee_id',
        'name',
        'relation',
        'phone',
        'address',
    ];
}
