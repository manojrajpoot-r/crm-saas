<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Permission extends BaseTenantModel
{

    protected $fillable = ['id','name','group','status'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }


    public static function rules($id = null)
    {
        return [
            'name' => 'required',
            'group' => 'required'
        ];
    }
}



