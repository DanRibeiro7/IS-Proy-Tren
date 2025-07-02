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
            <td>
                {{ $boleto->usuario->UsuNombres ?? 'N/A' }} {{ $boleto->usuario->UsuApellidos ?? '' }}
            </td>
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
            <span style="color: red; font-weight: bold;">Anulado</span>
        @else
            {{ ucfirst($boleto->BolEstado) }}
        @endif
    </td>
</tr>

    </table>

    <br>
    @if ($boleto->BolEstado === 'pendiente')
    <form action="{{ route('cliente.anular_boleto', $boleto->BolID) }}" method="POST" onsubmit="return confirm('¿Estás seguro de anular este boleto?');">
        @csrf
        @method('PUT')
        <button type="submit" style="color:red;">❌ Anular Boleto</button>
    </form>
@endif


    <a href="{{ route('cliente.linea_tren') }}">⬅️ Volver a la Línea del Tren</a><br>
   
@endsection
