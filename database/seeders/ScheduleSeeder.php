<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $startDate = Carbon::now()->startOfMonth();
        $endDate = $startDate->copy()->addMonths(2)->endOfMonth();

        while ($startDate <= $endDate) {
            if ($startDate->isWeekday()) {
                foreach ($employees as $employee) {
                    $this->createDailySchedule($employee, $startDate);
                }
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
}
