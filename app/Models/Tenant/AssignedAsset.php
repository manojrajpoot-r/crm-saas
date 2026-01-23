<?php

namespace App\Models\Tenant;


use Illuminate\Database\Eloquent\Model;

class AssignedAsset extends BaseTenantModel
{
    protected $fillable = [
        'asset_id',
        'employee_id',
        'assigned_date',
        'return_date',
        'status'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getEmployeeNameAttribute()
    {
        return $this->employee
            ? $this->employee->first_name.' '.$this->employee->last_name
            : '-';
    }

    public function getAssetNameAttribute()
    {
        return $this->asset->name ?? '-';
    }

    public function getIsAssignedAttribute()
    {
        return $this->status == 1;
    }


    public static function rules($id = null)
    {
        return [
            'asset_id'      => 'required|exists:assets,id',
            'employee_id'   => 'required|exists:employees,id',
            'assigned_date' => 'required|date'
        ];
    }
}