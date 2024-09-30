@extends('layouts.app')

@section('content')
    <h1>Horario de Empleado</h1>
    <form action="{{ route('employee.schedule') }}" method="GET">
        <div class="form-group">
            <label for="employee">Empleado:</label>
            <select name="employee" id="employee" required>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ isset($employee) && $employee->id == $emp->id ? 'selected' : '' }}>
                        {{ $emp->name }} {{ $emp->last_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="start_date">Fecha de inicio:</label>
            <input type="date" name="start_date" id="start_date" required value="{{ request('start_date') }}">
        </div>
        <div class="form-group">
            <label for="end_date">Fecha de fin:</label>
            <input type="date" name="end_date" id="end_date" required value="{{ request('end_date') }}">
        </div>
        <button type="submit">Ver Horario</button>
    </form>

    @if(isset($employee))
        <h2>Horario de {{ $employee->name }} {{ $employee->last_name }}</h2>

        <h3>Horarios de trabajo</h3>
        @if(isset($schedules) && $schedules->isNotEmpty())
            <table class="centered-table">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora inicio (Local)</th>
                    <th>Hora fin (Local)</th>
                    <th>Hora inicio (New York)</th>
                    <th>Hora fin (New York)</th>
                    <th>Almuerzo</th>
                </tr>
                </thead>
                <tbody>
                @foreach($schedules as $s)
                    <tr>
                        <td>{{ $s->formatted_date }}</td>
                        <td>{{ Carbon\Carbon::parse($s->start_time)->setTimezone($employee->timezone)->format('H:i') }}</td>
                        <td>{{ Carbon\Carbon::parse($s->end_time)->setTimezone($employee->timezone)->format('H:i') }}</td>
                        <td>{{ Carbon\Carbon::parse($s->start_time)->setTimezone('America/New_York')->format('H:i') }}</td>
                        <td>{{ Carbon\Carbon::parse($s->end_time)->setTimezone('America/New_York')->format('H:i') }}</td>
                        <td>{{ $s->is_lunch ? 'Sí' : 'No' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No hay horarios de trabajo para mostrar.</p>
        @endif

        <h3>Reservas</h3>
        @if(isset($reservations) && $reservations->isNotEmpty())
            <table class="centered-table">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora inicio (Local)</th>
                    <th>Hora fin (Local)</th>
                    <th>Hora inicio (New York)</th>
                    <th>Hora fin (New York)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reservations as $r)
                    <tr>
                        <td>{{ $r->formatted_date }}</td>
                        <td>{{ $r->start_time->setTimezone($employee->timezone)->format('H:i') }}</td>
                        <td>{{ $r->end_time->setTimezone($employee->timezone)->format('H:i') }}</td>
                        <td>{{ $r->start_time->setTimezone('America/New_York')->format('H:i') }}</td>
                        <td>{{ $r->end_time->setTimezone('America/New_York')->format('H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No hay reservaciones para mostrar.</p>
        @endif
    @endif
@endsection
