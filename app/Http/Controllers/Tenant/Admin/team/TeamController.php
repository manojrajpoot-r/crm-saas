<?php

namespace App\Http\Controllers\Tenant\Admin\team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Project;
use App\Models\Tenant\TenantUser;
use App\Traits\UniversalCrud;
use Illuminate\Support\Facades\Auth;
class TeamController extends Controller
{
   public function index(Request $request)
{
    $project = Project::with([
        'teamMembers.employee.department',
        'teamMembers.employee.designation',
        'clients'

    ])->findOrFail($request->id);

    return view('tenant.admin.team.index', compact('project'));
}

public function searchUsers(Request $request)
{
    return TenantUser::where('name', 'like', "%{$request->q}%")
        ->select('id','name','email','profile')
        ->limit(10)
        ->get();
}

public function assignTeam(Request $request)
{

    $project = Project::findOrFail($request->project_id);

    $project->teamMembers()->syncWithoutDetaching($request->user_id);

    return response()->json(['success' => true]);
}



}
