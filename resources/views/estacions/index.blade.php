@extends('layouts.app')

@section('content')
    <h1>Listado de Estaciones</h1>

    <a href="{{ route('estacions.create') }}">➕ Nueva Estación</a>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estaciones as $estacion)
                <tr>
                    <td>{{ $estacion->EstNombre }}</td>
                    <td>{{ $estacion->EstUbicacion }}</td>
                    <td>
                        <a href="{{ route('estacions.edit', $estacion->EstID) }}">✏️ Editar</a>
                        |
                        <form action="{{ route('estacions.destroy', $estacion->EstID) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection


