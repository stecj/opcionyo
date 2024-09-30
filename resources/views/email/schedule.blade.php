@extends('layouts.app')

@section('content')
    <h1>Enviar Horario por Email</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('email.send') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="employee">Médico:</label>
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
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <button type="submit">Enviar Horario</button>
    </form>
@endsection
