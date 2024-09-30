<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition()
    {
        $date = $this->faker->dateTimeBetween('now', '+2 months')->format('Y-m-d');
        $startTime = Carbon::createFromTime(9, 0, 0);
        $endTime = $startTime->copy()->addHours(6);

        return [
            'employee_id' => Employee::factory(),
            'date' => $date,
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'is_lunch' => false,
        ];
    }
}
