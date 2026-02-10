<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Permission;
use App\Traits\UniversalCrud;
class PermissionController extends Controller
{
    use UniversalCrud;


    public function index(Request $request)
    {
        $permissions = Permission::orderBy('id','desc')->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.permissions.table', compact('permissions'))->render();
        }

        return view('tenant.admin.permissions.index', compact('permissions'));
    }






     // ===============================
    // CREATE / STORE
    // ===============================

    public function store(Request $request)
    {
        return $this->saveData($request, Permission::class);
    }


    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $t = Permission::find($id);
         $json=[
            "fields" => [
                    "name" => ["type"=>"text", "value"=>$t->name],
                    "group" => ["type"=>"text", "value"=>$t->group],
            ]];
        return response()->json($json);
    }

    // ===============================
    // UPDATE
    // ===============================

    public function update(Request $request, $id)
    {
        return $this->saveData($request, Permission::class, $id);
    }



    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(Permission::class,$id);
    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(Permission::class, $id);
    }
}