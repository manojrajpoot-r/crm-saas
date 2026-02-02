<?php

namespace App\Http\Controllers\Tenant\Admin\project;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Employee;
use Illuminate\Http\Request;
use App\Models\Tenant\Project;
use App\Models\Tenant\TenantUser;
use App\Models\Tenant\ProjectDocument;
use App\Traits\UniversalCrud;
use Illuminate\Support\Facades\DB;
class ProjectController extends Controller
{
    use UniversalCrud;
   public function index(Request $request)
{
    $employees = Employee::select('id','first_name','last_name')->get();

    $projects = Project::with(['createdBy','documents'])
        ->latest()
        ->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.projects.table', compact('projects'))->render();
        }

    return view('tenant.admin.projects.index', compact('employees','projects'));
}


    // public function list()
    // {
    //    $query = Project::with(['createdBy','documents'])->latest();

    //     return datatables()->of($query)
    //         ->addIndexColumn()
    //         ->addColumn('created_by', function ($t) {

    //             if (!$t->createdBy) {
    //                 return '-';
    //             }

    //             $user = $t->createdBy;

    //             $profile = $user->profile
    //                 ? asset('uploads/tenantusers/profile/' . $user->profile)
    //                 : asset('images/default-profile.png');

    //             return "
    //                 <div class='d-flex align-items-center gap-2'>
    //                     <img src='{$profile}' width='35' height='35' style='border-radius:50%;object-fit:cover'>
    //                     <span>{$user->name}</span>
    //                 </div>
    //             ";
    //         })


    //         ->addColumn('dates', function ($row) {
    //             return $row->dates_column;
    //         })


    //        ->addColumn('dead_line', function ($row) {
    //             return $row->end_date
    //                 ? $row->end_date->format('d M Y')
    //                 : '-';
    //         })


    //         ->addColumn('status_btn', function ($t) {

    //             if (!canAccess('status_projects')) {
    //                 return "<span class='badge bg-secondary'>No Access</span>";
    //             }

    //             $label = ucwords(str_replace('_', ' ', $t->status));
    //             $url = tenantRoute('projects.status', $t->id);

    //             return "
    //                 <span class='badge bg-info me-2'>{$label}</span>
    //                 <a href='javascript:void(0)'
    //                 class='text-primary openStatusModal'
    //                 data-url='{$url}'
    //                 data-current='{$t->status}'
    //                 title='Change Status'
    //                 style='cursor:pointer'
    //                 >
    //                     <i class='fa fa-edit'></i>
    //                 </a>
    //             ";

    //         })


    //         ->addColumn('action', function ($t) {
    //             $buttons = '';

    //             if (canAccess('edit_projects')) {
    //                 $editUrl = tenantRoute('projects.edit', $t->id);
    //                 $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='$editUrl'>Edit</button> ";
    //             }

    //             if (canAccess('delete_projects')) {
    //                 $deleteUrl = tenantRoute('projects.delete',$t->id);
    //                 $buttons .= "<button class='btn btn-danger btn-sm deleteBtn' data-url='$deleteUrl'>Delete</button> ";
    //             }

    //           if (canAccess('details_view_projects')) {

    //             $viewUrl = tenantRoute('projects.show', base64_encode($t->id));

    //             $buttons .= "<a class='btn btn-primary btn-sm' href='{$viewUrl}'>View</a> ";
    //         }




    //             return $buttons ?: 'No Action';
    //         })

    //         ->rawColumns([
    //             'dates',
    //             'status_btn',
    //             'action',
    //             'created_by',
    //         ])

    //             ->make(true);

    // }

    // ===============================
    // CREATE / STORE
    // ===============================

    public function store(Request $request)
    {
        return $this->saveData($request, Project::class);
    }


    // ===============================
    // EDIT
    // ===============================
 public function edit($id)
{
    $project = Project::with(['teamMembers', 'clients', 'documents'])->findOrFail($id);

    return response()->json([
        "fields" => [
            "name" => ["type"=>"text", "value"=>$project->name],
            "type" => [
                "type"=>"select",
                "value"=>$project->type,
                "options"=>[
                    ["id"=>"fixed","name"=>"Fixed"],
                    ["id"=>"product","name"=>"Product"],
                    ["id"=>"hourly","name"=>"Hourly"],
                    ["id"=>"service","name"=>"Service"],
                    ["id"=>"support","name"=>"Support"],
                    ["id"=>"other","name"=>"Other"],
                ]
            ],
            "description"=>["type"=>"textarea","value"=>$project->description],
            "start_date"=>["type"=>"date","value"=>optional($project->start_date)->format('Y-m-d')],
            "end_date"=>["type"=>"date","value"=>optional($project->end_date)->format('Y-m-d')],
            "actual_start_date"=>["type"=>"date","value"=>optional($project->actual_start_date)->format('Y-m-d')],
            "total_days"=>["type"=>"number","value"=>$project->total_days,"readonly"=>true],
            "completion_percent"=>["type"=>"number","value"=>$project->completion_percent],
            "hours_allocated"=>["type"=>"number","value"=>$project->hours_allocated],
            "remarks"=>["type"=>"text","value"=>$project->remarks],

            "status"=>[
                "type"=>"select",
                "value"=>$project->status,
                    "options" => [
                        ["id" => "created",       "name" => "Created"],
                        ["id" => "working",       "name" => "Working"],
                        ["id" => "on_hold",       "name" => "On Hold"],
                        ["id" => "finished",      "name" => "Finished"],
                        ["id" => "maintenance",   "name" => "Maintenance"],
                        ["id" => "delay",         "name" => "Delay"],
                        ["id" => "handover",      "name" => "Handover"],
                        ["id" => "discontinued",  "name" => "Discontinued"],
                        ["id" => "inactive",      "name" => "Inactive"],
                        ["id" => "completed",     "name" => "Completed"],
                        ["id" => "cancelled",     "name" => "Cancelled"],
                        ["id" => "pending",       "name" => "Pending"],
                        ["id" => "closed",        "name" => "Closed"],
                        ["id" => "resolved",      "name" => "Resolved"],
                        ["id" => "reopened",      "name" => "Reopened"],
                        ["id" => "in_progress",   "name" => "In Progress"],
                    ]
                ],

                "employee_id" => [
                    "type"  => "multiselect",
                    "value" => $project->teamMembers->pluck('id')->toArray(),
                    "options" => Employee::select('id', 'first_name', 'last_name')
                        ->get()
                        ->map(function ($e) {
                            return [
                                'id'   => $e->id,
                                'name' => $e->first_name . ' ' . $e->last_name,
                            ];
                        })
                ],

              "client_id" => [
                    "type"  => "multiselect",
                    "value" => $project->clients->pluck('id')->toArray(),
                    "options" => Employee::select('id', 'first_name', 'last_name')
                        ->get()
                        ->map(function ($e) {
                            return [
                                'id'   => $e->id,
                                'name' => $e->first_name . ' ' . $e->last_name,
                            ];
                        })
                ],

            "documents"=> $project->documents->map(function($doc){
                return [
                    'id' => $doc->id,
                    'file' => $doc->file_path,
                ];
            })
        ]
    ]);
}



    public function update(Request $request, $id)
    {
        return $this->saveData($request, Project::class, $id);
    }


    public function delete($id)
    {
        return $this->deleteData(Project::class,$id);
    }




    public function status(Request $request, $id)
    {
        return $this->toggleStatusMultiple($request, Project::class, $id);
    }



public function show(Request $request, $id)
{
      $projectId = base64_decode($id);
    $project = Project::with(['documents.uploadedBy', 'createdBy'])->findOrFail($projectId);
    $created_by_name = $project->createdBy->name ?? 'N/A';

    return view('tenant.admin.projects.show', compact('project','created_by_name'));
}








}