<?php

namespace App\Http\Controllers\Saas\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Traits\UniversalCrud;
class SaasPermissionController extends Controller
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

                    if (!canAccess('change_permissions_status')) {
                        return '-';
                    }

                    $class = $t->status ? 'btn-success' : 'btn-danger';
                    $text  = $t->status ? 'Active' : 'Inactive';
                    $url   = route('saas.permissions.status', $t->id);

                    return "<button class='btn btn-sm {$class} statusBtn' data-url='{$url}'>{$text}</button>";
                })


                 ->addColumn('action', function ($t) {

                    $buttons = '';

                    if (canAccess('edit_permissions')) {
                        $editUrl = route('saas.permissions.edit', $t->id);
                        $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='{$editUrl}'>Edit</button> ";
                    }

                    if (canAccess('delete_permissions')) {
                        $deleteUrl = route('saas.permissions.delete', $t->id);
                        $buttons .= "<button class='btn btn-danger btn-sm deleteBtn' data-url='{$deleteUrl}'>Delete</button> ";
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