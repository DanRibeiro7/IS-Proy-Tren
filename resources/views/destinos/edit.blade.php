@extends('layouts.app')

@section('content')
    <h1>Editar Destino Turístico</h1>

    <form method="POST" action="{{ route('destinos.update', $destino->DesTID) }}">
        @csrf
        @method('PUT')

        <label>Nombre:</label>
        <input type="text" name="DesTNombre" value="{{ $destino->DesTNombre }}"><br>

        <label>Descripción:</label>
        <textarea name="DesTDescripcion">{{ $destino->DesTDescripcion }}</textarea><br>

        <label>Ubicación:</label>
        <input type="text" name="DesTUbicacion" value="{{ $destino->DesTUbicacion }}"><br>

        <label>Estación:</label>
        <select name="EstID">
            @foreach ($estaciones as $estacion)
                <option value="{{ $estacion->EstID }}" {{ $destino->EstID == $estacion->EstID ? 'selected' : '' }}>
                    {{ $estacion->EstNombre }}
                </option>
            @endforeach
        </select><br>

        <button type="submit">Actualizar</button>
    </form>
@endsection
