<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Holiday extends BaseTenantModel
{
    protected $fillable = [
        'title',
        'date',
        'type',
        'is_optional',
        'description',
        'status'
    ];
}
