<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;


class Asset extends BaseTenantModel
{
    protected $fillable = ['name', 'code', 'type', 'status'];

    public function assignments()
    {
        return $this->hasMany(AssignedAsset::class);
    }

    public static function rules($id = null)
    {
        return [
            'name' => 'required',
            'code' => 'required|unique:tenant.assets,code,' . $id,
            'type' => 'required',
        ];
    }
}
