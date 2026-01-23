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


    public function index(Request $request)
    {

        $assets = Asset::latest()->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.assets.table', compact('assets'))->render();
        }

        return view('tenant.admin.assets.index', compact('assets'));
    }


    public function store(Request $request)
    {
        return $this->saveData($request, Asset::class);
    }

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


    public function update(Request $request, $id)
    {

         return $this->saveData($request, Asset::class, $id);

    }


    public function delete($id)
    {
        return $this->deleteData(Asset::class,$id);
    }

    public function status($id)
    {
        return $this->toggleStatus(Asset::class, $id);
    }
}
