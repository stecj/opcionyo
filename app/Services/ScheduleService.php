<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Reservation;
use Carbon\Carbon;

class ScheduleService
{
    public function getEmployeeSchedule(Employee $employee, Carbon $start, Carbon $end)
    {
        $schedules = $employee->schedules()
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->get();

        $reservations = $employee->reservations()
            ->whereBetween('start_time', [$start, $end])
            ->get();

        return [
            'schedules' => $schedules,
            'reservations' => $reservations,
        ];
    }

    public function findAvailableEmployees(Carbon $dateTime)
    {
        $employees = Employee::all();
        foreach ($employees as $employee) {
            $localDateTime = $dateTime->copy()->setTimezone($employee->timezone);
            $schedule = $employee->schedules()
                ->where('date', $localDateTime->toDateString())
                ->where('start_time', '<=', $localDateTime->toTimeString())
                ->where('end_time', '>', $localDateTime->toTimeString())
                ->where('is_lunch', false)
                ->first();

            if ($schedule) {
                $reservation = $employee->reservations()
                    ->where('start_time', '<=', $dateTime)
                    ->where('end_time', '>', $dateTime)
                    ->first();

                if (!$reservation) {
                    return $employee;
                }
            }
        }

        return null;
    }

    public function generateReport()
    {
        $employees = Employee::all();
        $report = [];

        foreach ($employees as $employee) {
            $availableHours = $this->calculateAvailableHours($employee);
            $reservedHours = $this->calculateReservedHours($employee);

            $report[] = [
                'name' => $employee->name,
                'last_name' => $employee->last_name,
                'available_hours' => $availableHours,
                'reserved_hours' => $reservedHours,
            ];
        }

        return $report;
    }

    private function calculateAvailableHours(Employee $employee)
    {
        return $employee->schedules()
            ->where('is_lunch', false)
            ->sum(\DB::raw('TIMESTAMPDIFF(HOUR, start_time, end_time)'));
    }

    private function calculateReservedHours(Employee $employee)
    {
        return $employee->reservations()
            ->sum(\DB::raw('TIMESTAMPDIFF(HOUR, start_time, end_time)'));
    }
}
