<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducation extends BaseTenantModel
{
    protected $table = 'employee_employee_educations';
    protected $fillable = [
        'employee_id',
        'institute',
        'degree',
        'stream',
        'from_date',
        'to_date',

    ];
}