<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UniversalCrud;
class Project extends BaseTenantModel
{
     use UniversalCrud;
      protected $fillable = [
        'name',
        'type',
        'description',
        'start_date',
        'end_date',
        'actual_start_date',
        'total_days',
        'completion_percent',
        'hours_allocated',
        'created_by',
        'archived_by',
        'completed_by',
        'status',
        'remarks',
        'is_finished',
        'is_archived'
    ];

    protected $casts = [
        'created_by' => 'array',
        'archived_by' => 'array',
        'completed_by' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'actual_start_date' => 'date',
        'finished_date' => 'date',
        'archived_date' => 'date',
        'is_finished' => 'boolean',
        'is_archived' => 'boolean',
    ];

    public function getDatesColumnAttribute()
    {
        $actual = $this->actual_start_date
            ? 'Actual Start: ' . $this->formatDate($this->actual_start_date)
            : '';

        $created = 'Created At: ' . $this->formatDate($this->created_at);

        $endDate =  $this->formatDate($this->end_date);



        return trim($actual . '<br>' . $created);
    }

    // Single user
    public function createdBy()
    {
        return $this->belongsTo(TenantUser::class, 'created_by');
    }


    public function teamMembers()
    {
        return $this->belongsToMany(
            TenantUser::class,
            'project_team_members',
            'project_id',
            'user_id'
        );
    }


    public function clients()
    {
        return $this->belongsToMany(
            TenantUser::class,
            'project_clients',
            'project_id',
            'client_id'
        );
    }






    public function documents()
    {
        return $this->hasMany(ProjectDocument::class);
    }

}