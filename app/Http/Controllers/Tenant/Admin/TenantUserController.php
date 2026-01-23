<?php
namespace App\Http\Controllers\Tenant\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\TenantUser;
use App\Models\Tenant\Role;
use App\Traits\UniversalCrud;
class TenantUserController extends Controller
{
     use UniversalCrud;

    public function index(Request $request)
    {
        $users = TenantUser::with('role')->latest()->paginate(10);
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
        } else {
            unset($data['password']);
        }

        $request->replace($data);

        return $this->saveData($request, TenantUser::class);
    }


    public function edit($id)
    {
       $t = TenantUser::with('role')->findOrFail($id);
        return response()->json([
            "fields" => [
                "name" => ["type"=>"text", "value"=>$t->name],
                "email" => ["type"=>"text", "value"=>$t->email],
                "phone" => ["type"=>"number", "value"=>$t->phone],
                "profile" => ["type"=>"file", "value"=> $t->profile ? asset('uploads/tenantusers/profile/'.$t->profile) : ""],
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

      return $this->saveData($request, TenantUser::class, $id);

    }


    public function delete($id)
    {
        return $this->deleteData(
            TenantUser::class,
            $id,


        );
    }

    public function status($id)
    {
        return $this->toggleStatus(TenantUser::class, $id);
    }

    public function changePassword(Request $request, $id)
    {
        return $this->changePasswordTrait($request,TenantUser::class,$id);
    }

}
