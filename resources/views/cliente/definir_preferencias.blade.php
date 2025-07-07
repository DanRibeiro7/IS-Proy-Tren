@extends('layouts.app')

@section('content')
<h2>🧭 Definir tus preferencias</h2>

<form action="{{ route('cliente.preferencias.guardar') }}" method="POST">
    @csrf

    <label>Estación más cercana:</label>
    <select name="EstID" required>
        @foreach($estaciones as $est)
            <option value="{{ $est->EstID }}">{{ $est->EstNombre }}</option>
        @endforeach
    </select><br>

    <label>Tipo de zona turística preferida:</label>
    <select name="TipZonaID" required>
        @foreach($tiposZona as $zona)
            <option value="{{ $zona->TipZonaID }}">{{ $zona->TipZonaNombre }}</option>
        @endforeach
    </select><br>

    <label>Tipo de clima deseado:</label>
    <select name="TipClimaID" required>
        @foreach($tiposClima as $clima)
            <option value="{{ $clima->TipClimaID }}">{{ $clima->TipClimaNombre }}</option>
        @endforeach
    </select><br>

    <label>Distancia máxima desde estación (km):</label>
    <input type="number" name="PreUDistanciaMaxima" required step="0.1"><br>

    <button type="submit">✅ Guardar preferencias</button>
</form>
@endsection
