<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
class Task extends BaseTenantModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'project_id',
        'module_id',
        'created_by',
        'assigned_by',
        'assigned_to',
        'assigned_at',
        'priority',
        'start_date',
        'end_date',
        'is_completed',
        'completed_at',
        'is_approved',
        'approved_at',
        'approved_by',
        'is_assigned',
        'status',
        'task_status',
        'started_at',
        'is_belong_to_post'
    ];

    public function scopeMyTasks($query)
    {
        return $query->where('assigned_to', Auth::id());
    }

    protected $appends = ['status_text','task_status_text'];

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            1 => 'Completed',
            2 => 'Created',
            3 => 'Declined',
            default => 'Unknown',
        };
    }

    public function getTaskStatusTextAttribute()
    {
        return match ($this->task_status) {
            0 => 'Pending',
            1 => 'Started',
            2 => 'Waiting Approval',
            3 => 'Approved',
            4 => 'Declined',
            default => 'Unknown',
        };
    }


     public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function module()
    {
        return $this->belongsTo(ProjectModule::class, 'module_id');
    }

    public function creator()
    {
        return $this->belongsTo(TenantUser::class, 'created_by');
    }

    public function assignee()
    {
        return $this->belongsTo(TenantUser::class, 'assigned_to');
    }

    public function assigner()
    {
        return $this->belongsTo(TenantUser::class, 'assigned_by');
    }

    public function approver()
    {
        return $this->belongsTo(TenantUser::class, 'approved_by');
    }

}
