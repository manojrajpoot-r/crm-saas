<?php
namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tenant\Task;
use App\Traits\FormatsDates;
class ProjectModule extends BaseTenantModel
{
     use SoftDeletes;
     use FormatsDates;
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


    protected $appends = [
        'start_date_formatted',
        'end_date_formatted',
        'created_at_formatted',
    ];

public function getStartDateFormattedAttribute()
{
    return $this->start_date
        ? $this->formatDate($this->start_date)
        : '-';
}

public function getEndDateFormattedAttribute()
{
    return $this->end_date
        ? $this->formatDate($this->end_date)
        : '-';
}

public function getCreatedAtFormattedAttribute()
{
    return $this->created_at
        ? $this->formatDate($this->created_at)
        : '-';
}



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