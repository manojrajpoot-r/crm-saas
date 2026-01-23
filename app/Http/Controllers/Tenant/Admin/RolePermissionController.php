<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Role;
use App\Models\Tenant\Permission;
class RolePermissionController extends Controller
{

   public function editPermission(Request $request)
{
    $role = Role::findOrFail($request->id);

    //  related permissions only
    $allPermissions = Permission::where('status', 1)

        ->select('id', 'name', 'group')
        ->orderBy('group')
        ->get()
        ->groupBy('group');   // module wise grouping

    $rolePermissions = $role->permissions->pluck('id')->toArray();

    return view('tenant.admin.roles.permissions', compact('role','allPermissions','rolePermissions'));
}


    public function updatePermissions(Request $request)
    {
        $id = $request->id;
        $role = Role::findOrFail($id);
        $role->permissions()->sync($request->permission_ids ?? []);
        return response()->json(['success'=>true, "message"=>'Permissions updated successfully']);
    }




}
