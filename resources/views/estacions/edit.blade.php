@extends('layouts.app')

@section('content')
    <h1>Editar Estación</h1>

    <form action="{{ route('estacions.update', $estacion->EstID) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="EstNombre">Nombre:</label><br>
        <input type="text" name="EstNombre" id="EstNombre" value="{{ $estacion->EstNombre }}" required><br><br>

        <label for="EstUbicacion">Ubicación:</label><br>
        <input type="text" name="EstUbicacion" id="EstUbicacion" value="{{ $estacion->EstUbicacion }}" required><br><br>

        <button type="submit">Actualizar</button>
        <a href="{{ route('estacions.index') }}">Cancelar</a>
    </form>
@endsection
