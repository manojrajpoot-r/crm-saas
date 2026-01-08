<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class EmployeeBankInfo extends BaseTenantModel
{
    protected $table = 'employee_employee_bank_infos';
        protected $fillable = [
            'employee_id',
            'account_name',
            'bank_name',
            'account_no',
            'ifsc',
            'pan_no',
            'uan_no',
        ];
}
