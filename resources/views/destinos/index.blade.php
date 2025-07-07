@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #0e1a4f, #a0ffd0);
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }

    h1 {
        text-align: center;
        margin-top: 20px;
    }

    .nuevo-link {
        display: block;
        width: fit-content;
        margin: 10px auto;
        background: #00c2ff;
        padding: 8px 14px;
        border-radius: 8px;
        text-align: center;
        color: white;
        font-weight: bold;
        text-decoration: none;
    }

    table {
        width: 95%;
        margin: 20px auto;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        border-radius: 12px;
        overflow: hidden;
    }

    th, td {
        padding: 12px;
        text-align: center;
        color: #fff;
    }

    th {
        background: rgba(255, 255, 255, 0.2);
        font-weight: bold;
    }

    td {
        background: rgba(255, 255, 255, 0.08);
    }

    tr:nth-child(even) td {
        background: rgba(255, 255, 255, 0.1);
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

    img {
        max-width: 100px;
        border-radius: 8px;
    }
</style>

<h1>🌄 Lista de Destinos Turísticos</h1>

<a href="{{ route('destinos.create') }}" class="nuevo-link">➕ Nuevo Destino</a>

@if($destinos->isEmpty())
    <p style="text-align:center;">No hay destinos registrados.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Ubicación</th>
                <th>Estación</th>
                <th>Tipo de Zona</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($destinos as $destino)
                <tr>
                    <td>{{ $destino->DesTNombre }}</td>
                    <td>{{ Str::limit($destino->DesTDescripcion, 50) }}</td>
                    <td>{{ $destino->DesTUbicacion }}</td>
                    <td>{{ $destino->estacion->EstNombre ?? 'N/A' }}</td>
                    <td>{{ $destino->tipoZona->TipZonaNombre ?? 'N/A' }}</td>
                    <td>
                        @if($destino->DesImagenURL)
                            <img src="{{ asset('storage/' . $destino->DesImagenURL) }}" alt="Imagen">
                        @else
                            Sin imagen
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('destinos.edit', $destino->DesTID) }}">✏️ Editar</a>
                        <form action="{{ route('destinos.destroy', $destino->DesTID) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este destino?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
