<?php

namespace App\Http\Controllers\Saas\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UniversalCrud;
use App\Models\User;
class SaasUserController extends Controller
{

    use UniversalCrud;

    public function index()
    {
        return view('tenant.admin.tenant-users.index');
    }

    public function list()
    {


        $query = User::with('role')->latest();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('role_id', function ($t) {
               return $t->role?->name ?? 'N/A';

            })
          ->addColumn('status_btn', function ($t) {

                if (!canAccess('users status')) {
                    return "<span class='badge bg-secondary'>No Access</span>";
                }

                $class = $t->status ? "btn-success" : "btn-danger";
                $text = $t->status ? "Active" : "Inactive";
                $url = route('saas.users.status', $t->id);

                return "<button class='btn btn-sm $class statusBtn' data-url='$url'>$text</button>";
            })


           ->addColumn('action', function ($t) {

                $buttons = '';

                if (canAccess('users edit')) {
                    $editUrl = route('saas.users.edit', $t->id);
                    $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='$editUrl'>Edit</button> ";
                }

                if (canAccess('users change password')) {

                    $passwordUrl = route('saas.users.password.change', [
                        'id' => $t->id
                    ]);

                    $buttons .= "<button
                        class='btn btn-warning btn-sm changePasswordBtn'
                        data-url='{$passwordUrl}'
                        data-id='{$t->id}'
                    >
                        Change Password
                    </button> ";
                }
                if (canAccess('users delete')) {
                    $deleteUrl = route('saas.users.delete', $t->id);
                    $buttons .= "<button class='btn btn-danger btn-sm deleteBtn' data-url='$deleteUrl'>Delete</button>";
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
        $data = $request->all();

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $request->replace($data);

        return $this->saveData($request, User::class);
    }


  // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $t = User::find($id);
        $json=[
            "name" => $t->name,
            "email" => $t->email ?? "",
        ];
        return response()->json($json);
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {
        return $this->saveData($request, User::class, [
            'name' => 'required'
        ], $id);
    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(
            User::class,
            $id,


        );
    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(User::class, $id);
    }

    // ===============================
    // CHANGE PASSWORD
    // ===============================
    public function changePassword(Request $request, $id)
    {
        return $this->changePasswordTrait($request,User::class,$id);
    }

}
