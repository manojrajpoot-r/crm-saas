<?php

namespace App\Http\Controllers\Tenant\Admin\task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Task;
use App\Models\Tenant\Project;
use App\Traits\UniversalCrud;
use Illuminate\Support\Facades\Auth;
class TaskController extends Controller
{
        use UniversalCrud;

    public function index(Request $request)
    {
        $id =$request->id;
        $project = Project::findOrFail($id);
        return view('tenant.admin.tasks.index',compact('project'));
    }


    public function list(Request $request)
    {
        $projectId = $request->project_id;

        $query = Task::where('project_id', $projectId)->latest();

        return datatables()->of($query)
            ->addIndexColumn()

            // STATUS (1,2,3)
            ->addColumn('status_text', function ($t) {

                $map = [
                    1 => ['Completed', 'success'],
                    2 => ['Created', 'secondary'],
                    3 => ['Declined', 'danger'],
                ];

                [$text, $color] = $map[$t->status] ?? ['Unknown', 'dark'];

                return "<span class='badge bg-$color'>$text</span>";
            })

            // COMPLETED
            ->addColumn('complete_btn', function ($t) {
                if ($t->is_completed) {
                    return "<span class='badge bg-success'>Completed</span>";
                }

                return "<button class='btn btn-sm btn-warning changeStatus'
                        data-id='{$t->id}'
                        data-type='complete'>Mark Complete</button>";
            })

            // APPROVED
            ->addColumn('approve_btn', function ($t) {
                if ($t->is_approved) {
                    return "<span class='badge bg-primary'>Approved</span>";
                }

                return "<button class='btn btn-sm btn-info changeStatus'
                        data-id='{$t->id}'
                        data-type='approve'>Approve</button>";
            })

            ->addColumn('action', function ($t) {
                return "
                    <button class='btn btn-info btn-sm editBtn'
                        data-url='".route('tenant.tasks.edit',$t->id)."'>Edit</button>

                    <button class='btn btn-danger btn-sm deleteBtn'
                        data-url='".route('tenant.tasks.delete',$t->id)."'>Delete</button>
                ";
            })

            ->rawColumns(['status_text','complete_btn','approve_btn','action'])
            ->make(true);
    }

     // ===============================
    // CREATE / STORE
    // ===============================

    public function store(Request $request)
    {

        return $this->saveData($request, Task::class);
    }


    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {

        $t = Task::find($id);
        $json=[
            "name" => $t->name,
        ];
        return response()->json($json);
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {

         return $this->saveData($request, Task::class, $id);

    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(
            Task::class,
            $id,


        );
    }


    // ===============================
    // STATUS
    // ===============================
    // public function status($id)
    // {
    //     return $this->toggleStatus(Task::class, $id);
    // }

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