<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

namespace App\Models\Tenant;

class ReportProject extends BaseTenantModel
{
    protected $fillable = [
        'report_id',
        'project_id',
        'description',
        'hours',

    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
