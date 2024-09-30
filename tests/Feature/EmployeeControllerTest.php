<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_employee_schedule()
    {
        $employee = Employee::factory()->create();
        $response = $this->getJson("/api/employees/{$employee->id}/schedule?start_date=2024-01-01&end_date=2024-01-07");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'schedules',
                'reservations'
            ]);
    }

    public function test_find_available_employee()
    {
        Employee::factory()->count(3)->create();
        $response = $this->getJson("/api/employees/available?datetime=2024-01-01 10:00:00");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'last_name',
                'timezone'
            ]);
    }
}
