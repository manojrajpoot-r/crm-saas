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
use Illuminate\Support\Facades\Log;

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

               $text  = $t->status ? "Deactivate" : "Activate";
                $url   = route('saas.tenants.status', $t->id);

                $baseClass = "btn btn-sm btn-outline-secondary statusBtn";
                $hoverClass = $t->status ? "hover-danger" : "hover-success";

                $tooltip = $t->status
                    ? "This will block the tenant’s website and log out all users."
                    : "This will re-enable the tenant’s website.";

                return "<button
                    class='$baseClass $hoverClass'
                    data-url='$url'
                    data-bs-toggle='tooltip'
                    title='$tooltip'>
                    $text
                </button>";
            })

            ->addColumn('action', function ($t) {

                $buttons = '';

                if (canAccess('tenants edit')) {
                    $editUrl = route('saas.tenants.edit', $t->id);
                    $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='$editUrl'>Edit</button> ";
                }

                if (canAccess('tenants delete')) {
                    $deleteUrl = route('saas.tenants.delete', $t->id);
                    $buttons .= "<button
                                        class='btn btn-outline-danger btn-sm deleteBtn'
                                        data-url='$deleteUrl'
                                        data-bs-toggle='tooltip'
                                        data-bs-placement='top'
                                        title='Permanently deletes tenant, database & all data. Cannot be undone.'>
                                        Delete Tenant Permanently
                                    </button>";

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
    // UPDATE EXISTING TENANT
    // ===============================
    public function update(Request $request, $id)
    {

        $request->merge(['id' => $id]);
        return $this->saveTenant($request);
    }


    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        $tenant = Tenant::find($id);

        if (!$tenant) {
            return response()->json([
                'success' => false,
                'message' => 'Tenant not found'
            ], 404);
        }

        $dbName = $tenant->database;

        //  First delete using your dynamic system
        $response = $this->deleteData(
            Tenant::class,
            $id,
            [
                Domain::class => 'tenant_id'
            ]
        );

        // If delete success, then drop database
        if ($response->getData()->success) {
            try {
                DB::statement("DROP DATABASE IF EXISTS `$dbName`");
            } catch (\Exception $e) {
                // DB delete fail ho jaye to bhi system na toote
                Log::error("Tenant DB delete failed: " . $e->getMessage());
            }
        }

        return $response;
    }



    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->tenant_toggleStatus($id);
    }



}