<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class ProjectDocument extends BaseTenantModel
{

    protected $fillable = [
        'project_id',
        'file',
    ];

   public function project()
    {
        return $this->belongsTo(Project::class);
    }
}