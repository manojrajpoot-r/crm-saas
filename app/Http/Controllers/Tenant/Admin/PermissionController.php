<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Permission;
use App\Traits\UniversalCrud;
class PermissionController extends Controller
{
    use UniversalCrud;

    public function index()
    {
        return view('tenant.admin.permissions.index');
    }

public function list()
{
    $query = Permission::latest();

    return datatables()->of($query)
        ->addIndexColumn()

        ->addColumn('status_btn', function ($t) {
            if (!canAccess('permissions status')) {
                return '-';
            }

            $class = $t->status ? "btn-success" : "btn-danger";
            $text  = $t->status ? "Active" : "Inactive";
            $url   = route('tenant.permissions.status', ['tenant' => currentTenant(), 'id' => $t->id]);

            return "<button class='btn btn-sm $class statusBtn' data-url='$url'>$text</button>";
        })

        ->addColumn('action', function ($t) {
            $buttons = '';

            if (canAccess('permissions edit')) {
                $editUrl = route('tenant.permissions.edit',  $t->id);
                $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='$editUrl'>Edit</button> ";
            }

            if (canAccess('permissions delete')) {
                $deleteUrl = route('tenant.permissions.delete', $t->id);
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
        return $this->saveData($request, Permission::class);
    }


    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $t = Permission::find($id);
        $json=[
            "name" => $t->name,
            "group" => $t->group,
        ];
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
