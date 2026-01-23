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
        $id = base64_decode($request->id);
        $project = Project::findOrFail($id);

        $moduleList = ProjectModule::select('id','title')
            ->where('project_id', $project->id)
            ->get();

        $userList = TenantUser::select('id','name')->get();

        $tasks = Task::where('project_id', $project->id)
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.tasks.table', compact('tasks'))->render();
        }

        return view(
            'tenant.admin.tasks.index',
            compact('project','moduleList','userList','tasks')
        );
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

            case 'complete':
                $task->status = 1; // completed
                $task->is_completed = 1;
                $task->completed_at = now();
                break;

            case 'create':
                $task->status = 2; // created
                break;

            case 'decline':
                $task->status = 3; // declined
                break;

            case 'approve':
                $task->is_approved = 1;
                $task->approved_at = now();
                $task->approved_by = Auth::id();
                break;
        }

        $task->save();

        return response()->json(['success' => true]);
    }


}