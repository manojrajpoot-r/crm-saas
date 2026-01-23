<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends BaseTenantModel
{

    protected $fillable = ['name','color','max_days','is_paid','allow_half','allow_short','status','code'];
}