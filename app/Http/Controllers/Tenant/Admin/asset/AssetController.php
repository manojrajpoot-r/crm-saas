<?php

namespace App\Http\Controllers\Tenant\Admin\asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Asset;
use App\Models\Tenant\AssignedAsset;
use App\Traits\UniversalCrud;
class AssetController extends Controller
{
      use UniversalCrud;

    public function index()
    {
        return view('tenant.admin.assets.index');
    }

    public function list()
    {
        $query = Asset::latest();

        return datatables()->of($query)
            ->addIndexColumn()

        ->addColumn('status_btn', function ($t) {

            if (!canAccess('asset assigns status')) {
                return "<span class='badge bg-secondary'>No Access</span>";
            }

            // assets table logic
            if ($t->status == 1) {
                // available
                $class = 'btn-success';
                $text  = 'Available';
            } else {
                // assigned
                $class = 'btn-warning';
                $text  = 'Assigned';
            }

            $url = route('tenant.asset_assigns.status', $t->id);

            return "<button class='btn btn-sm $class statusBtn' data-url='$url'>$text</button>";
        })


            ->addColumn('action', function ($t) {
                $buttons = '';

                if (canAccess('asset assigns edit')) {
                    $editUrl = route('tenant.asset_assigns.edit',  $t->id);
                    $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='$editUrl'>Edit</button> ";
                }

                if (canAccess('asset assigns delete')) {
                    $deleteUrl = route('tenant.asset_assigns.delete', $t->id);
                    $buttons .= "<button class='btn btn-danger btn-sm deleteBtn' data-url='$deleteUrl'>Delete</button> ";
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
        return $this->saveData($request, Asset::class);
    }


    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {

        $t = Asset::find($id);

         $json=[
            "fields" => [
                    "name" => ["type"=>"text", "value"=>$t->name],
                    "code" => ["type"=>"text", "value"=>$t->code],
                     "type" => ["type"=>"text", "value"=>$t->type],
            ]];
        return response()->json($json);
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {

         return $this->saveData($request, Asset::class, $id);

    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(Asset::class,$id);
    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(Asset::class, $id);
    }
}
