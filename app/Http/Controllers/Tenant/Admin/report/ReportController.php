<?php

namespace App\Http\Controllers\Tenant\Admin\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Report;
use App\Traits\UniversalCrud;
use Carbon\Carbon;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;
class ReportController extends Controller
{
    use UniversalCrud;

    public function index()
    {

        return view('tenant.admin.reports.index');
    }


public function list(Request $request)
{
    $query = Report::with('employee.department', 'employee.designation');

    //  Date Range (highest priority)
    if ($request->from_date && $request->to_date) {
        $query->whereBetween('report_date', [
            Carbon::parse($request->from_date)->startOfDay(),
            Carbon::parse($request->to_date)->endOfDay()
        ]);
    }

    //  Daily / Weekly / Monthly
    else {
        if ($request->filter_type === 'daily') {
            $query->whereDate('report_date', now());
        }

        if ($request->filter_type === 'weekly') {
            $query->whereBetween('report_date', [
                now()->startOfWeek()->startOfDay(),
                now()->endOfWeek()->endOfDay()
            ]);
        }

        if ($request->filter_type === 'monthly') {
            $query->whereBetween('report_date', [
                now()->startOfMonth()->startOfDay(),
                now()->endOfMonth()->endOfDay()
            ]);
        }
    }

    return datatables()->of($query->orderBy('report_date','desc'))
        ->addIndexColumn()

        ->addColumn('employee_name', fn ($t) =>
            optional($t->employee)->first_name
                ? $t->employee->first_name.' '.$t->employee->last_name
                : '-'
        )

         ->addColumn('department_name', fn ($t) =>
            optional($t->employee->department)->name ?? '-'
        )

            ->addColumn('designation_name', fn ($t) =>
            optional($t->employee->designation)->name ?? '-'

        )


        ->addColumn('report_title', fn ($t) => $t->title)

        ->addColumn('report_date', fn ($t) =>
            Carbon::parse($t->report_date)->format('d M Y')
        )

      ->addColumn('status_btn', function ($t) {
        if (!canAccess('reports status')) return '-'; $class = $t->status ? "btn-success" : "btn-danger"; $text = $t->status ? "Active" : "Inactive"; $url = route('tenant.reports.status', [ 'tenant' => currentTenant(), 'id' => $t->id ]);
        return "<button class='btn btn-sm $class statusBtn' data-url='$url'>$text</button>"; })
        ->rawColumns(['status_btn']) ->make(true);
}




     // ===============================
    // CREATE / STORE
    // ===============================

    public function store(Request $request)
    {
        return $this->saveData($request, Report::class);
    }


    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $t = Report::find($id);

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
        return $this->saveData($request, Report::class, $id);
    }



    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(Report::class,$id);
    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(Report::class, $id);
    }


 public function reportExport(Request $request)
{
    return Excel::download(
        new ReportsExport(
            $request->filter_type,
            $request->from_date,
            $request->to_date
        ),
        'reports_'.now()->format('d-m-Y').'.xlsx'
    );
}



}