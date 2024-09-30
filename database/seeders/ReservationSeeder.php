<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $startDate = Carbon::now()->startOfMonth();
        $endDate = $startDate->copy()->addMonths(2)->endOfMonth();

        while ($startDate <= $endDate) {
            if ($startDate->isWeekday()) {
                foreach ($employees as $employee) {
                    $this->createWeeklyReservations($employee, $startDate);
                }
            }
            $startDate->addWeek();
        }
    }

    private function createWeeklyReservations($employee, $date)
    {
        for ($i = 0; $i < 8; $i++) {
            $startTime = $date->copy()->setTime(rand(9, 15), 0, 0);
            $endTime = $startTime->copy()->addHour();

            Reservation::create([
                'employee_id' => $employee->id,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);
        }
    }
}
