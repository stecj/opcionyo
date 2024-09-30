@extends('layouts.app')

@section('content')
    <h1>Buscar Empleado Disponible</h1>
    <form action="{{ route('employee.available') }}" method="GET">
        <div class="form-group">
            <label for="datetime">Fecha y hora (New York):</label>
            <input type="datetime-local" name="datetime" id="datetime" required value="{{ request('datetime') }}">
        </div>
        <button type="submit">Buscar</button>
    </form>

    @if(isset($employee))
        <h2>Empleado Disponible</h2>
        <p>Nombre: {{ $employee->name }} {{ $employee->last_name }}</p>
        <p>Zona horaria: {{ $employee->timezone }}</p>
        <p>Hora local del empleado: {{ $localTime->format('Y-m-d H:i:s') }}</p>
        <p>Hora en New York: {{ $dateTime->format('Y-m-d H:i:s') }}</p>
    @elseif(isset($message))
        <p>{{ $message }}</p>
    @endif
@endsection
