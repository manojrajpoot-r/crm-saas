<?php

namespace App\Http\Controllers\tenant\admin\leaveType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\LeaveType;
use App\Traits\UniversalCrud;
class LeaveTypeController extends Controller
{
    use UniversalCrud;
    public function index(Request $request)
    {
        $leaveTypes = LeaveType::latest()->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.leaveType.table', compact('leaveTypes'))->render();
        }

        return view('tenant.admin.leaveType.index', compact('leaveTypes'));
    }




    public function store(Request $request)
    {

        return $this->saveData($request, LeaveType::class);
    }


 public function edit($id)
{
    $t = LeaveType::find($id);

    return response()->json([
        "fields" => [
            "name" => ["type" => "text", "value" => $t->name],
            "color" => ["type" => "color", "value" => $t->color],
            "max_days" => ["type" => "number", "value" => $t->max_days],

            "is_paid" => [
                "type" => "checkbox",
                "checked" => (bool) $t->is_paid
            ],
            "allow_half" => [
                "type" => "checkbox",
                "checked" => (bool) $t->allow_half
            ],
            "allow_short" => [
                "type" => "checkbox",
                "checked" => (bool) $t->allow_short
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
}
