@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #0e1a4f, #a0ffd0);
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }

    h2 {
        text-align: center;
        margin-top: 20px;
    }

    table {
        width: 90%;
        max-width: 800px;
        margin: 30px auto;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
    }

    th, td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    th {
        background: rgba(255, 255, 255, 0.15);
        font-weight: bold;
    }

    td {
        background: rgba(255, 255, 255, 0.05);
    }

    tr:last-child td {
        border-bottom: none;
    }

    .anulado {
        color: red;
        font-weight: bold;
    }

    .volver, .anular {
        display: inline-block;
        margin: 20px auto;
        text-align: center;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .volver {
        background: #0e1a4f;
        color: #fff;
    }

    .volver:hover {
        background: #1f3260;
    }

    .anular {
        background: #ff4c4c;
        color: #fff;
        border: none;
    }

    .anular:hover {
        background: #cc0000;
    }

    .mensaje-success {
        color: #00ffcc;
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
    }
</style>

<h2>🎫 Detalle de tu Boleto</h2>

@if(session('success'))
    <div class="mensaje-success">{{ session('success') }}</div>
@endif

<table>
    <tr>
        <th>N° Boleto</th>
        <td>{{ $boleto->BolID }}</td>
    </tr>
    <tr>
        <th>Cliente</th>
        <td>{{ $boleto->usuario->UsuNombres ?? 'N/A' }} {{ $boleto->usuario->UsuApellidos ?? '' }}</td>
    </tr>
    <tr>
        <th>Estación Origen</th>
        <td>{{ $boleto->estacion_origen->EstNombre ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>Estación Destino</th>
        <td>{{ $boleto->estacion_destino->EstNombre ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>Fecha de viaje</th>
        <td>{{ \Carbon\Carbon::parse($boleto->BolFechaviaje)->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <th>Hora de salida</th>
        <td>{{ $boleto->BolHoraSalida }}</td>
    </tr>
    <tr>
        <th>Hora estimada de llegada</th>
        <td>{{ $boleto->BolHoraLlegada }}</td>
    </tr>
    <tr>
        <th>Distancia</th>
        <td>{{ $boleto->BolDistanciaKM }} km</td>
    </tr>
    <tr>
        <th>Precio</th>
        <td>S/ {{ number_format($boleto->BolPrecio, 2) }}</td>
    </tr>
    <tr>
        <th>Método de pago</th>
        <td>{{ ucfirst($boleto->BolMetodoPago) }}</td>
    </tr>
    <tr>
        <th>Estado</th>
        <td>
            @if ($boleto->BolEstado === 'cancelado')
                <span class="anulado">Anulado</span>
            @else
                {{ ucfirst($boleto->BolEstado) }}
            @endif
        </td>
    </tr>
</table>

<div style="text-align:center;">
    @if ($boleto->BolEstado === 'pendiente')
        <form action="{{ route('cliente.anular_boleto', $boleto->BolID) }}" method="POST" onsubmit="return confirm('¿Estás seguro de anular este boleto?');" style="display:inline-block;">
            @csrf
            @method('PUT')
            <button type="submit" class="anular">❌ Anular Boleto</button>
        </form>
    @endif

    <br><br>
    <a class="volver" href="{{ route('cliente.linea_tren') }}">⬅️ Volver a la Línea del Tren</a>
</div>
@endsection
