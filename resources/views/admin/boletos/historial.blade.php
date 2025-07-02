@extends('layouts.app')

@section('content')
    <h2>📜 Historial de Boletos</h2>

    @if($boletos->isEmpty())
        <p>No se han registrado boletos aún.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha Compra</th>
                <th>Estado</th>
            </tr>
            @foreach($boletos as $boleto)
                <tr>
                    <td>{{ $boleto->BolID }}</td>
                    <td>{{ $boleto->usuario->UsuNombres }} {{ $boleto->usuario->UsuApellidos }}</td>
                    <td>{{ $boleto->estacion_origen->EstNombre }}</td>
                    <td>{{ $boleto->estacion_destino->EstNombre }}</td>
                    <td>{{ $boleto->BolFechaviaje }}</td>
                    <td>{{ ucfirst($boleto->BolEstado) }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <br>
    <a href="{{ route('admin.dashboard') }}">⬅️ Volver al panel</a>
@endsection
