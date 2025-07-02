<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido - Sistema de Tren</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            text-align: center;
            padding: 50px;
        }

        h1 {
            font-size: 2.5em;
        }

        .botones a {
            display: inline-block;
            margin: 20px;
            padding: 12px 24px;
            font-size: 1.1em;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .botones a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>🚆 Bienvenido al Sistema de Reservas de Tren</h1>
    <p>Explora las estaciones, destinos turísticos y compra tus boletos fácilmente.</p>

    <div class="botones">
        <a href="{{ route('login') }}">Iniciar Sesión</a>
        <a href="{{ route('register') }}">Registrarse</a>
    </div>

</body>
</html>
