<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Tenant\Leave;
use App\Models\Tenant\LeaveType;
use App\Models\Tenant\Employee;

class LeaveService
{
    public static function userLeaveBalance($userId)
    {
        $employee = Employee::where('user_id', $userId)->first();
        if (!$employee) return [];

        $joiningDate = Carbon::parse($employee->joining_date);
        $monthsWorked = $joiningDate->diffInMonths(now()) + 1;

        $leaveTypes = LeaveType::where('status', 1)->get();

        $result = [];

        foreach ($leaveTypes as $type) {

            $allowed = round(($monthsWorked / 12) * $type->max_days, 2);

            $used = Leave::where('user_id', $userId)
                ->where('leave_type_id', $type->id)
                ->where('status', 'approved')
                ->sum('total_days');

            $result[$type->id] = [
                'name'       => $type->name,
                'color'      => $type->color,
                'allowed'    => $allowed,
                'used'       => $used,
                'remaining'  => max(0, $allowed - $used),
            ];
        }

        return $result;
    }
}