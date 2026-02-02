<?php

namespace App\Http\Controllers\Tenant\Admin\assign;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Asset;
use App\Models\Tenant\Employee;
use App\Models\Tenant\AssignedAsset;
use App\Models\Tenant\TenantUser;
use App\Traits\UniversalCrud;
class AssignedAssetController extends Controller
{
         use UniversalCrud;
    public function index(Request $request)
    {
         $employees = Employee::select('id', 'first_name', 'last_name')->where('status', '1')->get();
         $assets = Asset::select('id', 'name')->get();
        $assignedAssets = AssignedAsset::with(['employee', 'asset'])->latest()->paginate(10);
          if ($request->ajax()) {
            return view('tenant.admin.assigns.table', compact('assets','employees','assignedAssets'))->render();
        }


        return view('tenant.admin.assigns.index', compact('assets','employees','assignedAssets'));

    }

//  public function list()
// {
//     $data = AssignedAsset::with(['employee', 'asset'])->latest();

//     return datatables()->of($data)
//         ->addIndexColumn()

//         ->addColumn('user_name', function ($t) {
//             if ($t->employee) {
//                 return $t->employee->first_name . ' ' . $t->employee->last_name;
//             }
//             return '-';
//         })

//         ->addColumn('asset_name', function ($t) {
//             return $t->asset ? $t->asset->name : '-';
//         })

//          ->editColumn('assigned_date', function($t){
//                     return $this->formatDate($t->assigned_date);
//             })

//         ->addColumn('action', function ($row) {
//             $url = tenantRoute('assigns.status', $row->id);

//             if ($row->status == '1') {
//                 return '<button class="btn btn-sm btn-danger statusBtn" data-url="'.$url.'">Return</button>';
//             }
//             return '-';
//         })

//         ->rawColumns(['action'])
//         ->make(true);
// }


    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'employee_id'  => 'required'
        ]);

        //  Check asset already assigned or not
        if (AssignedAsset::where('asset_id', $request->asset_id)->where('status', '1')->exists()) {
            return response()->json([
                'message' => 'Asset already assigned'
            ], 422);
        }

         //status 1=assign 0=return
        AssignedAsset::create([
            'asset_id'      => $request->asset_id,
            'employee_id'       => $request->employee_id,
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