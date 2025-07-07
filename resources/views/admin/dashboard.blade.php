<h2>🌟 Sugerencias para ti</h2>

<h3>Destinos sugeridos:</h3>
<ul>
@foreach($destinos as $destino)
    <li>
        <strong>{{ $destino->DesTNombre }}</strong> ({{ $destino->tipoZona->TipZonaNombre }})<br>
        Estación: {{ $destino->estacion->EstNombre }}<br>
        <img src="{{ asset('storage/' . $destino->DesImagenURL) }}" width="150">
    </li>
@endforeach
</ul>

<h3>Climas recomendados recientes:</h3>
<ul>
@foreach($climas as $clima)
    <li>
        📅 {{ $clima->CliFecha }} - 
        {{ $clima->tipoClima->TipClimaNombre }} 
        {!! climaEmoji($clima->tipoClima->TipClimaNombre) !!}
    </li>
@endforeach
</ul>
