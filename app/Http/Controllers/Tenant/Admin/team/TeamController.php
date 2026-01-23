<?php

namespace App\Http\Controllers\Tenant\Admin\team;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Employee;
use Illuminate\Http\Request;
use App\Models\Tenant\Project;
use App\Models\Tenant\TenantUser;
use App\Traits\UniversalCrud;
use Illuminate\Support\Facades\Auth;
class TeamController extends Controller
{
   public function index(Request $request)
{
    $id = base64_decode($request->id);
    $project = Project::with([
    'teamMembers.department',
    'teamMembers.designation',
    'clients'
])->findOrFail($id);


    return view('tenant.admin.team.index', compact('project'));
}

public function searchUsers(Request $request)
{
    return Employee::where('first_name', 'like', "%{$request->q}%")->orWhere('last_name', 'like', "%{$request->q}%")
        ->select('id','first_name','last_name','profile')
        ->get();
}

public function assignTeam(Request $request)
{

    $project = Project::findOrFail($request->project_id);

    $project->teamMembers()
        ->syncWithoutDetaching($request->employee_id);

    return response()->json([
        'success' => true,
        'message' => 'Team members assigned successfully'
    ]);
}




}
