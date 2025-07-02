@extends('layouts.app')

@section('content')
    <h2>📋 Historial de Boletos</h2>

    @if($boletos->isEmpty())
        <p>No has comprado ningún boleto aún.</p>
    @else
        @php
            $ultimoID = $boletos->max('BolID');
        @endphp

        <table border="1" cellpadding="8" cellspacing="0">
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
        <span style="color: red; font-weight: bold;">Anulado</span>
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
                                <button type="submit" style="color:red;">❌ Anular</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

    <br>
    <a href="{{ route('cliente.dashboard') }}">⬅️ Volver al Inicio</a>
@endsection
