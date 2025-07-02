@extends('layouts.app')

@section('content')
    <h2>🎫 Detalle de tu Boleto</h2>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>N° Boleto</th>
            <td>{{ $boleto->BolID }}</td>
        </tr>
        <tr>
            <th>Cliente</th>
            <td>{{ $boleto->usuario->UsuNombres }} {{ $boleto->usuario->UsuApellidos }}</td>
        </tr>
        <tr>
            <th>Ruta</th>
            <td>{{ $boleto->ruta->origen->EstNombre }} → {{ $boleto->ruta->destino->EstNombre }}</td>
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
            <th>Precio</th>
            <td>S/ {{ number_format($boleto->BolPrecio, 2) }}</td>
        </tr>
        <tr>
            <th>Estado</th>
            <td>{{ ucfirst($boleto->BolEstado) }}</td>
        </tr>
    </table>

    <br>

    <a href="{{ route('cliente.linea_tren') }}">⬅️ Volver a la Línea del Tren</a>
    <br>
    <a href="{{ route('cliente.comprar_boleto') }}">🎟️ Comprar otro boleto</a>
@endsection

