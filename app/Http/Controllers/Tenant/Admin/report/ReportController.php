<?php

namespace App\Http\Controllers\Tenant\Admin\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Employee;
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
    $query = Employee::with(['department','designation']);

    //  Date Range (highest priority)
    if ($request->from_date && $request->to_date) {
        $query->whereBetween('created_at', [
            Carbon::parse($request->from_date)->startOfDay(),
            Carbon::parse($request->to_date)->endOfDay()
        ]);
    }

    //  Daily / Weekly / Monthly
    else {
        if ($request->filter_type === 'daily') {
            $query->whereDate('created_at', now());
        }

        if ($request->filter_type === 'weekly') {
            $query->whereBetween('created_at', [
                now()->startOfWeek()->startOfDay(),
                now()->endOfWeek()->endOfDay()
            ]);
        }

        if ($request->filter_type === 'monthly') {
            $query->whereBetween('created_at', [
                now()->startOfMonth()->startOfDay(),
                now()->endOfMonth()->endOfDay()
            ]);
        }
    }

    return datatables()->of($query->orderBy('id','desc'))
        ->addIndexColumn()

        ->addColumn('employee_name', fn ($t) =>
            optional($t->first_name)
                ? $t->first_name.' '.$t->last_name
                : '-'
        )

         ->addColumn('department_name', fn ($t) =>
            optional($t->department)->name ?? '-'
        )

            ->addColumn('designation_name', fn ($t) =>
            optional($t->designation)->name ?? '-'

        )


        ->addColumn('created_at', fn ($t) =>
            $this->formatDate($t->created_at)
        )

      ->make(true);
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