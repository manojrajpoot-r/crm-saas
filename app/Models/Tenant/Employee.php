<?php

namespace App\Models\Tenant;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Employee extends BaseTenantModel
{
     protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'phone',
        'emergency_phone',
        'dob',
        'gender',
        'personal_email',
        'corporate_email',
        'department_id',
        'designation_id',
        'report_to',
        'join_date',
        'status',
        'profile',
        'created_by',
        'updated_by'
    ];


    public function user()
    {
        return $this->belongsTo(TenantUser::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'report_to');
    }

    public function address()
    {
        return $this->hasOne(EmployeeAddress::class);
    }




    public function personalInfo()
    {
        return $this->hasOne(EmployeePersonalInfo::class);
    }

    public function bankInfo()
    {
        return $this->hasOne(EmployeeBankInfo::class);
    }

    public function emergencyContacts()
    {
        return $this->hasOne(EmployeeEmergencyContact::class);
    }

    public function familyInfos()
    {
        return $this->hasOne(EmployeeFamilyInfo::class);
    }

    public function educations()
    {
        return $this->hasOne(EmployeeEducation::class);
    }

    public function experiences()
    {
        return $this->hasOne(EmployeeExperience::class);
    }

    public function upiInfo()
    {
        return $this->hasOne(EmployeeUpiInfo::class);
    }

    public function creator()
    {
        return $this->belongsTo(TenantUser::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(TenantUser::class, 'updated_by');
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->created_by = Auth::id();
     });

    static::updating(function ($user) {
        $user->updated_by = Auth::id();
    });

    }


}