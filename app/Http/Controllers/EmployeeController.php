<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function scheduleForm(Request $request)
    {
        $employees = Employee::all();

        if ($request->filled(['employee', 'start_date', 'end_date'])) {
            $employee = Employee::findOrFail($request->employee);
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();

            $schedules = $employee->schedules()
                ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
                ->get();

            $reservations = $employee->reservations()
                ->whereBetween('start_time', [$start, $end])
                ->get()
                ->map(function ($reservation) use ($employee) {
                    $reservation->start_time = Carbon::parse($reservation->start_time)->setTimezone($employee->timezone);
                    $reservation->end_time = Carbon::parse($reservation->end_time)->setTimezone($employee->timezone);
                    return $reservation;
                });

            return view('employee.schedule', compact('employees', 'employee', 'schedules', 'reservations', 'start', 'end'));
        }

        return view('employee.schedule', compact('employees'));
    }

    public function availableForm(Request $request)
    {
        if ($request->filled('datetime')) {
            $dateTime = Carbon::parse($request->datetime)->setTimezone('America/New_York');
            $employee = $this->scheduleService->findAvailableEmployee($dateTime);

            if ($employee) {
                $localTime = $dateTime->copy()->setTimezone($employee->timezone);
                return view('employee.available', compact('employee', 'dateTime', 'localTime'));
            } else {
                $message = 'No hay empleados disponibles en ese momento.';
                return view('employee.available', compact('message'));
            }
        }

        return view('employee.available');
    }
}
