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


    public function index(Request $request)
    {
       $hasTenantUser = Tenant::exists();
        $tenants = Tenant::latest()->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.tenants.table', compact('tenants'))->render();
        }

        return view('tenant.admin.tenants.index', compact('hasTenantUser'));
    }





    // public function list()
    // {
    //     $query = Tenant::with('domains');

    //     return datatables()->of($query)
    //         ->addIndexColumn()

    //         ->addColumn('domain', function ($t) {
    //             return $t->domains->first()->domain ?? '';
    //         })

    //        ->addColumn('status_btn', function ($t) {

    //             if (!canAccess('tenants_status')) {
    //                 return '-';
    //             }

    //             $text = $t->status ? "Deactivate" : "Activate";
    //             $url  = route('saas.tenants.status', $t->id);

    //             $baseClass  = "btn btn-sm btn-outline-secondary statusBtn";
    //             $hoverClass = $t->status ? "hover-danger" : "hover-success";

    //             $tooltip = $t->status
    //                 ? "This will block the tenant’s website and log out all users."
    //                 : "This will re-enable the tenant’s website.";

    //             return "<button
    //                 class='{$baseClass} {$hoverClass}'
    //                 data-url='{$url}'
    //                 data-bs-toggle='tooltip'
    //                 title='{$tooltip}'>
    //                 {$text}
    //             </button>";
    //         })


    //         ->addColumn('action', function ($t) {

    //              $buttons = '';

    //             if (canAccess('edit_tenants')) {
    //                 $editUrl = route('saas.tenants.edit', $t->id);
    //                 $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='{$editUrl}'>Edit</button> ";
    //             }

    //             if (canAccess('delete_tenants')) {
    //                 $deleteUrl = route('saas.tenants.delete', $t->id);
    //                 $buttons .= "<button
    //                     class='btn btn-outline-danger btn-sm deleteBtn'
    //                     data-url='{$deleteUrl}'
    //                     data-bs-toggle='tooltip'
    //                     title='Permanently deletes tenant, database & all data. Cannot be undone.'>
    //                     Delete Tenant Permanently
    //                 </button>";
    //             }

    //             return $buttons ?: '-';
    //         })


    //         ->rawColumns(['status_btn', 'action'])
    //         ->make(true);
    // }



    public function store(Request $request)
    {

        return $this->saveTenant($request);
    }


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


    public function update(Request $request, $id)
    {

        $request->merge(['id' => $id]);
        return $this->saveTenant($request);
    }



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
        $response = $this->deleteData(
            Tenant::class,
            $id,
            [
                Domain::class => 'tenant_id'
            ]
        );

        if ($response->getData()->success) {
            try {
                DB::statement("DROP DATABASE IF EXISTS `$dbName`");
            } catch (\Exception $e) {

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
