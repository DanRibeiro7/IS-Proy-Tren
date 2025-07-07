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
        width: 95%;
        max-width: 1000px;
        margin: 20px auto;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        border-radius: 12px;
        overflow: hidden;
    }

    th, td {
        padding: 12px 15px;
        text-align: center;
    }

    th {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        font-weight: bold;
    }

    td {
        background-color: rgba(255, 255, 255, 0.05);
        color: #fff;
    }

    tr:nth-child(even) td {
        background-color: rgba(255, 255, 255, 0.08);
    }

    a, button {
        color: #00f3ff;
        text-decoration: none;
        font-weight: bold;
        background: none;
        border: none;
        cursor: pointer;
    }

    button:hover, a:hover {
        text-decoration: underline;
    }

    .anulado {
        color: red;
        font-weight: bold;
    }

    .volver {
        display: block;
        text-align: center;
        margin-top: 30px;
        color: #fff;
    }

    .volver:hover {
        text-decoration: underline;
    }
</style>

<h2>📋 Historial de Boletos</h2>

@if($boletos->isEmpty())
    <p style="text-align:center;">No has comprado ningún boleto aún.</p>
@else
    @php
        $ultimoID = $boletos->max('BolID');
    @endphp

    <table>
        <tr>
            <th>N°</th>
            <th>Origen → Destino</th>
            <th>Fecha</th>
            <th>Hora Salida</th>
            <th>Precio</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
        @foreach($boletos as $boleto)
            <tr>
                <td>{{ $boleto->BolID }}</td>
                <td>{{ $boleto->estacion_origen->EstNombre }} → {{ $boleto->estacion_destino->EstNombre }}</td>
                <td>{{ \Carbon\Carbon::parse($boleto->BolFechaviaje)->format('d/m/Y') }}</td>
                <td>{{ $boleto->BolHoraSalida }}</td>
                <td>S/ {{ number_format($boleto->BolPrecio, 2) }}</td>
                <td>
                    @if ($boleto->BolEstado === 'cancelado')
                        <span class="anulado">Anulado</span>
                    @else
                        {{ ucfirst($boleto->BolEstado) }}
                    @endif
                </td>
                <td>
                    <a href="{{ route('cliente.ver_boleto', $boleto->BolID) }}">🔍 Ver</a>
                    @if ($boleto->BolEstado === 'pendiente' && $boleto->BolID === $ultimoID)
                        <form action="{{ route('cliente.anular_boleto', $boleto->BolID) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit">❌ Anular</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endif

<a class="volver" href="{{ route('cliente.dashboard') }}">⬅️ Volver al Inicio</a>
@endsection
