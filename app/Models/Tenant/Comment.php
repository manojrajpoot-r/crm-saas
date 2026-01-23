<?php
namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Comment extends BaseTenantModel
{
    protected $fillable = [
        'project_id',
        'uploaded_by',
        'comment'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(TenantUser::class, 'uploaded_by');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

}
