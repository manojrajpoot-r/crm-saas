<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class EmployeePersonalInfo extends BaseTenantModel
{
    protected $table = 'employee_personal_infos';
     protected $fillable = [
        'employee_id','passport_no','passport_expiry',
        'identity_no','nationality','religion',
        'marital_status','spouse_name','children'
    ];
}
