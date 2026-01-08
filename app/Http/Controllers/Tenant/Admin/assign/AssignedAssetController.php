<?php

namespace App\Http\Controllers\Tenant\Admin\assign;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Asset;
use App\Models\Tenant\AssignedAsset;
use App\Models\Tenant\TenantUser;

class AssignedAssetController extends Controller
{

    public function index()
    {
        return view('tenant.admin.assign.index');

    }

    public function list()
    {
        $data = AssignedAsset::with(['user','asset'])->latest();

        return datatables()->of($data)
            ->addIndexColumn()
               ->addColumn('user_name', function ($t) {
                return $t->user ? $t->user->name : '-';
            })
            ->addColumn('asset_name', function ($t) {
                return $t->asset ? $t->asset->name : '-';
            })

            ->addColumn('action', function ($row) {
                  $url = route('tenant.assigns.status', $row->id);
                if ($row->status == '1') { // 1 = assigned
                    return '<button class="btn btn-sm btn-danger statusBtn" data-url="'.$url.'">Return</button>';
                }
                return '-';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'user_id'  => 'required'
        ]);

        //  Check asset already assigned or not
        if (
            AssignedAsset::where('asset_id', $request->asset_id)
                ->where('status', '1')
                ->exists()
        ) {
            return response()->json([
                'message' => 'Asset already assigned'
            ], 422);
        }

         //status 1=assign 0=return
        AssignedAsset::create([
            'asset_id'      => $request->asset_id,
            'user_id'       => $request->user_id,
            'assigned_date' => now(),
            'status'        => '1'
        ]);

        // update main asset status 1=available 0=assign
        Asset::whereId($request->asset_id)->update([
            'status' => 0// assigned
        ]);

        return response()->json(['message' => 'Asset assigned']);
    }

    public function status($id)
    {
        $row = AssignedAsset::findOrFail($id);

        // already returned guard
        if ($row->status == 0) {
            return response()->json(['message' => 'Asset already returned'], 422);
        }

        // return asset
        $row->update([
            'status'      => 0, // returned
            'return_date' => now(),
        ]);

        // make asset available again
        Asset::whereId($row->asset_id)->update([
            'status' => 1 // available
        ]);

        return response()->json(['message' => 'Asset returned successfully']);
    }

}
