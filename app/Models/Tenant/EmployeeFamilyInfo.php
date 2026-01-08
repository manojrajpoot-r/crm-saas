<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class EmployeeFamilyInfo extends BaseTenantModel
{
    protected $table = 'employee_employee_family_infos';
    protected $fillable = [
        'employee_id',
        'name',
        'relation',
        'phone',
    ];
}
