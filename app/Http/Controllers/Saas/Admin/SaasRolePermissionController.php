<?php

namespace App\Http\Controllers\Saas\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
class SaasRolePermissionController extends Controller
{

public function editPermission(Request $request, $id)
{
    $role = Role::findOrFail($id);

    $allPermissions = Permission::where('status', 1)
        ->select('id', 'name', 'group')
        ->orderBy('group')
        ->get()
        ->groupBy('group');

    $rolePermissions = $role->permissions->pluck('id')->toArray();

    return view(
        'tenant.admin.roles.permissions',
        compact('role','allPermissions','rolePermissions')
    );
}



    public function updatePermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->permissions()->sync($request->permission_ids ?? []);
        return response()->json(['success'=>true, "message"=>'Permissions updated successfully']);
    }

}