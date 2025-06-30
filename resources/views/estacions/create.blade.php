@extends('layouts.app')

@section('content')
    <h1>Crear Nueva Estación</h1>

    <form action="{{ route('estacions.store') }}" method="POST">
        @csrf

        <label for="EstNombre">Nombre:</label><br>
        <input type="text" name="EstNombre" id="EstNombre" required><br><br>

        <label for="EstUbicacion">Ubicación:</label><br>
        <input type="text" name="EstUbicacion" id="EstUbicacion" required><br><br>

        <button type="submit">Guardar</button>
        <a href="{{ route('estacions.index') }}">Cancelar</a>
    </form>
@endsection
