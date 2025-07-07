@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #0e1a4f, #a0ffd0);
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }

    h1 {
        text-align: center;
        margin-top: 20px;
    }

    form {
        width: 90%;
        max-width: 600px;
        margin: 20px auto;
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
    }

    input, textarea, select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: none;
        border-radius: 6px;
    }

    button {
        background: #00c2ff;
        color: white;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        width: 100%;
    }

    button:hover {
        background: #0099cc;
    }

    .volver {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #fff;
    }

    .volver:hover {
        text-decoration: underline;
    }

    .imagen-actual {
        display: block;
        margin: 10px 0;
        text-align: center;
    }

    .imagen-actual img {
        border-radius: 8px;
        max-width: 100%;
        height: auto;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }

    .error {
        color: #ff7b7b;
        font-size: 0.9em;
        margin-top: -10px;
        margin-bottom: 10px;
    }
</style>

<h1>✏️ Editar Destino Turístico</h1>

<form method="POST" action="{{ route('destinos.update', $destino->DesTID) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Nombre:</label>
    <input type="text" name="DesTNombre" value="{{ old('DesTNombre', $destino->DesTNombre) }}" required>
    @error('DesTNombre') <div class="error">{{ $message }}</div> @enderror

    <label>Descripción:</label>
    <textarea name="DesTDescripcion" rows="4" required>{{ old('DesTDescripcion', $destino->DesTDescripcion) }}</textarea>
    @error('DesTDescripcion') <div class="error">{{ $message }}</div> @enderror

    <label>Ubicación:</label>
    <input type="text" name="DesTUbicacion" value="{{ old('DesTUbicacion', $destino->DesTUbicacion) }}" required>
    @error('DesTUbicacion') <div class="error">{{ $message }}</div> @enderror

    <label>Tipo de zona turística:</label>
    <select name="TipZonaID" required>
        <option value="">Seleccione una opción</option>
        @foreach ($tiposZona as $zona)
            <option value="{{ $zona->TipZonaID }}" {{ old('TipZonaID', $destino->TipZonaID ?? '') == $zona->TipZonaID ? 'selected' : '' }}>
                {{ $zona->TipZonaNombre }}
            </option>
        @endforeach
    </select>
    @error('TipZonaID') <div class="error">{{ $message }}</div> @enderror

    <label>Imagen actual:</label>
    <div class="imagen-actual">
        @if($destino->DesImagenURL)
            <img src="{{ asset('storage/' . $destino->DesImagenURL) }}" alt="Imagen actual" width="200">
        @else
            <p>No hay imagen registrada.</p>
        @endif
    </div>

    <label>Actualizar Imagen (opcional):</label>
    <input type="file" name="DesImagen" accept="image/*">
    @error('DesImagen') <div class="error">{{ $message }}</div> @enderror

    <label>Estación asociada:</label>
    <select name="EstID" required>
        <option value="">Seleccione una estación</option>
        @foreach ($estaciones as $estacion)
            <option value="{{ $estacion->EstID }}" {{ old('EstID', $destino->EstID) == $estacion->EstID ? 'selected' : '' }}>
                {{ $estacion->EstNombre }}
            </option>
        @endforeach
    </select>
    @error('EstID') <div class="error">{{ $message }}</div> @enderror

    <button type="submit">💾 Actualizar destino</button>
</form>

<a class="volver" href="{{ route('destinos.index') }}">⬅️ Volver a la lista</a>
@endsection
