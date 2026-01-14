<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Role;
use App\Traits\UniversalCrud;
class RoleController extends Controller
{
       use UniversalCrud;

    public function index()
    {
        return view('tenant.admin.roles.index');
    }

    public function list()
    {
        $query = Role::latest();

        return datatables()->of($query)
            ->addIndexColumn()

            ->addColumn('status_btn', function ($t) {
                if (!canAccess('roles status')) {
                    return "<span class='badge bg-secondary'>No Access</span>";
                }

                $class = $t->status ? "btn-success" : "btn-danger";
                $text = $t->status ? "Active" : "Inactive";
                $url = route('tenant.roles.status',  $t->id);

                return "<button class='btn btn-sm $class statusBtn' data-url='$url'>$text</button>";
            })

            ->addColumn('action', function ($t) {
                $buttons = '';

                if (canAccess('roles edit')) {
                    $editUrl = route('tenant.roles.edit', $t->id);
                    $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='$editUrl'>Edit</button> ";
                }

                if (canAccess('roles delete')) {
                    $deleteUrl = route('tenant.roles.delete',  $t->id);
                    $buttons .= "<button class='btn btn-danger btn-sm deleteBtn' data-url='$deleteUrl'>Delete</button> ";
                }

                if (canAccess('roles permission')) {
                 $permissionsUrl = route(
                        'tenant.roles.permissions',
                        [
                            'tenant' => currentTenant(),
                            'id' => $t->id
                        ]
                    );

                    $buttons .= "<a href=\"{$permissionsUrl}\" class='btn btn-primary btn-sm'>Permission</a>";
                }

                return $buttons ?: 'No Action';
            })

            ->rawColumns(['status_btn','action'])
            ->make(true);
    }

     // ===============================
    // CREATE / STORE
    // ===============================

    public function store(Request $request)
    {

        return $this->saveData($request, Role::class);
    }


    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {

        $t = Role::find($id);
         $json=[
            "fields" => [
                "name" => ["type"=>"text", "value"=>$t->name],
            ]];
        return response()->json($json);
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {

         return $this->saveData($request, Role::class, $id);

    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(
            Role::class,
            $id,


        );
    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(Role::class, $id);
    }
}
