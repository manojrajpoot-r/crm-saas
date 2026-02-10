<?php

namespace App\Http\Controllers\Tenant\Employee;

use App\FormDefinitions\ChangePassword;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant\Employee;
use App\Models\Tenant\TenantUser;
use App\Traits\UniversalCrud;
class MyProfileController extends Controller
{
        use UniversalCrud;
    public function index()
    {
       $employee  = Employee::where('user_id', Auth::id())->first();
        $address   = $employee->address;
        $bank      = $employee->bankInfo;
        $upi       = $employee->upiInfo;
        $emergency = $employee->emergencyContacts;
        $family    = $employee->familyInfos;
        $education = $employee->educations;
        $experience = $employee->experiences;
        $personalInfo = $employee->personalInfo;
        return view('tenant.employee.myprofile.index', compact('employee','address','bank','emergency','upi','family','education','experience','personalInfo'));
    }

    public function loadForm($type)
{
    $employee = Employee::where('user_id', Auth::id())->firstOrFail();

    return match ($type) {
        'personal' => view('tenant.employee.myprofile.forms.personal', compact('employee')),

        'address' => view('tenant.employee.myprofile.forms.address', [
        'address' => $employee->address
        ]),

        'bank' => view('tenant.employee.myprofile.forms.bank', [
            'bank' => $employee->bankInfo
        ]),
        'upi' => view('tenant.employee.myprofile.forms.upi_info', [
        'upi' => $employee->upiInfo
        ]),


        'emergency' => view('tenant.employee.myprofile.forms.emergency', [
        'emergency' => $employee->emergencyContacts
        ]),

        'family' => view('tenant.employee.myprofile.forms.family', [
        'family' => $employee->familyInfos
        ]),

        'education' => view('tenant.employee.myprofile.forms.education', [
        'education' => $employee->educations
        ]),

        'experience' => view('tenant.employee.myprofile.forms.experience', [
        'experience' => $employee->experiences
        ]),

       'personalInfo' => view('tenant.employee.myprofile.forms.personal_details', [
        'personalInfo' => $employee->personalInfo
        ]),



        default => abort(404)
    };
}


    public function update(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee profile not found'
            ], 403);
        }

        return $this->saveEmployeeAll($request, $employee->id);
    }

public function updateProfileImage(Request $request)
{
    $request->validate([
        'profile' => 'required|image'
    ]);

    $employee = Auth::user()->employee;

    $name = time().'.'.$request->profile->extension();
    $request->profile->move(public_path('uploads/employees/profile'), $name);

    $employee->update(['profile' => $name]);

    return response()->json([
        'image' => asset('uploads/employees/profile/'.$name)
    ]);
}


   public function change_password()
    {
        $item = null;
        $fields = ChangePassword::fields();

        return view('tenant.employee.myprofile.change-password', compact('fields'));
    }

    public function change_password_update(Request $request)
    {
        $id =Auth::id();
        return $this->changePasswordTrait($request,TenantUser::class,$id);
    }

}
