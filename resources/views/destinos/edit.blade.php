@extends('layouts.app')

@section('content')
    <h1>Editar Destino Turístico</h1>

    <form method="POST" action="{{ route('destinos.update', $destino->DesTID) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Nombre:</label>
        <input type="text" name="DesTNombre" value="{{ $destino->DesTNombre }}" required><br>

        <label>Descripción:</label>
        <textarea name="DesTDescripcion" required>{{ $destino->DesTDescripcion }}</textarea><br>

        <label>Ubicación:</label>
        <input type="text" name="DesTUbicacion" value="{{ $destino->DesTUbicacion }}" required><br>
        
        <label>Tipo de zona turística:</label>
<select name="TipZonaID" required>
    @foreach ($tiposZona as $zona)
        <option value="{{ $zona->TipZonaID }}" {{ (old('TipZonaID', $destino->TzID ?? '') == $zona->TipZonaID) ? 'selected' : '' }}>
            {{ $zona->TipZonaNombre }}
        </option>
    @endforeach
</select><br>

        <label>Imagen actual:</label><br>
        @if($destino->DesImagenURL)
            <img src="{{ asset('storage/' . $destino->DesImagenURL) }}" alt="Imagen actual" width="200"><br>
        @endif

        <label>Actualizar Imagen (opcional):</label>
        <input type="file" name="DesImagen" accept="image/*"><br>

        <label>Estación:</label>
        <select name="EstID" required>
            @foreach ($estaciones as $estacion)
                <option value="{{ $estacion->EstID }}" {{ $destino->EstID == $estacion->EstID ? 'selected' : '' }}>
                    {{ $estacion->EstNombre }}
                </option>
            @endforeach
        </select><br>

        <button type="submit">Actualizar</button>
    </form>
@endsection
