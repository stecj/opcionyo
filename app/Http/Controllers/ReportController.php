<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeReportExport;
use App\Services\ScheduleService;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function generateReport()
    {
        $report = $this->scheduleService->generateReport();
        return Excel::download(new EmployeeReportExport($report), 'employee_report.xlsx');
    }
}
