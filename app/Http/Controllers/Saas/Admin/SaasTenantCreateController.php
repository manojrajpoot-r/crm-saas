<?php

namespace App\Http\Controllers\Saas\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use App\Traits\UniversalCrud;
use App\Models\Domain;
use App\Models\Tenant;
class SaasTenantCreateController extends Controller
{
    use UniversalCrud;

    public function index()
    {
        return view("tenant.admin.tenants.index");
    }

    // ===============================
    // SERVER-SIDE DATATABLE
    // ===============================
    public function list()
    {
        $query = Tenant::with('domains');

        return datatables()->of($query)
            ->addIndexColumn()

            ->addColumn('domain', function ($t) {
                return $t->domains->first()->domain ?? '';
            })

            ->addColumn('status_btn', function ($t) {

                if (!canAccess('tenants status')) {
                    return '-';
                }

                $class = $t->status ? "btn-success" : "btn-danger";
                $text  = $t->status ? "Active" : "Inactive";
                $url   = route('saas.tenants.status', $t->id);

                return "<button class='btn btn-sm $class statusBtn' data-url='$url'>$text</button>";
            })

            ->addColumn('action', function ($t) {

                $buttons = '';

                if (canAccess('tenants edit')) {
                    $editUrl = route('saas.tenants.edit', $t->id);
                    $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='$editUrl'>Edit</button> ";
                }

                if (canAccess('tenants delete')) {
                    $deleteUrl = route('saas.tenants.delete', $t->id);
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

        return $this->saveTenant($request);
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $t = Tenant::with('domains')->find($id);
         $json=[
            "fields" => [
                    "name" => ["type"=>"text", "value"=>$t->name],
                    "domain" => ["type"=>"text", "value"=>$t->domains->first()->domain ?? ""],
            ]];

        return response()->json($json);
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {
        return $this->saveData($request, Tenant::class, [
            'name' => 'required'
        ], $id);
    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(
            Tenant::class,
            $id,
            [
                Domain::class => 'tenant_id'
            ]
        );
    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(Tenant::class, $id);
    }

}
