<?php

namespace App\Http\Controllers\Tenant\Employee\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FormDefinitions\ReportForm;
use App\Traits\UniversalCrud;
use App\Models\Tenant\Report;
use App\Models\Tenant\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class MyReportController extends Controller
{
     use UniversalCrud;

public function index()
{
    if (canAccess('view_all_reports')) {
        $reports = Report::with('user','project')
            ->latest()
            ->paginate(10);
    } else {
        $reports = Report::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
    }

    return view('tenant.employee.myprofile.report.index', compact('reports'));
}


    public function create()
    {
        $item = null;
        $projects = Project::pluck('name','id');
        return view('tenant.employee.myprofile.report.addEdit', compact('projects','item'));
    }


        public function edit($id)
        {
            $item = Report::with('projects')->findOrFail($id);
            $projects = Project::pluck('name','id');

        return view('tenant.employee.myprofile.report.addEdit', compact('projects','item'));
    }


public function store(Request $request, $id = null)
{
        $validator = Validator::make($request->all(), [
            'projects' => 'required|array',
            'projects.*.description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }


    DB::transaction(function () use ($request, $id) {


        if ($id) {
            Report::where('id', $id)
                ->where('user_id', Auth::id())
                ->delete();
        }

        foreach ($request->projects as $row) {

            Report::create([
                'user_id'     => Auth::id(),
                'project_id'  => $row['project_id'] ?? null,
                'title'       => $row['title'] ?? null,
                'description' => $row['description'],
                'hours'       => $row['hours'] ?? 0,
                'report_date' => $request->report_date,
                'admin_comment' => null,
            ]);
        }
    });

    return response()->json([
        'status' => true,
        'message' => $id ? 'Report updated successfully' : 'Report created successfully',
        'redirect' => route('tenant.employee.myreports.index')
    ]);
}


    public function update(Request $request, $id)
    {

         return $this->saveData($request, Report::class, $id);

    }


    public function delete($id)
    {
        return $this->deleteData(Report::class,$id);
    }


    public function status($id)
    {
        return $this->toggleStatus(Report::class, $id);
    }

    public function show($id)
    {
        $id = base64_decode($id);

        $report = Report::with([
            'user',
            'project',
            'documents'
        ])->findOrFail($id);

        // Authorization (optional but recommended)
        if (!canAccess('view_all_reports') && $report->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tenant.employee.myprofile.report.show', compact('report'));
    }

}