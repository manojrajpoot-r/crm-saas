<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Leave extends BaseTenantModel
{

 protected $fillable = [
        'user_id','leave_type_id',
        'start_date','end_date','total_days',
        'reason','status','approved_by','approved_at'
    ];

      protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(TenantUser::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
}
