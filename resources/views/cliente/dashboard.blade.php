@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(to right, #0e1a4f, #a0ffd0);
        color: #fff;
    }

    h2, h3 {
        color: #fff;
        text-align: center;
        margin-top: 20px;
    }

    .card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 20px;
        margin: 20px auto;
        max-width: 700px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .card img {
        width: 100%;
        max-height: 180px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 10px;
    }

    .info-row {
        margin-bottom: 10px;
    }

    hr {
        border-color: rgba(255,255,255,0.2);
        margin: 40px auto;
        max-width: 80%;
    }

    .clima-linea {
        text-align: center;
        font-size: 1.1em;
        margin: 10px 0;
    }

    p {
        margin: 5px 0;
    }
</style>

<h2>🎯 Sugerencias Personalizadas</h2>

<div class="card">
    <div class="info-row"><strong>📍 Estación cercana:</strong> {{ $preferencias->estacion->EstNombre ?? 'Sin nombre' }}</div>
    <div class="info-row"><strong>🌄 Zona turística preferida:</strong> {{ $preferencias->tipoZona->TipZonaNombre ?? '' }}</div>
    <div class="info-row">
        <strong>🌤️ Clima deseado:</strong> {{ climaEmoji($climas->first()->tipoClima->TipClimaNombre ?? '') }}
        {{ $climas->first()->tipoClima->TipClimaNombre ?? '' }}
    </div>
</div>

<hr>

<h3>🏞️ Destinos Recomendados</h3>

@forelse($destinos as $destino)
    <div class="card">
        <h4>{{ $destino->DesTNombre }}</h4>
        <p>{{ $destino->DesTDescripcion }}</p>
        <p><strong>📍 Ubicación:</strong> {{ $destino->DesTUbicacion }}</p>
        <p><strong>🚉 Estación:</strong> {{ $destino->estacion->EstNombre }}</p>
        @if($destino->DesImagenURL)
            <img src="{{ asset('storage/' . $destino->DesImagenURL) }}" alt="Imagen de destino">
        @endif
    </div>
@empty
    <div class="card">
        <p>No se encontraron destinos con tus preferencias actuales.</p>
    </div>
@endforelse

<hr>

<h3>🌤️ Clima Reciente</h3>

@forelse($climas as $clima)
    <div class="clima-linea">
        📅 {{ $clima->CliFecha }} — {{ climaEmoji($clima->tipoClima->TipClimaNombre) }}
        {{ $clima->tipoClima->TipClimaNombre }}
    </div>
@empty
    <div class="card">
        <p>No hay registros recientes de clima para esta estación.</p>
    </div>
@endforelse
@endsection
