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
        $startTime = Carbon::parse($request->date . ' ' . $request->time, 'America/New_York');
        $endTime = $startTime->copy()->addHour();

        // Verificar si ya existe una reserva para esa hora
        $existingReservation = Reservation::where('employee_id', $request->employee_id)
            ->where(function($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime]);
            })
            ->first();

        if ($existingReservation) {
            return redirect()->back()->with('error', 'Ya existe una reserva para esa hora. Por favor, seleccione otra hora.');
        }

        Reservation::create([
            'employee_id' => $request->employee_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        return redirect()->route('employee.schedule', ['employee' => $request->employee_id])
            ->with('success', 'Reserva creada exitosamente.');
    }
}
