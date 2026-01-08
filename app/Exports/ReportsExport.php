<?php

namespace App\Exports;

use App\Models\Tenant\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filter;
    protected $from;
    protected $to;

    public function __construct($filter, $from = null, $to = null)
    {
        $this->filter = $filter;
        $this->from   = $from;
        $this->to     = $to;
    }

    public function collection()
    {
        $query = Report::with('employee.department', 'employee.designation');


        if ($this->from && $this->to) {
            $query->whereBetween('report_date', [
                Carbon::parse($this->from)->startOfDay(),
                Carbon::parse($this->to)->endOfDay()
            ]);
        } else {
            if ($this->filter === 'daily') {
                $query->whereDate('report_date', now());
            }

            if ($this->filter === 'weekly') {
                $query->whereBetween('report_date', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
            }

            if ($this->filter === 'monthly') {
                $query->whereMonth('report_date', now()->month)
                      ->whereYear('report_date', now()->year);
            }
        }

        return $query->orderBy('report_date','desc')->get();
    }

    public function headings(): array
    {
        return ['Employee Name', 'Department', 'Title', 'Report Date', 'Status'];
    }

    public function map($row): array
    {
       return [
            optional($row->employee)->first_name.' '.optional($row->employee)->last_name,
            optional($row->employee->department)->name ?? '-',
            optional($row->employee->designation)->name ?? '-',
            $row->title,
            Carbon::parse($row->report_date)->format('d-m-Y'),
            $row->status ? 'Active' : 'Inactive',
        ];

    }
}