<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class OfficeLocation extends BaseTenantModel
{

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'allowed_radius',
    ];
}
