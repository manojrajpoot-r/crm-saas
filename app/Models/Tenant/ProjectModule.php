<?php
namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tenant\Task;

class ProjectModule extends BaseTenantModel
{
     use SoftDeletes;

    protected $fillable = [
        'title',
        'notes',
        'project_id',
        'start_date',
        'end_date',
        'created_by',
        'updated_by',
        'status'
    ];


    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'module_id');
    }

    public function creator()
    {
        return $this->belongsTo(TenantUser::class, 'created_by');
    }
}