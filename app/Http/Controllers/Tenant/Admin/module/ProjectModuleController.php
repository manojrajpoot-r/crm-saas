<?php

namespace App\Http\Controllers\Tenant\Admin\module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\ProjectModule;
use App\Models\Tenant\Project;
use App\Traits\UniversalCrud;

class ProjectModuleController extends Controller
{
    use UniversalCrud;

   public function index(Request $request)
{
    $id = base64_decode($request->id);
    $project = Project::findOrFail($id);

    $modules = ProjectModule::where('project_id', $project->id)
        ->latest()
        ->paginate(10);

    if ($request->ajax()) {
        return view('tenant.admin.modules.table', compact('modules'))->render();
    }

    return view('tenant.admin.modules.index', compact('project','modules'));
}


     // ===============================
    // CREATE / STORE
    // ===============================

    public function store(Request $request)
    {

        return $this->saveData($request, ProjectModule::class);
    }


    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $t = ProjectModule::find($id);

        $json = [
            "fields" => [
                "title" => [
                    "type"  => "text",
                    "value" => $t->title
                ],
                "notes" => [
                    "type"  => "textarea",
                    "value" => $t->notes
                ],
                 "start_date" => [
                    "type"  => "text",
                    "value" => $t->start_date
                ],
                 "end_date" => [
                    "type"  => "text",
                    "value" => $t->end_date
                ],
            ]
        ];

        return response()->json($json);
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {

         return $this->saveData($request, ProjectModule::class, $id);

    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(
            ProjectModule::class,
            $id,


        );
    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(ProjectModule::class, $id);
    }
}
