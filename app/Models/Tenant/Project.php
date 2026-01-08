<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FormatsDates;
class Project extends BaseTenantModel
{
     use FormatsDates;
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
    public function completer()
    {
        return $this->belongsTo(TenantUser::class, 'completed_by');
    }

    // Multiple users (JSON)
    public function creators()
    {
        return TenantUser::whereIn('id', $this->created_by ?? [])->get();
    }

    public function archivers()
    {
        return TenantUser::whereIn('id', $this->archived_by ?? [])->get();
    }

    public function documents()
    {
        return $this->hasMany(ProjectDocument::class);
    }

}
