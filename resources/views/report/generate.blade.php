@extends('layouts.app')

@section('content')
    <h1>Generar Reporte</h1>
    <form action="{{ route('report.download') }}" method="GET">
        <button type="submit">Descargar Reporte Excel</button>
    </form>
@endsection
