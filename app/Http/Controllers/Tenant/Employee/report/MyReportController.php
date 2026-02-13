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
    $query = Report::latest();

    if (canAccess('view_myreports_admin_type')) {
        $query->with([
            'user',
            'projects.project'
        ]);
    } elseif(canAccess('view_myreports')) {
        $query->where('user_id', Auth::id());
    }

    $reports = $query->paginate(10);

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
    $id = base64_decode($id);

    $item = Report::with([
        'user',
        'projects.project'
    ])->findOrFail($id);

    $projects = Project::pluck('name', 'id');

    return view(
        'tenant.employee.myprofile.report.addEdit',
        compact('projects', 'item')
    );
}

private function validateRequest(Request $request)
{
    Validator::make($request->all(), [

        'projects' => 'required|array|min:1',

        'projects.*.description' => 'required|string',

        'projects.*.hours' => 'nullable|numeric|min:0',

    ])->validate();
}


public function store(Request $request)
{
     try {
        $this->validateRequest($request);


        if($request->report_type==null)
        {
             return response()->json([
            'status' => false,
            'message' => 'Validation error',

        ]);
        }
        DB::beginTransaction();

        $status = $request->action === 'submit' ? 'submitted' : 'draft';

        $report = Report::create([
            'user_id'     => Auth::id(),
            'report_date' => $request->report_date,
            'status'      => $status,
            'report_type' => $request->report_type,
        ]);

        foreach ($request->projects as $row) {

            $report->projects()->create([
                'project_id'    => $request->report_type === 'other'
                                    ? null
                                    : $row['project_id'],
                'description'   => $row['description'],
                'hours'         => $row['hours'] ?? 0,
                'admin_comment' => null,
            ]);
        }

        if ($request->hasFile('documents')) {
            $this->uploadMultipleDocs(
                $request,
                $report,
                'documents',
                class_basename(Report::class)
            );
        }
     DB::commit();

       return response()->json([
        'status'   => true,
        'message'  => $request->action === 'submit'
                        ? 'Report submitted successfully'
                        : 'Draft saved successfully',
        'redirect' => route('tenant.employee.myreports.index')
    ]);

    } catch (\Illuminate\Validation\ValidationException $e) {

        return response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'error'   => $e->getMessage()
        ], 500);
    }


}


public function update(Request $request, $id)
{

   try {
        $id = base64_decode($id);
        $this->validateRequest($request);

        DB::beginTransaction();

        $status = $request->action === 'submit' ? 'submitted' : 'draft';

        $report = Report::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $report->update([
            'report_date' => $request->report_date,
            'status'      => $status,
            'report_type' => $request->report_type,
        ]);

        $report->projects()->delete();

        foreach ($request->projects as $row) {

            $report->projects()->create([
                'project_id'    => $request->report_type === 'other'
                                    ? null
                                    : $row['project_id'],
                'description'   => $row['description'],
                'hours'         => $row['hours'] ?? 0,
                'admin_comment' => null,
            ]);
        }


    return response()->json([
        'status'   => true,
        'message'  => $request->action === 'submit'
                        ? 'Report submitted successfully'
                        : 'Draft updated successfully',
        'redirect' => route('tenant.employee.myreports.index')
    ]);
     } catch (\Illuminate\Validation\ValidationException $e) {

        return response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'error'   => $e->getMessage()
        ], 500);
    }


}




    public function delete($id)
    {
        return $this->deleteData(Report::class,$id);
    }


    public function status(Request $request, $id)
    {
        $report = Report::findOrFail($id);
          $report->update([
            'status' => $request->status,
            'admin_comment' => $request->remark,
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

    }

public function show($id)
{
    $id = base64_decode($id);

    $report = Report::with([
        'user',
        'projects.project',
        'documents'
    ])->findOrFail($id);

    return view('tenant.employee.myprofile.report.show', compact('report'));
}


}
