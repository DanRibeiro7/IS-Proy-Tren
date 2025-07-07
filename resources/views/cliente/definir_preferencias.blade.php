@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #0e1a4f, #a0ffd0);
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }

    h2 {
        text-align: center;
        margin-top: 20px;
        font-size: 2em;
    }

    form {
        background: rgba(255, 255, 255, 0.1);
        max-width: 600px;
        margin: 30px auto;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #fff;
    }

    select, input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: none;
        background: #fff;
        color: #333;
        font-size: 1em;
    }

    button {
        background-color: #28a745;
        color: white;
        padding: 12px 20px;
        font-size: 1em;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        width: 100%;
    }

    button:hover {
        background-color: #218838;
    }
</style>

<h2>🧭 Definir tus Preferencias</h2>

<form action="{{ route('cliente.preferencias.guardar') }}" method="POST">
    @csrf

   <!-- Estación más cercana -->
<select name="EstID" id="EstID" required>
    <option value="">-- Selecciona una estación --</option>
    @foreach($estaciones as $est)
        <option value="{{ $est->EstID }}">{{ $est->EstNombre }}</option>
    @endforeach
</select>

<!-- Tipo de zona -->
<select name="TipZonaID" id="TipZonaID" required>
    <option value="">-- Selecciona un tipo de zona --</option>
    @foreach($tiposZona as $zona)
        <option value="{{ $zona->TipZonaID }}">{{ $zona->TipZonaNombre }}</option>
    @endforeach
</select>

<!-- Tipo de clima -->
<select name="TipClimaID" id="TipClimaID" required>
    <option value="">-- Selecciona un tipo de clima --</option>
    @foreach($tiposClima as $clima)
        <option value="{{ $clima->TipClimaID }}">{{ $clima->TipClimaNombre }}</option>
    @endforeach
</select>

<!-- Distancia máxima -->
<input type="number" name="PreUDistanciaMaxima" id="PreUDistanciaMaxima"
    required step="0.1" min="0.1" max="1000"
    placeholder="Ej. 10.5"
    title="Ingresa una distancia válida entre 0.1 y 1000 km">


    <button type="submit">✅ Guardar preferencias</button>
</form>
@endsection
