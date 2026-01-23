<?php

namespace App\Exports;
use App\Models\Tenant\Employee;
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
        $query = Employee::with(['department','designation']);


        if ($this->from && $this->to) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->from)->startOfDay(),
                Carbon::parse($this->to)->endOfDay()
            ]);
        } else {
            if ($this->filter === 'daily') {
                $query->whereDate('created_at', now());
            }

            if ($this->filter === 'weekly') {
                $query->whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
            }

            if ($this->filter === 'monthly') {
                $query->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
            }
        }

        return $query->orderBy('id','desc')->get();
    }

    public function headings(): array
    {
        return ['Employee Name', 'Department', 'Report Date'];
    }

    public function map($row): array
    {
       return [
            optional($row)->first_name.' '.optional($row)->last_name,
            optional($row->department)->name ?? '-',
            optional($row->designation)->name ?? '-',
            Carbon::parse($row->created_at)->format('d-m-Y'),
        ];

    }
}
