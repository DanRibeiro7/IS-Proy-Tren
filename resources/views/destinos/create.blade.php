@extends('layouts.app')

@section('content')
    <h1>Crear Destino Turístico</h1>

    <form method="POST" action="{{ route('destinos.store') }}" enctype="multipart/form-data">
        @csrf

        <label>Nombre:</label>
        <input type="text" name="DesTNombre" required><br>

        <label>Descripción:</label>
        <textarea name="DesTDescripcion" required></textarea><br>

        <label>Ubicación:</label>
        <input type="text" name="DesTUbicacion" required><br>
        <label>Tipo de zona turística:</label>
<select name="TipZonaID" required>
    @foreach ($tiposZona as $zona)
        <option value="{{ $zona->TipZonaID }}" {{ (old('TipZonaID', $destino->TipZonaID ?? '') == $zona->TipZonaID) ? 'selected' : '' }}>
            {{ $zona->TipZonaNombre }}
        </option>
    @endforeach
</select><br>


        <label>Imagen (desde tu PC):</label>
        <input type="file" name="DesImagen" accept="image/*" required><br>

        <label>Estación:</label>
        <select name="EstID" required>
            @foreach ($estaciones as $estacion)
                <option value="{{ $estacion->EstID }}">{{ $estacion->EstNombre }}</option>
            @endforeach
        </select><br>

        <button type="submit">Guardar</button>
    </form>
@endsection
