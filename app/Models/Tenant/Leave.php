<?php

namespace App\Models\Tenant;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Leave extends BaseTenantModel
{

        protected $fillable = [
            'user_id','leave_type_id',
            'start_date','end_date','total_days',
            'reason','status','remark','subject','session',
            'apply_to','cc_to',
            'approved_by','approved_at'
        ];

        protected $casts = [
            'cc_to' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
        ];

        public function applyToUser()
        {
            return $this->belongsTo(TenantUser::class, 'apply_to');
        }

        public function getCcUsersAttribute()
        {
            if (empty($this->cc_to)) {
                return collect();
            }

            return TenantUser::whereIn('id', $this->cc_to)->get();
        }

        public function user()
        {
            return $this->belongsTo(TenantUser::class, 'user_id');
        }

        public function leaveType()
        {
            return $this->belongsTo(LeaveType::class, 'leave_type_id');
        }

        public function approvedByUser()
        {
            return $this->belongsTo(TenantUser::class, 'approved_by');
        }


        protected static function booted()
        {
            static::creating(function($user){
                    $user->user_id = Auth::id();
            });
        }
}
