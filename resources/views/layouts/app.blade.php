<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Tren</title>
</head>
<body>
    <nav>
        <a href="{{ url('/') }}">Inicio</a> |
        <a href="{{ route('estacions.index') }}">Estaciones</a> |
        <a href="{{ route('destinos.index') }}">Destinos Turísticos</a> |
        <a href="{{ route('climas.index') }}">Climas</a> |
    </nav>

    <hr>

    <div>
        @yield('content')
    </div>
</body>
</html>
