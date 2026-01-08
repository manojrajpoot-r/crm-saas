<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Report extends BaseTenantModel
{

    protected $fillable = [
        'employee_id',
        'title',
        'description',
        'report_date',

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
