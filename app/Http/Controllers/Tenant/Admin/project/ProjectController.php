<?php

namespace App\Http\Controllers\Tenant\Admin\project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Project;
use App\Models\Tenant\ProjectDocument;
use App\Traits\UniversalCrud;

class ProjectController extends Controller
{
    use UniversalCrud;
    public function index()
    {
        return view('tenant.admin.projects.index');
    }

    public function list()
    {
       $query = Project::with(['completer','documents'])->latest();

        return datatables()->of($query)
            ->addIndexColumn()


            ->addColumn('documents', function ($t) {

                if ($t->documents->isEmpty()) {
                    return '-';
                }

                $html = '';

                foreach ($t->documents as $doc) {

                    $ext = strtolower(pathinfo($doc->file, PATHINFO_EXTENSION));

                    $icon = match ($ext) {
                        'pdf' =>  asset('assets/img/icons/pdf.png'),
                        'doc', 'docx' =>  asset('assets/img/icons/word.png'),
                        'xls', 'xlsx' =>  asset('assets/img/icons/excel.png'),
                        'zip', 'rar' =>  asset('assets/img/icons/zip.png'),
                        default => asset('assets/img/icons/file.png')
                    };

                    $filePath = 'uploads/projects/documents/'.$doc->file;
                    $viewUrl = asset($filePath);
                    $downloadUrl = route('tenant.projects.download.doc', $doc->id);

                    $html .= "
                        <div class='d-flex align-items-center gap-2 mb-1'>
                            <img src='{$icon}' width='20'>
                            <a href='{$viewUrl}' target='_blank'>{$doc->file}</a>
                            <a href='{$downloadUrl}' class='btn btn-sm btn-outline-primary'>⬇</a>
                        </div>
                    ";
                }

                return $html;
            })



            ->addColumn('completed_by', function ($t) {

                if (!$t->completer) {
                    return '-';
                }

             if ($t->completer->profile) {
                 $url = asset('uploads/tenantusers/profile/' . $t->completer->profile);

                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='{$url}' width='35' height='35' style='border-radius:50%;object-fit:cover'>
                        <span>{$t->completer->name}</span>
                    </div>
                ";
             }
             return "<img src='".asset('images/default-profile.png')."' width='50' height='50' style='border-radius:50%;object-fit:cover'>";
            })

           ->addColumn('created_by', function ($t) {

                $users = $t->creators();

                if ($users->isEmpty()) {
                    return '-';
                }

                return $users->pluck('name')->implode(', ');
            })


            ->addColumn('archived_by', function ($t) {

                $users = $t->archivers();

                if ($users->isEmpty()) {
                    return '-';
                }

                return $users->pluck('name')->implode(', ');
            })


            ->addColumn('dates', function ($row) {
                return $row->dates_column;
            })


           ->addColumn('dead_line', function ($row) {
                return $row->end_date
                    ? $row->end_date->format('d M Y')
                    : '-';
            })


            ->addColumn('status_btn', function ($t) {

                if (!canAccess('projects status')) {
                    return "<span class='badge bg-secondary'>No Access</span>";
                }

                $label = ucwords(str_replace('_', ' ', $t->status));
                $url = route('tenant.projects.status', $t->id);

                return "
                    <span class='badge bg-info me-2'>{$label}</span>
                    <a href='javascript:void(0)'
                    class='text-primary openStatusModal'
                    data-url='{$url}'
                    data-current='{$t->status}'
                    title='Change Status'
                    style='cursor:pointer'
                    >
                        <i class='fa fa-edit'></i>
                    </a>
                ";

            })


            ->addColumn('action', function ($t) {
                $buttons = '';

                if (canAccess('projects edit')) {
                    $editUrl = route('tenant.projects.edit', $t->id);
                    $buttons .= "<button class='btn btn-info btn-sm editBtnProject' data-url='$editUrl'>Edit</button> ";
                }

                if (canAccess('projects delete')) {
                    $deleteUrl = route('tenant.projects.delete',$t->id);
                    $buttons .= "<button class='btn btn-danger btn-sm deleteBtn' data-url='$deleteUrl'>Delete</button> ";
                }

                if (canAccess('projects view')) {
                    $viewUrl = route('tenant.projects.show',$t->id);
                    $buttons .= "<a class='btn btn-primary btn-sm' href='$viewUrl'>View</a> ";
                }



                return $buttons ?: 'No Action';
            })

        ->rawColumns([
            'documents',
            'dates',
            'status_btn',
            'action',
            'completed_by',
            'created_by',
            'archived_by'
        ])

            ->make(true);

    }

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
        $project = Project::findOrFail($id);

        return response()->json([
            'name'              => $project->name,
            'type'              => $project->type,
            'description'       => $project->description,
            'start_date'        => optional($project->start_date)->format('Y-m-d'),
            'end_date'          => optional($project->end_date)->format('Y-m-d'),
            'actual_start_date' => optional($project->actual_start_date)->format('Y-m-d'),
            'total_days'        => $project->total_days,
            'completion_percent'=> $project->completion_percent,
            'hours_allocated'   => $project->hours_allocated,
            'remarks'           => $project->remarks,

            // For Select2 multi-select (IDs)
            'created_by'   => $project->created_by ?? [],
            'archived_by'  => $project->archived_by ?? [],

            // Single user
            'completed_by' => $project->completed_by,
            'status'       => $project->status,
        ]);
    }




    // ===============================
    // UPDATE
    // ===============================

    public function update(Request $request, $id)
    {
        return $this->saveData($request, Project::class, $id);
    }



    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(Project::class,$id);
    }


    // ===============================
    // STATUS
    // ===============================


    public function status(Request $request, $id)
    {
        return $this->toggleStatusMultiple($request, Project::class, $id);
    }



    public function show($id)
    {
        $project = Project::with(['documents', 'completer'])->findOrFail($id);

        return view('tenant.admin.projects.show', compact('project'));
    }

    // ===============================
    // Pdf download
    // ===============================


    public function downloadDoc($id)
    {
        $doc = ProjectDocument::findOrFail($id);

        $path = public_path('uploads/projects/documents/'.$doc->file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }


}
