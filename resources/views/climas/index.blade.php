@extends('layouts.app')

@section('content')
    <h1>Lista de Climas</h1>

    <a href="{{ route('climas.create') }}">Registrar nuevo clima</a>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Clima</th>
                <th>Estación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($climas as $clima)
                <tr>
                    <td>{{ $clima->CliFecha }}</td>
                    <td>{{ $clima->CliClima }}</td>
                    <td>{{ $clima->estacion->EstNombre ?? 'Sin estación' }}</td>
                    <td>
                        <a href="{{ route('climas.edit', $clima->CliID) }}">Editar</a>

                        <form action="{{ route('climas.destroy', $clima->CliID) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este clima?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
