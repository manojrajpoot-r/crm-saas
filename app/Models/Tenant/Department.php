<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Department extends BaseTenantModel
{

    protected $fillable = [
        'name',
        'status',
        'is_deleted',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',
    ];



    public function designations()
    {
        return $this->hasMany(Designation::class, 'department_id');
    }
}
