<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Reservation;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            ['name' => 'Juan', 'last_name' => 'Pérez', 'timezone' => 'America/Bogota'],
            ['name' => 'María', 'last_name' => 'González', 'timezone' => 'America/Mexico_City'],
            ['name' => 'Carlos', 'last_name' => 'Rodríguez', 'timezone' => 'America/Santiago'],
        ];

        foreach ($employees as $employeeData) {
            $employee = Employee::create($employeeData);
            $this->createSchedulesForEmployee($employee);
            $this->createReservationsForEmployee($employee);
        }
    }

    private function createSchedulesForEmployee($employee)
    {
        $startDate = Carbon::create(2024, 10, 1);
        $endDate = $startDate->copy()->addDays(6);

        while ($startDate <= $endDate) {
            if ($startDate->isWeekday()) {
                $this->createDailySchedule($employee, $startDate);
            }
            $startDate->addDay();
        }
    }

    private function createDailySchedule($employee, $date)
    {
        $workStart = $date->copy()->setTime(9, 0);
        $lunchStart = $date->copy()->setTime(12, 0);
        $lunchEnd = $date->copy()->setTime(13, 0);
        $workEnd = $date->copy()->setTime(16, 0);

        Schedule::create([
            'employee_id' => $employee->id,
            'date' => $date->toDateString(),
            'start_time' => $workStart->toTimeString(),
            'end_time' => $lunchStart->toTimeString(),
            'is_lunch' => false,
        ]);

        Schedule::create([
            'employee_id' => $employee->id,
            'date' => $date->toDateString(),
            'start_time' => $lunchStart->toTimeString(),
            'end_time' => $lunchEnd->toTimeString(),
            'is_lunch' => true,
        ]);

        Schedule::create([
            'employee_id' => $employee->id,
            'date' => $date->toDateString(),
            'start_time' => $lunchEnd->toTimeString(),
            'end_time' => $workEnd->toTimeString(),
            'is_lunch' => false,
        ]);
    }

    private function createReservationsForEmployee($employee)
    {
        $startDate = Carbon::create(2024, 10, 1);
        $endDate = $startDate->copy()->addDays(6);

        while ($startDate <= $endDate) {
            if ($startDate->isWeekday()) {
                $this->createDailyReservations($employee, $startDate);
            }
            $startDate->addDay();
        }
    }

    private function createDailyReservations($employee, $date)
    {
        $reservationCount = rand(1, 3); // Random number of reservations per day (1 to 3)

        for ($i = 0; $i < $reservationCount; $i++) {
            $startHour = rand(9, 15); // Random start hour between 9 AM and 3 PM
            $startTime = $date->copy()->setTime($startHour, 0, 0);
            $endTime = $startTime->copy()->addHour();

            Reservation::create([
                'employee_id' => $employee->id,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);
        }
    }
}
