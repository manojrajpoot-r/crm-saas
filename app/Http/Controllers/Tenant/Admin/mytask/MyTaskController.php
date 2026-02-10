<?php

namespace App\Http\Controllers\Tenant\Admin\mytask;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Task;
use Illuminate\Support\Facades\Auth;
use App\Traits\UniversalCrud;
class MyTaskController extends Controller
{
    use UniversalCrud;
    public function index(Request $request)
    {
     $mytasks = Task::with(['project','module','assigner'])
        ->myTasks()
        ->latest()
        ->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.mytask.table', compact('mytasks'))->render();
        }

        return view('tenant.admin.mytask.index', compact('mytasks'));
    }

    public function status(Request $request, $id)
    {

            $task = Task::findOrFail($id);
            $type = 'approval';


            // if ($type !== 'complete') {
            //     return response()->json(['error' => 'Unauthorized'], 403);
            // }


            if ($task->task_status != 1) {
                return response()->json(['error' => 'Task not started'], 422);
            }

            $task->task_status  = 2;
            $task->completed_at = now();
            $task->save();

            $this->notifyAdmin($task, 'Employee requested task completion');
            return response()->json(['success' => true,'message'=>'status update successfully!!']);

    }




}