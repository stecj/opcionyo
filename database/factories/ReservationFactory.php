<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        $startTime = Carbon::instance($this->faker->dateTimeBetween('now', '+2 months'))
            ->setTime($this->faker->numberBetween(9, 15), 0, 0);
        $endTime = $startTime->copy()->addHour();

        return [
            'employee_id' => Employee::factory(),
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
    }
}
