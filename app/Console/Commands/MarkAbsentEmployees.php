<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AttendanceService;

class MarkAbsentEmployees extends Command
{
    protected $signature = 'attendance:mark-absent';
    protected $description = 'Mark absent employees who did not check in';

    protected $service;

    public function __construct(AttendanceService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle()
    {
        $this->service->markAbsent();
        $this->info('Absent employees marked successfully.');
    }
}
