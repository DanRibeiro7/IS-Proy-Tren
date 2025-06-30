@extends('layouts.app')

@section('content')
    <h1>Registrar Clima</h1>

    <form method="POST" action="{{ route('climas.store') }}">
        @csrf

        <label>Fecha:</label>
        <input type="date" name="CliFecha" value="{{ old('CliFecha') }}"><br>

        <label>Clima:</label>
        <input type="text" name="CliClima" value="{{ old('CliClima') }}"><br>

        <label>Estación:</label>
        <select name="EstID">
            @foreach ($estaciones as $estacion)
                <option value="{{ $estacion->EstID }}">{{ $estacion->EstNombre }}</option>
            @endforeach
        </select><br>

        <button type="submit">Guardar</button>
    </form>
@endsection
