<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Report extends BaseTenantModel
{
    protected $fillable = [
        'user_id',
        'project_id',
        'description',
        'report_date',
        'hours',
        'status',
        'admin_comment',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(TenantUser::class);
    }
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
