<?php

namespace App\Http\Controllers\Tenant\Admin\designation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Designation;
use App\Traits\UniversalCrud;
class DesignationController extends Controller
{
         use UniversalCrud;

    public function index()
    {
        return view('tenant.admin.designations.index');
    }

    public function list()
    {
        $query = Designation::latest();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('department_id', function ($t) {
               return $t->department?->name ?? 'N/A';

            })
            ->addColumn('status_btn', function ($t) {
                if (!canAccess('designations status')) {
                    return '-';
                }

                $class = $t->status ? "btn-success" : "btn-danger";
                $text  = $t->status ? "Active" : "Inactive";
                $url   = route('tenant.designations.status', ['tenant' => currentTenant(), 'id' => $t->id]);

                return "<button class='btn btn-sm $class statusBtn' data-url='$url'>$text</button>";
            })

            ->addColumn('action', function ($t) {
                $buttons = '';

                if (canAccess('designations edit')) {
                    $editUrl = route('tenant.designations.edit',  $t->id);
                    $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='$editUrl'>Edit</button> ";
                }

                if (canAccess('Designations delete')) {
                    $deleteUrl = route('tenant.designations.delete', $t->id);
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
        return $this->saveData($request, Designation::class);
    }


    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $t = Designation::find($id);
        $department = $t->department->name ?? null;

        $json=[
            "name" => $t->name,
            "department_id" => $department,
        ];
        return response()->json($json);
    }

    // ===============================
    // UPDATE
    // ===============================

    public function update(Request $request, $id)
    {
        return $this->saveData($request, Designation::class, $id);
    }



    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(Designation::class,$id);
    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(Designation::class, $id);
    }
}
