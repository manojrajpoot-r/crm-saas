<?php

namespace App\Services;

use App\Repositories\AttendanceRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant\TenantUser;
use App\Models\Tenant\Attendance;
use App\Models\Tenant\Holiday;
use App\Models\Tenant\UserShift;
use Carbon\Carbon;

class AttendanceService
{
    protected $repo;

    public function __construct(AttendanceRepository $repo)
    {
        $this->repo = $repo;
    }

    public function list($perPage = 20)
    {
        return $this->repo->getAll($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK-IN
    |--------------------------------------------------------------------------
    */

    public function store(array $data)
    {
        $employee = Auth::user();

        // Already checked in?
        $already = Attendance::where('user_id', $employee->id)
            ->whereDate('date', today())
            ->exists();

        if ($already) {
            throw new \Exception("You have already checked in today");
        }

        $shift = UserShift::where('user_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        if (!$shift) {
            throw new \Exception("Shift not assigned for today");
        }

        $this->validateOfficeLocation(
            $data['latitude'],
            $data['longitude']
        );

        $checkInTime = now()->format('H:i:s');

        $attendanceData = [
            'user_id' => $employee->id,
            'shift_id' => $shift->id,
            'date' => today(),
            'check_in' => $checkInTime,
            'status' => 'present',
            'late_mark' => $this->isLate($checkInTime, $shift),
            'overtime_hours' => 0,
        ];

        return $this->repo->create($attendanceData);
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK-OUT
    |--------------------------------------------------------------------------
    */

    public function checkOut(array $data)
    {
        $employee = Auth::user();

        $attendance = Attendance::where('user_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        if (!$attendance) {
            throw new \Exception("You have not checked in today");
        }

        if ($attendance->check_out) {
            throw new \Exception("You have already checked out");
        }

        $this->validateOfficeLocation(
            $data['latitude'],
            $data['longitude']
        );

        $shift = UserShift::where('user_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        if (!$shift) {
            throw new \Exception("Shift not assigned for today");
        }

        $checkOutTime = now()->format('H:i:s');

        $attendance->check_out = $checkOutTime;
        $attendance->overtime_hours =
            $this->calculateOvertime($checkOutTime, $shift->end_time);

        $attendance->save();

        return $attendance;
    }

    /*
    |--------------------------------------------------------------------------
    | OFFICE LOCATION VALIDATION
    |--------------------------------------------------------------------------
    */

    private function validateOfficeLocation($lat, $lng)
    {
        $tenant = config('saas.current_tenant');

        if (!$tenant || !$tenant->office_lat || !$tenant->office_lng) {
            throw new \Exception("Office location not configured");
        }

        $distance = $this->calculateDistance(
            $tenant->office_lat,
            $tenant->office_lng,
            $lat,
            $lng
        );

        if ($distance > $tenant->office_radius) {
            throw new \Exception("You are outside office location");
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LATE MARK CHECK
    |--------------------------------------------------------------------------
    */

    private function isLate($checkInTime, $shift)
    {
        $allowedTime = Carbon::parse($shift->start_time)
            ->addMinutes($shift->grace_minutes);

        return Carbon::parse($checkInTime)->gt($allowedTime) ? 1 : 0;
    }

    /*
    |--------------------------------------------------------------------------
    | OVERTIME
    |--------------------------------------------------------------------------
    */

    private function calculateOvertime($checkOut, $shiftEnd)
    {
        if (Carbon::parse($checkOut)->gt(Carbon::parse($shiftEnd))) {

            $minutes = Carbon::parse($shiftEnd)
                ->diffInMinutes(Carbon::parse($checkOut));

            return round($minutes / 60, 2);
        }

        return 0;
    }

    /*
    |--------------------------------------------------------------------------
    | DISTANCE CALCULATION (HAVERSINE)
    |--------------------------------------------------------------------------
    */

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;

        return $distance * 1000;
    }

        /*
        |--------------------------------------------------------------------------
        | AUTO ABSENT MARK (CRON)
        |--------------------------------------------------------------------------
        */

    public function markAbsent()
    {
        $today = today();

        $employees = TenantUser::where('role', 'user')->get();

        foreach ($employees as $employee) {
            $alreadyMarked = Attendance::where('user_id', $employee->id)
                ->whereDate('date', $today)
                ->exists();

            if ($alreadyMarked) {
                continue;
            }


            $userShift = UserShift::where('user_id', $employee->id)
                ->whereDate('date', $today)
                ->first();

            if (!$userShift) {
                continue;
            }

            $dayName = strtolower(today()->format('l'));

            if (strtolower($userShift->shift->weekly_off_day) === $dayName) {
                continue;
            }

            if ($userShift->shift->work_mode === 'wfh') {
                continue;
            }


            $isHoliday = Holiday::whereDate('date', $today)->exists();

            if ($isHoliday) {
                continue;
            }


            $halfDayTime = Carbon::parse($userShift->shift->start_time)
          ->addHours(4);

        if (now()->gt($halfDayTime) && !$alreadyMarked) {

            $this->repo->create([
                'user_id' => $employee->id,
                'shift_id' => $userShift->shift_id,
                'date' => $today,
                'status' => 'half_day',
                'late_mark' => 0,
                'overtime_hours' => 0,
            ]);

            continue;
        }


            if (now()->gt(Carbon::parse($userShift->end_time))) {

                $this->repo->create([
                    'user_id' => $employee->id,
                    'shift_id' => $userShift->shift_id,
                    'date' => $today,
                    'status' => 'absent',
                    'late_mark' => 0,
                    'overtime_hours' => 0,
                ]);
            }
        }
    }

    public function update($id, $data)
    {
        return $this->repo->update($id, $data);
    }
    public function show($id)
    {
        return $this->repo->findById($id);

    }
    public function delete($id) {
         return $this->repo->delete($id);

    }

}