@extends('layouts.app')

@section('content')
    <h1>Crear Destino Turístico</h1>

    <form method="POST" action="{{ route('destinos.store') }}">
        @csrf
        <label>Nombre:</label>
        <input type="text" name="DesTNombre"><br>

        <label>Descripción:</label>
        <textarea name="DesTDescripcion"></textarea><br>

        <label>Ubicación:</label>
        <input type="text" name="DesTUbicacion"><br>

        <label>Estación:</label>
        <select name="EstID">
            @foreach ($estaciones as $estacion)
                <option value="{{ $estacion->EstID }}">{{ $estacion->EstNombre }}</option>
            @endforeach
        </select><br>

        <button type="submit">Guardar</button>
    </form>
@endsection
