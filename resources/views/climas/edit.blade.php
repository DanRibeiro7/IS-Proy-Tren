@extends('layouts.app')

@section('content')
    <h1>Editar Clima</h1>

    <form method="POST" action="{{ route('climas.update', $clima->CliID) }}">
        @csrf
        @method('PUT')

        <label>Fecha:</label>
        <input type="date" name="CliFecha" value="{{ $clima->CliFecha }}"><br>

        <label>Clima:</label>
        <input type="text" name="CliClima" value="{{ $clima->CliClima }}"><br>

        <label>Estación:</label>
        <select name="EstID">
            @foreach ($estaciones as $estacion)
                <option value="{{ $estacion->EstID }}" {{ $clima->EstID == $estacion->EstID ? 'selected' : '' }}>
                    {{ $estacion->EstNombre }}
                </option>
            @endforeach
        </select><br>

        <button type="submit">Actualizar</button>
    </form>
@endsection
