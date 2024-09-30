<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            ['name' => 'Juan', 'last_name' => 'Pérez', 'timezone' => 'America/Bogota'],
            ['name' => 'María', 'last_name' => 'González', 'timezone' => 'America/Mexico_City'],
            ['name' => 'Carlos', 'last_name' => 'Rodríguez', 'timezone' => 'America/Santiago'],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
