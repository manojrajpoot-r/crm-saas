<?php

namespace App\Http\Controllers\Tenant\Admin\department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Department;
use App\Traits\UniversalCrud;
class DepartmentController extends Controller
{
        use UniversalCrud;

    public function index(Request $request)
    {
        $departments = Department::latest()->paginate(10);
        if ($request->ajax()) {
            return view('tenant.admin.departments.table', compact('departments'))->render();
        }
        return view('tenant.admin.departments.index',compact('departments'));
    }



    public function store(Request $request)
    {
        return $this->saveData($request, Department::class);
    }


    public function edit($id)
    {
        $t = Department::find($id);

         $json=[
            "fields" => [
                    "name" => ["type"=>"text", "value"=>$t->name],
            ]];

        return response()->json($json);
    }


    public function update(Request $request, $id)
    {
        return $this->saveData($request, Department::class, $id);
    }

    public function delete($id)
    {
        return $this->deleteData(Department::class,$id);
    }

    public function status($id)
    {
        return $this->toggleStatus(Department::class, $id);
    }
}