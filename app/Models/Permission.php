<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
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



