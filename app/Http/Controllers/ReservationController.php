<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create()
    {
        $employees = Employee::all();
        return view('reservation.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $startTime = Carbon::parse($request->date . ' ' . $request->time, $employee->timezone);
        $endTime = $startTime->copy()->addHour();

        // Convertir a la zona horaria de New York para almacenar
        $nyStartTime = $startTime->setTimezone('America/New_York');
        $nyEndTime = $endTime->setTimezone('America/New_York');

        Reservation::create([
            'employee_id' => $request->employee_id,
            'start_time' => $nyStartTime,
            'end_time' => $nyEndTime,
        ]);

        return redirect()->route('employee.schedule', ['employee' => $request->employee_id])
            ->with('success', 'Reserva creada exitosamente.');
    }
}
