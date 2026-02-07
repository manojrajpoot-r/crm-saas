<?php

namespace App\Http\Controllers\Tenant\Admin\task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Task;
use App\Models\Tenant\Project;
use App\Models\Tenant\ProjectModule;
use App\Models\Tenant\TenantUser;
use App\Traits\UniversalCrud;
use Illuminate\Support\Facades\Auth;
class TaskController extends Controller
{
        use UniversalCrud;
    public function index(Request $request)
    {
        $req_id = base64_decode($request->id);
        $project = Project::findOrFail($req_id);

        $moduleList = ProjectModule::select('id','title')->where('project_id', $req_id)->get();

        $userList = TenantUser::select('id','name')->get();

        $tasks = Task::where('project_id', $req_id)->latest()->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.tasks.table', compact('tasks'))->render();
        }

        return view('tenant.admin.tasks.index',compact('project','moduleList','userList','tasks'));

}


    public function store(Request $request)
    {

        return $this->saveData($request, Task::class);
    }


    public function edit($id)
    {

        $t = Task::find($id);
         $json=[
            "fields" => [
                    "name" => ["type"=>"text", "value"=>$t->name],
            ]];
        return response()->json($json);
    }

    public function update(Request $request, $id)
    {
         return $this->saveData($request, Task::class, $id);
    }


    public function delete($id)
    {
        return $this->deleteData(Task::class,$id);
    }



public function status(Request $request, $id)
{
    $task = Task::findOrFail($id);

    switch ($request->type) {

        case 'start':
            $task->task_status = 1;
            $task->started_at = now();
            break;

        case 'complete': // employee ya admin
            $task->task_status = 2;
            $task->completed_at = now();
            $this->notifyAdmin($task, 'Task completion requested');
            break;

        case 'approve':
            $task->task_status = 3;
            $task->status = 1;
            $task->is_approved = 1;
            $task->approved_at = now();
            $task->approved_by = Auth::id();

            $this->notifyUser($task->assigned_to, 'Task approved');
            break;

        case 'decline':
            $task->task_status = 4;
            $task->status = 3;

            $this->notifyUser($task->assigned_to, 'Task declined');
            break;

    }

    $task->save();

    return response()->json(['success' => true,'message'=>"status update successfully!!"]);
}



}