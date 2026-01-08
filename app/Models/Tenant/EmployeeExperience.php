<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class EmployeeExperience extends BaseTenantModel
{
    protected $table = 'employee_employee_experiences';
     protected $fillable = [
        'employee_id',
        'company_name',
        'designation',
        'from_date',
        'to_date',

    ];
}