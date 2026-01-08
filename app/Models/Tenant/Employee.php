<?php

namespace App\Models\Tenant;


use Illuminate\Database\Eloquent\Model;

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

    public function reports()
    {
        return $this->hasMany(Report::class);
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
        return $this->hasMany(EmployeeEmergencyContact::class);
    }

    public function familyInfos()
    {
        return $this->hasMany(EmployeeFamilyInfo::class);
    }

    public function educations()
    {
        return $this->hasMany(EmployeeEducation::class);
    }

    public function experiences()
    {
        return $this->hasMany(EmployeeExperience::class);
    }

    public function upiInfo()
    {
        return $this->hasOne(EmployeeUpiInfo::class);
    }

}
