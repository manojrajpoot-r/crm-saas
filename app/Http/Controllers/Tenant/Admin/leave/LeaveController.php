<?php

namespace App\Http\Controllers\tenant\admin\leave;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Models\Tenant\Leave;
use App\Models\Tenant\LeaveType;
use App\Models\Tenant\TenantUser;
use Illuminate\Support\Facades\Auth;
use App\Traits\UniversalCrud;
use App\Mail\LeaveAppliedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Services\LeaveService;

class LeaveController extends Controller
{
    use UniversalCrud;
    public function index(Request $request)
    {
        $user = Auth::user();
        $leaveTypes = LeaveType::select('id','name','color')->get();
        $userdropdwons = TenantUser::select('id','name')->get();
        if (canAccess('view_all_leaves')) {

              $query = TenantUser::with([
                    'leaves' => function ($q) use ($request) {

                        if ($request->month) {
                            $q->whereMonth('start_date', $request->month);
                        }

                        if ($request->status) {
                            $q->where('status', $request->status);
                        }

                        $q->latest();
                    },
                    'leaves.leaveType',
                    'leaves.approvedByUser'
                ])
                ->whereHas('leaves', function ($q) use ($request) {

                    if ($request->month) {
                        $q->whereMonth('start_date', $request->month);
                    }

                    if ($request->status) {
                        $q->where('status', $request->status);
                    }
                });

            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $users = $query->latest()->paginate(10);


             $userStats = [];

            foreach ($users as $userItem) {
                $leaves = $userItem->leaves;

                $userStats[$userItem->id] = [
                    'name'     => $userItem->name,
                    'total'    => $leaves->count(),
                    'pending'  => $leaves->where('status','pending')->count(),
                    'approved' => $leaves->where('status','approved')->count(),
                    'rejected' => $leaves->where('status','rejected')->count(),
                    'types'    => $leaves->groupBy('leave_type_id')->map->count(),
                ];
            }

            $leaveBalances = [];

                foreach ($users as $userItem) {
                    $leaveBalances[$userItem->id] = LeaveService::userLeaveBalance($userItem->id);
                }


            if ($request->ajax()) {
                return view('tenant.admin.leave.admin.table', compact('users','userStats','leaveTypes','leaveBalances'))->render();
            }

            return view('tenant.admin.leave.admin.index',compact('userStats','leaveTypes','users','userdropdwons','leaveBalances'));
        }

        /* ================= USER ================= */
       if (canAccess('view_leaves')) {

            $leaves = Leave::with(['leaveType','approvedByUser'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);

                $selfStats = [
                    'total'    => Leave::where('user_id',$user->id)->count(),
                    'pending'  => Leave::where('user_id',$user->id)->where('status','pending')->count(),
                    'approved' => Leave::where('user_id',$user->id)->where('status','approved')->count(),
                    'rejected' => Leave::where('user_id',$user->id)->where('status','rejected')->count(),
                    'types'    => Leave::where('user_id',$user->id)
                                    ->selectRaw('leave_type_id, COUNT(*) as total')
                                    ->groupBy('leave_type_id')
                                    ->pluck('total','leave_type_id')
                                    ->toArray(),
                ];
        $leaveBalance = LeaveService::userLeaveBalance($user->id);

            if ($request->ajax()) {
                return view('tenant.admin.leave.table', compact('leaves','selfStats','leaveTypes','leaveBalance'))->render();
            }
                return view('tenant.admin.leave.index',compact('leaves','leaveTypes','selfStats','userdropdwons','leaveBalance'));
            }
    }


    public function store(Request $request)
    {

        try{

        $leave = Leave::create([
            'user_id'       => Auth::id(),
            'leave_type_id' => $request->leave_type_id,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'total_days'    => $request->total_days,
            'reason'        => $request->reason,
            'apply_to'      => $request->apply_to,
            'cc_to'         => $request->cc_to,
            'subject'       => $request->subject,
            'session'       =>$request->session,
            'status'        =>'pending'
        ]);

        $approver = TenantUser::find($request->apply_to);


        if (!$approver?->email) {
            return response()->json([
                'status'  => false,
                'message' => 'Approver email not found'
            ], 422);
        }

        $ccEmails = [];
        if ($request->cc_to) {
            $ccEmails = TenantUser::whereIn('id', $request->cc_to)->pluck('email')->toArray();
        }


        Mail::to($approver->email)
            ->cc($ccEmails)
            ->send(new LeaveAppliedMail($leave));


        }catch(\Throwable $e) {

            Log::error('Employee save failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' =>  $e->getMessage()
            ], 500);
        }
        return response()->json([
            'status'  => true,
            'message' => 'Leave applied and email sent successfully'
        ]);

    }

    public function edit($id)
    {
        $leave = Leave::with('leaveType')->findOrFail($id);

        return response()->json([
            "fields" => [
                "leave_type_id" => [
                    "type" => "select",
                    "value" => $leave->leave_type_id,
                "options" => LeaveType::select('id','name')->get()

                ],
                "start_date" => [
                    "type" => "date",
                    "value" => $this->formatDate($leave->start_date),
                ],
                "end_date" => [
                    "type" => "date",
                    "value" =>  $this->formatDate($leave->end_date),
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

            ]
        ]);
    }




    public function update(Request $request, $id)
    {
        return $this->saveData($request, Leave::class, $id);
    }

    public function delete($id)
    {
        return $this->deleteData(Leave::class,$id);
    }


    public function status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $leave = Leave::with(['user','leaveType','applyToUser'])->findOrFail($id);

        if ($leave->status !== 'pending') {
            return response()->json([
                'error' => 'Status cannot be changed. Leave already ' . ucfirst($leave->status)
            ], 403);
        }

        $leave->update([
            'status' => $request->status,
            'remark'       => $request->remark,
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);


        if (!$leave->user?->email) {
            return response()->json([
                'error' => 'Applicant email not found'
            ], 422);
        }

        $ccEmails = [];


        if ($leave->applyToUser?->email) {
            $ccEmails[] = $leave->applyToUser->email;
        }

        if (!empty($leave->cc_to)) {
            $extraCc = TenantUser::whereIn('id', $leave->cc_to)
                ->pluck('email')
                ->toArray();

            $ccEmails = array_merge($ccEmails, $extraCc);
        }

        Mail::to($leave->user->email)
            ->cc($ccEmails)
            ->send(new LeaveAppliedMail($leave));

        return response()->json([
            'status' => true,
            'message' => 'Status updated & mail sent successfully'
        ]);
    }



    public function show($id)
    {
        $leave = Leave::with(['user','leaveType','approvedByUser'])->findOrFail($id);
        return view('tenant.admin.leave.view', compact('leave'));
    }



}