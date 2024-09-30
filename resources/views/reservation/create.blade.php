@extends('layouts.app')

@section('content')
    <h1>Crear Reserva</h1>
    <form action="{{ route('reservation.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="employee">Empleado:</label>
            <select name="employee_id" id="employee" required>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }} {{ $employee->last_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="date">Fecha:</label>
            <input type="date" name="date" id="date" required>
        </div>
        <div class="form-group">
            <label for="time">Hora:</label>
            <input type="time" name="time" id="time" required>
        </div>
        <button type="submit">Crear Reserva</button>
    </form>
@endsection
