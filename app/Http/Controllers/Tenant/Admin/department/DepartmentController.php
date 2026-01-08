<?php

namespace App\Http\Controllers\Tenant\Admin\department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Department;
use App\Traits\UniversalCrud;
class DepartmentController extends Controller
{
        use UniversalCrud;

    public function index()
    {
        return view('tenant.admin.departments.index');
    }

    public function list()
    {
        $query = Department::latest();

        return datatables()->of($query)
            ->addIndexColumn()

            ->addColumn('status_btn', function ($t) {
                if (!canAccess('departments status')) {
                    return '-';
                }

                $class = $t->status ? "btn-success" : "btn-danger";
                $text  = $t->status ? "Active" : "Inactive";
                $url   = route('tenant.departments.status', ['tenant' => currentTenant(), 'id' => $t->id]);

                return "<button class='btn btn-sm $class statusBtn' data-url='$url'>$text</button>";
            })

            ->addColumn('action', function ($t) {
                $buttons = '';

                if (canAccess('departments edit')) {
                    $editUrl = route('tenant.departments.edit',$t->id);
                    $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='$editUrl'>Edit</button> ";
                }

                if (canAccess('departments delete')) {
                    $deleteUrl = route('tenant.departments.delete', $t->id);
                    $buttons .= "<button class='btn btn-danger btn-sm deleteBtn' data-url='$deleteUrl'>Delete</button> ";
                }

                return $buttons ?: '-';
            })

            ->rawColumns(['status_btn', 'action'])
            ->make(true);
    }



     // ===============================
    // CREATE / STORE
    // ===============================

    public function store(Request $request)
    {
        return $this->saveData($request, Department::class);
    }


    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $t = Department::find($id);

        $json=[
            "name" => $t->name,

        ];
        return response()->json($json);
    }

    // ===============================
    // UPDATE
    // ===============================

    public function update(Request $request, $id)
    {
        return $this->saveData($request, Department::class, $id);
    }



    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(Department::class,$id);
    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(Department::class, $id);
    }
}
