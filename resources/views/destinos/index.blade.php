@extends('layouts.app')

@section('content')
    <h1>Destinos Turísticos</h1>
    <a href="{{ route('destinos.create') }}">Crear nuevo destino</a>

    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Ubicación</th>
                <th>Estación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($destinos as $destino)
                <tr>
                    <td>{{ $destino->DesTNombre }}</td>
                    <td>{{ $destino->DesTDescripcion }}</td>
                    <td>{{ $destino->DesTUbicacion }}</td>
                    <td>{{ $destino->estacion->EstNombre ?? 'No asignado' }}</td>
                    <td>
                        <a href="{{ route('destinos.edit', $destino->DesTID) }}">Editar</a>
                        <form action="{{ route('destinos.destroy', $destino->DesTID) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
