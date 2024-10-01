<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailScheduleController extends Controller
{
    public function showForm()
    {
        $employees = Employee::all();
        return view('email.schedule', compact('employees'));
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'email' => 'required|email',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $date = $request->date;

        $schedules = Schedule::where('employee_id', $employee->id)
            ->whereDate('date', $date)
            ->get();

        $reservations = Reservation::where('employee_id', $employee->id)
            ->whereDate('start_time', $date)
            ->get();

        // Crear el contenido del email
        $emailContent = "Horario diario para {$employee->name} {$employee->last_name}\n";
        $emailContent .= "Fecha: {$date}\n\n";
        $emailContent .= "Horarios de trabajo:\n";
        foreach ($schedules as $schedule) {
            $emailContent .= "- " . Carbon::parse($schedule->start_time)->format('H:i') . " - " . Carbon::parse($schedule->end_time)->format('H:i');
            $emailContent .= $schedule->is_lunch ? " (Almuerzo)\n" : "\n";
        }
        $emailContent .= "\nReservaciones:\n";
        foreach ($reservations as $reservation) {
            $emailContent .= "- " . Carbon::parse($reservation->start_time)->format('H:i') . " - " . Carbon::parse($reservation->end_time)->format('H:i') . "\n";
        }

        // Loguear la información
        Log::info('Simulación de envío de email', [
            'to' => $request->email,
            'subject' => 'Horario diario para ' . $employee->name . ' ' . $employee->last_name,
            'content' => $emailContent
        ]);

        return back()->with('success', 'En entorno local: Horario registrado en los logs.');
    }
}
