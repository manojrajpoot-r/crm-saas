<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Designation extends BaseTenantModel
{
     protected $fillable = [
        'name',
        'department_id',
        'status',
        'is_deleted',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',

    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}