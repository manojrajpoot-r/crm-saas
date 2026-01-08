<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Role extends BaseTenantModel
{

    protected $fillable = ['tenant_id','name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }


    public static function rules($id = null)
    {
        return [
            'name' => 'required',
        ];
    }
}
