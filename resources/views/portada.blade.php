<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido - Sistema de Tren</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #0e1a4f, #a0ffd0);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #fff;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 15px;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .botones a {
            display: inline-block;
            margin: 10px;
            padding: 14px 28px;
            font-size: 1.1em;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .botones a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="card">
        <h1>🚆 Bienvenido al Sistema del Tren Turisitico</h1>
        <p>Explora las estaciones, destinos turísticos y compra tus boletos fácilmente.</p>

        <div class="botones">
            <a href="{{ route('login') }}">Iniciar Sesión</a>
            <a href="{{ route('register') }}">Registrarse</a>
        </div>
    </div>

</body>
</html>
