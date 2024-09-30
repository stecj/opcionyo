@extends('layouts.app')

@section('content')
    <h1>Crear Nueva Reserva</h1>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
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
            <label for="time">Hora (Zona horaria de New York):</label>
            <select name="time" id="time" required>
                @for($hour = 9; $hour <= 17; $hour++)
                    <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}</option>
                @endfor
            </select>
        </div>
        <button type="submit">Crear Reserva</button>
    </form>
@endsection
