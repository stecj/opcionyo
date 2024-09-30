<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeReportExport;

class ReportController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function generateForm()
    {
        return view('report.generate');
    }

    public function generateReport()
    {
        $report = $this->scheduleService->generateReport();
        return Excel::download(new EmployeeReportExport($report), 'employee_report.xlsx');
    }
}
