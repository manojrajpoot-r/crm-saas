<?php

namespace App\Models\Tenant;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class Report extends BaseTenantModel
{
    protected $fillable = [
        'user_id',
        'report_date',
        'admin_comment',
        'approved_by',
        'approved_at',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(TenantUser::class);
    }


    public function approvedByUser()
    {
        return $this->belongsTo(TenantUser::class, 'approved_by');
    }

    public function projects()
    {
        return $this->hasMany(ReportProject::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
