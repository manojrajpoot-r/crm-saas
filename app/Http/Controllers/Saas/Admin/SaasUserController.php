<?php

namespace App\Http\Controllers\Saas\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UniversalCrud;
use App\Models\User;
use App\Models\Role;
class SaasUserController extends Controller
{

    use UniversalCrud;

    public function index(Request $request)
    {
        $users = User::with('role')->latest()->paginate(10);
        $roles = Role::select('id','name')->get();
        if ($request->ajax()) {
            return view('tenant.admin.tenant-users.table', compact('users'))->render();
        }

        return view('tenant.admin.tenant-users.index', compact('roles','users'));
    }





    public function store(Request $request)
    {
        $data = $request->all();

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $request->replace($data);

        return $this->saveData($request, User::class);
    }

public function edit($id)
{
    $t = User::with('role')->findOrFail($id);

    return response()->json([
        "fields" => [
            "name" => ["type"=>"text", "value"=>$t->name],
            "email" => ["type"=>"text", "value"=>$t->email],
            "phone" => ["type"=>"text", "value"=>$t->phone],
            "profile" => ["type"=>"file", "value"=> $t->profile ? asset('uploads/users/profile/'.$t->profile) : ""],
            "role_id" => [
                "type" => "select",
                "value" => $t->role_id,
                "options" => Role::select('id','name')->get()
            ]
        ]
    ]);
}



    public function update(Request $request, $id)
    {
        return $this->saveData($request, User::class, [
            'name' => 'required'
        ], $id);
    }


    public function delete($id)
    {
        return $this->deleteData(User::class, $id);
    }



    public function status($id)
    {
        return $this->toggleStatus(User::class, $id);
    }

    public function changePassword(Request $request, $id)
    {
        return $this->changePasswordTrait($request,User::class,$id);
    }

}
