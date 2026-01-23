<?php

namespace App\Http\Controllers\tenant\admin\leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Leave;
use App\Models\Tenant\LeaveType;
use App\Models\Tenant\TenantUser;
use Illuminate\Support\Facades\Auth;
use App\Traits\UniversalCrud;
class LeaveController extends Controller
{
    use UniversalCrud;
public function index(Request $request)
{
    $leaveTypes = LeaveType::where('status',1)->get();
    $users = TenantUser::where('master',1)->get();

    $leaves = Leave::with(['user','leaveType'])
        ->latest()
        ->paginate(10);

    if ($request->ajax()) {
        return view('tenant.admin.leave.table', compact('leaves'))->render();
    }

    return view('tenant.admin.leave.index', compact('leaveTypes','users','leaves'));
}



    public function store(Request $request)
    {

        return $this->saveData($request, LeaveType::class);
    }

    public function edit($id)
    {
        $leave = Leave::with(['user','leaveType'])->findOrFail($id);

        return response()->json([
            "fields" => [
                "user_id" => [
                    "type" => "select",
                    "value" => $leave->user_id,
                    "options" =>TenantUser::pluck('name','id')->toArray()
                ],
                "leave_type_id" => [
                    "type" => "select",
                    "value" => $leave->leave_type_id,
                    "options" => LeaveType::pluck('name','id')->toArray()
                ],
                "start_date" => [
                    "type" => "date",
                    "value" => $leave->start_date
                ],
                "end_date" => [
                    "type" => "date",
                    "value" => $leave->end_date
                ],
                "total_days" => [
                    "type" => "number",
                    "value" => $leave->total_days,
                    "readonly" => true
                ],
                "reason" => [
                    "type" => "textarea",
                    "value" => $leave->reason
                ],
                "status" => [
                    "type" => "select",
                    "value" => $leave->status,
                    "options" => [
                        "pending"  => "Pending",
                        "approved" => "Approved",
                        "rejected" => "Rejected"
                    ]
                ],
            ]
        ]);
    }



    public function update(Request $request, $id)
    {
        return $this->saveData($request, LeaveType::class, $id);
    }

    public function delete($id)
    {
        return $this->deleteData(LeaveType::class,$id);
    }

    public function status($id)
    {
        return $this->toggleStatus(LeaveType::class, $id);
    }

    // public function changeStatus(Request $request)
    // {
    //     Leave::where('id',$request->id)->update([
    //         'status' => $request->status,
    //         'approved_by' => Auth::id(),
    //         'approved_at' => now()
    //     ]);

    //     return response()->json(['status'=>true]);
    // }
}
