<?php

namespace App\Http\Controllers\Saas\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Traits\UniversalCrud;
class SaasRoleController extends Controller
{
     use UniversalCrud;

    public function index(Request $request)
    {
        $roles = Role::latest()->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.roles.table', compact('roles'))->render();
        }

        return view('tenant.admin.roles.index');
    }



    public function store(Request $request)
    {

        return $this->saveData($request, Role::class);
    }



    public function edit($id)
    {
        $t = Role::find($id);
     $json=[
        "fields" => [
                "name" => ["type"=>"text", "value"=>$t->name],
        ]];
        return response()->json($json);
    }

    public function update(Request $request, $id)
    {
        return $this->saveData($request, Role::class, [
            'name' => 'required'
        ], $id);
    }


    public function delete($id)
    {
        return $this->deleteData(
            Role::class,
            $id,


        );
    }

    public function status($id)
    {
        return $this->toggleStatus(Role::class, $id);
    }
}
