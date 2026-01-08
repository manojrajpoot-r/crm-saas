<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class EmployeeUpiInfo extends BaseTenantModel
{

    protected $table = 'employee_upi_infos';
    protected $fillable = [
        'employee_id',
        'upi_id',
        'upi_app',
        'is_primary',
        'status',
    ];

}