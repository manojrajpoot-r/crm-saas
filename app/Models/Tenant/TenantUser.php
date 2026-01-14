<?php
namespace App\Models\Tenant;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
class TenantUser extends Authenticatable
{
    use Authorizable;
    protected $connection = 'tenant';
    protected $table = 'users';
    protected $primaryKey = 'id'; // if applicable
    protected $fillable = ['name','email','password','role_id','profile'];
    protected $hidden = ['password','remember_token'];


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function assignedAssets()
    {
        return $this->hasMany(AssignedAsset::class);
    }



    public function createdProjects()
    {
        return $this->hasMany(Project::class, 'created_by');
    }


    public function completedProjects()
    {
        return $this->hasMany(Project::class, 'completed_by');
    }


    public function archivedProjects()
    {
        return $this->hasMany(Project::class, 'archived_by');
    }

    public static function rules($id = null)
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => $id ? 'nullable|min:6' : 'required|min:6',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }




}
