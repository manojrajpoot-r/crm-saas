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
        $id =$request->id;
        $project = Project::findOrFail($id);
        return view('tenant.admin.modules.index', compact('project'));
    }



    public function list(Request $request)
    {

         $projectId = $request->project_id;
        $query = ProjectModule::where('project_id', $projectId)->latest();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('created_at', function($item){
                    return $this->formatDate($item->created_at);
                })

              ->addColumn('start_date', function($item){
                    return $this->formatDate($item->created_at);
                })
                  ->addColumn('end_date', function($item){
                    return $this->formatDate($item->created_at);
                })
            ->addColumn('status_btn', function ($t) {
                if (!canAccess('module status')) {
                    return "<span class='badge bg-secondary'>No Access</span>";
                }

                $class = $t->status ? "btn-success" : "btn-danger";
                $text = $t->status ? "Active" : "Inactive";
                $url = route('tenant.modules.status',  $t->id);

                return "<button class='btn btn-sm $class statusBtn' data-url='$url'>$text</button>";
            })

            ->addColumn('action', function ($t) {
                $buttons = '';

                if (canAccess('module edit')) {
                    $editUrl = route('tenant.modules.edit', $t->id);
                    $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='$editUrl'>Edit</button> ";
                }

                if (canAccess('module delete')) {
                    $deleteUrl = route('tenant.modules.delete',  $t->id);
                    $buttons .= "<button class='btn btn-danger btn-sm deleteBtn' data-url='$deleteUrl'>Delete</button> ";
                }


                return $buttons ?: 'No Action';
            })

            ->rawColumns(['status_btn','action'])
            ->make(true);
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
         $json=[
            "fields" => [
                    "name" => ["type"=>"text", "value"=>$t->name],
            ]];
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
