<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Horarios</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<div class="container">
    <div class="current-time">
        Hora actual (New York): <span id="current-time"></span>
    </div>
    <nav>
        <ul>
            <li><a href="{{ route('home') }}">Inicio</a></li>
            <li><a href="{{ route('employee.schedule') }}">Horario de Empleado</a></li>
            <li><a href="{{ route('employee.available') }}">Empleado Disponible</a></li>
            <li><a href="{{ route('reservation.create') }}" class="btn">Crear Reserva</a></li>
            <li><a href="{{ route('report.generate') }}">Generar Reporte</a></li>
        </ul>
    </nav>

    @yield('content')
</div>

<script>
    function updateTime() {
        const now = new Date();
        const nyTime = new Date(now.toLocaleString('en-US', { timeZone: 'America/New_York' }));
        document.getElementById('current-time').textContent = nyTime.toLocaleTimeString('es-ES', { hour12: false });
    }
    updateTime();
    setInterval(updateTime, 1000);
</script>
</body>
</html>
