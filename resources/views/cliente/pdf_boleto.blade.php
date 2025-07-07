<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleto N° {{ $boleto->BolID }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background: #f5f5f5;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #0e1a4f;
        }
        .iconos {
            text-align: center;
            font-size: 36px;
            margin: 10px 0;
        }
        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        td, th {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .qr {
            text-align: center;
            margin-top: 30px;
        }
        .qr img {
            width: 150px;
            height: 150px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2> Boleto de Viaje</h2>
        <div class="iconos">🚆 ⛰️</div>

        <table>
            <tr><th>N° Boleto</th><td>{{ $boleto->BolID }}</td></tr>
            <tr><th>Cliente</th><td>{{ $boleto->usuario->UsuNombres }} {{ $boleto->usuario->UsuApellidos }}</td></tr>
            <tr><th>Origen</th><td>{{ $boleto->estacion_origen->EstNombre }}</td></tr>
            <tr><th>Destino</th><td>{{ $boleto->estacion_destino->EstNombre }}</td></tr>
            <tr><th>Fecha de viaje</th><td>{{ \Carbon\Carbon::parse($boleto->BolFechaviaje)->format('d/m/Y') }}</td></tr>
            <tr><th>Salida</th><td>{{ $boleto->BolHoraSalida }}</td></tr>
            <tr><th>Llegada</th><td>{{ $boleto->BolHoraLlegada }}</td></tr>
            <tr><th>Distancia</th><td>{{ $boleto->BolDistanciaKM }} km</td></tr>
            <tr><th>Personas</th><td>{{ $boleto->BolCantidadPersonas ?? 1 }}</td></tr>
            <tr><th>Precio por persona</th><td>S/ {{ number_format($boleto->BolPrecio / max($boleto->BolCantidadPersonas, 1), 2) }}</td></tr>
            <tr><th>Total pagado</th><td><strong>S/ {{ number_format($boleto->BolPrecio, 2) }}</strong></td></tr>
            <tr><th>Método de pago</th><td>{{ ucfirst($boleto->BolMetodoPago) }}</td></tr>
            <tr><th>Estado</th><td>{{ ucfirst($boleto->BolEstado) }}</td></tr>
        </table>

        <div class="qr">
            <p><strong>Escanea para verificar:</strong></p>
            {!! $qrCodeSvg !!}
        </div>
    </div>
</body>
</html>
