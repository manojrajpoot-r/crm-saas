<?php

namespace App\Http\Controllers\Saas\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Traits\UniversalCrud;
class SaasPermissionController extends Controller
{
    use UniversalCrud;

 public function index(Request $request)
    {
        $permissions = Permission::latest()->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.permissions.table', compact('permissions'))->render();
        }

        return view('tenant.admin.permissions.index', compact('permissions'));
    }


    public function store(Request $request)
    {
        return $this->saveData($request, Permission::class);
    }


    public function edit($id)
    {
        $t = Permission::find($id);
        $json=[
            "name" => $t->name,
            "group" => $t->group,
        ];
        return response()->json($json);
    }



    public function update(Request $request, $id)
    {
        return $this->saveData($request, Permission::class, $id);
    }

    public function delete($id)
    {
        return $this->deleteData(Permission::class,$id);
    }


    public function status($id)
    {
        return $this->toggleStatus(Permission::class, $id);
    }
}