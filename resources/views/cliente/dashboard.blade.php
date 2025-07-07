@extends('layouts.app')

@section('content')
<h2>🎯 Sugerencias personalizadas</h2>

<p><strong>Estación cercana:</strong> {{ $preferencias->estacion->EstNombre ?? 'Sin nombre' }}</p>
<p><strong>Zona turística preferida:</strong> {{ $preferencias->tipoZona->TipZonaNombre ?? '' }}</p>
<p><strong>Clima deseado:</strong> {{ climaEmoji($climas->first()->tipoClima->TipClimaNombre ?? '') }} {{ $climas->first()->tipoClima->TipClimaNombre ?? '' }}</p>

<hr>

<h3>🏞️ Destinos recomendados</h3>
@forelse($destinos as $destino)
    <div>
        <h4>{{ $destino->DesTNombre }}</h4>
        <p>{{ $destino->DesTDescripcion }}</p>
        <p><strong>Ubicación:</strong> {{ $destino->DesTUbicacion }}</p>
        <p><strong>Estación:</strong> {{ $destino->estacion->EstNombre }}</p>
        @if($destino->DesImagenURL)
            <img src="{{ asset('storage/' . $destino->DesImagenURL) }}" width="200">
        @endif
    </div>
    <hr>
@empty
    <p>No se encontraron destinos con tus preferencias actuales.</p>
@endforelse

<h3>🌤️ Clima reciente</h3>
@forelse($climas as $clima)
    <p>{{ $clima->CliFecha }} - {{ climaEmoji($clima->tipoClima->TipClimaNombre) }} {{ $clima->tipoClima->TipClimaNombre }}</p>
@empty
    <p>No hay registros recientes de clima para esta estación.</p>
@endforelse
@endsection
