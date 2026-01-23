<?php

namespace App\Http\Controllers\Tenant\Admin\designation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Designation;
use App\Models\Tenant\Department;
use App\Traits\UniversalCrud;
class DesignationController extends Controller
{
         use UniversalCrud;

    public function index(Request $request)
    {
       $departmentList = Department::select('id','name')->where('status','1')->get();
        $designations = Designation::with('department')->latest()->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.designations.table', compact('designations'))->render();
        }

        return view('tenant.admin.designations.index', compact('designations','departmentList'));
    }



    public function store(Request $request)
    {
        return $this->saveData($request, Designation::class);
    }


    public function edit($id)
    {
        $t = Designation::find($id);
        $department = Department::get();
     $json=[
        "fields" => [
            "name" => ["type"=>"text", "value"=>$t->name],
            "department_id" => [
                "type" => "select",
                "value" => $t->department_id,
                "options" => $department,
            ]]];



        return response()->json($json);
    }



    public function update(Request $request, $id)
    {
        return $this->saveData($request, Designation::class, $id);
    }


    public function delete($id)
    {
        return $this->deleteData(Designation::class,$id);
    }

    public function status($id)
    {
        return $this->toggleStatus(Designation::class, $id);
    }
}