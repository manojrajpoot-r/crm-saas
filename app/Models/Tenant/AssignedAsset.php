<?php

namespace App\Models\Tenant;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class AssignedAsset extends BaseTenantModel
{
    protected $fillable = [
        'asset_id',
        'user_id',
        'assigned_date',
        'return_date',
        'status'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(TenantUser::class);
    }


 public static function rules($id = null)
{
    return [
        'asset_id' => 'required',
        'user_id' => 'required',
        'assigned_date' => 'required|date'
    ];
}


}