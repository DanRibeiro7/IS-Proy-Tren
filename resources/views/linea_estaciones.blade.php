@extends('layouts.app')

@section('content')
<h1>Línea de Estaciones</h1>

<div style="margin-bottom: 10px;">
    <strong>⏱ Tiempo de viaje:</strong> <span id="timer">0</span> segundos
</div>

<div id="train-line" style="position:relative; display:flex; align-items:center; gap:40px;">

    <!-- Tren flotante -->
    <div id="tren" style="position:absolute; top:-30px; left:0; transition: transform 1.5s ease; font-size: 24px;">🚆</div>

    @foreach ($estaciones as $estacion)
        <div class="station" data-id="{{ $estacion->EstID }}" style="cursor:pointer; text-align:center; position: relative;">
            <div class="circle" style="width:40px; height:40px; border-radius:50%; background:#3490dc; margin:auto;"></div>
            <div>{{ $estacion->EstNombre }}</div>
        </div>

        @if (!$loop->last)
            <div class="line" style="flex-grow:1; height:4px; background:#ccc;"></div>
        @endif
    @endforeach

</div>

<div id="info" style="margin-top:30px; border:1px solid #ccc; padding:15px; display:none;">
    <h3>Información de Estación</h3>
    <div id="info-content"></div>
    <div id="boleto" style="margin-top: 30px; border: 1px solid #ccc; padding: 15px; display: none;">
    <h3>Compra de Boleto</h3>
    <p><strong>Desde:</strong> <span id="origen"></span></p>
    <p><strong>Hasta:</strong> <span id="destino"></span></p>
    <p><strong>Distancia:</strong> <span id="distancia"></span> km</p>
    <p><strong>Costo:</strong> S/ <span id="costo"></span></p>
    <button onclick="comprarBoleto()">Comprar Boleto</button>
</div>
<div id="boleto-form" style="margin-top: 30px; display:none;">
    <h3>Comprar Boleto</h3>
    <form method="POST" action="{{ route('boletos.store') }}">
        @csrf
            <input type="hidden" name="estacion_origen_id" id="input-origen">
    <input type="hidden" name="estacion_destino_id" id="input-destino">
    <input type="hidden" name="distancia_km" id="input-distancia">
    <input type="hidden" name="precio" id="input-precio">
    <input type="hidden" name="ruta_id" id="input-ruta">
        <div>
            <label>Distancia estimada: <span id="distancia-text">0</span> km</label>
        </div>
        <div>
            <label>Precio total: S/ <span id="precio-text">0.00</span></label>
        </div>
        <button type="submit">Comprar</button>
    </form>
</div>

</div>

<script>
    const estaciones = @json($estaciones);
    const destinos = @json($destinos);
    const climas = @json($climas);
    const rutas = @json($rutas);

    let selectedStations = [];

    document.querySelectorAll('.station').forEach(stationDiv => {
        stationDiv.addEventListener('click', () => {
            const estId = parseInt(stationDiv.dataset.id);

            const destinoEstacion = destinos.filter(d => d.EstID === estId);
            const climaEstacion = climas.find(c => c.EstID === estId);

            let html = `<strong>Estación:</strong> ${stationDiv.innerText.trim()}<br>`;
            html += `<strong>Clima:</strong> ${climaEstacion ? climaEstacion.CliClima : 'No disponible'}<br>`;

            if(destinoEstacion.length > 0){
                html += `<strong>Zonas Turísticas:</strong><ul>`;
                destinoEstacion.forEach(d => {
                    html += `<li>${d.DesTNombre}</li>`;
                });
                html += `</ul>`;
            } else {
                html += `<strong>Zonas Turísticas:</strong> No hay zonas registradas.`;
            }

            document.getElementById('info-content').innerHTML = html;
            document.getElementById('info').style.display = 'block';

            if(selectedStations.length < 2 && !selectedStations.includes(estId)) {
                selectedStations.push(estId);
                stationDiv.querySelector('.circle').style.background = '#e3342f';
            }

            if(selectedStations.length === 2){
                highlightRoute(selectedStations[0], selectedStations[1]);
                    // Calcular distancia y costo
    const estacionesArr = Array.from(document.querySelectorAll('.station'));
    let startIndex = estacionesArr.findIndex(s => parseInt(s.dataset.id) === selectedStations[0]);
    let endIndex = estacionesArr.findIndex(s => parseInt(s.dataset.id) === selectedStations[1]);

    const estacionesEntre = Math.abs(endIndex - startIndex);
    const distancia = estacionesEntre * 5;
    const costo = distancia * 1; // 5 soles por 5km (es decir, 1 sol por km)

   // Rellenar formulario
  

    // Mostrar info en el panel
    document.getElementById('origen').textContent = estacionesArr[startIndex].innerText.trim();
    document.getElementById('destino').textContent = estacionesArr[endIndex].innerText.trim();
    document.getElementById('distancia').textContent = distancia;
    document.getElementById('costo').textContent = costo.toFixed(2);
    document.getElementById('boleto').style.display = 'block';

   document.getElementById('input-origen').value = selectedStations[0];
document.getElementById('input-destino').value = selectedStations[1];
 document.getElementById('input-precio').value = costo.toFixed(2);
document.getElementById('distancia-text').innerText = distancia;
document.getElementById('precio-text').innerText = costo.toFixed(2);

 document.getElementById('boleto').style.display = 'block';
    document.getElementById('boleto-form').style.display = 'block';
            }
        });
    });

    function highlightRoute(est1, est2) {
        document.querySelectorAll('.circle').forEach(c => c.style.background = '#3490dc');
        document.querySelectorAll('.line').forEach(l => l.style.background = '#ccc');

        document.querySelectorAll('.station').forEach(s => {
            const id = parseInt(s.dataset.id);
            if(id === est1 || id === est2) {
                s.querySelector('.circle').style.background = '#e3342f';
            }
        });

        const stationsArr = Array.from(document.querySelectorAll('.station'));
        let startIndex = stationsArr.findIndex(s => parseInt(s.dataset.id) === est1);
        let endIndex = stationsArr.findIndex(s => parseInt(s.dataset.id) === est2);

        if(startIndex > endIndex){
            [startIndex, endIndex] = [endIndex, startIndex];
        }

        for(let i = startIndex; i < endIndex; i++){
            const lineDiv = stationsArr[i].nextElementSibling;
            if(lineDiv && lineDiv.classList.contains('line')){
                lineDiv.style.background = '#e3342f';
            }
        }
    }
    function comprarBoleto() {
    alert('✅ ¡Boleto comprado con éxito!');
    // Aquí podrías hacer un fetch/ajax a una ruta para registrar la compra si lo deseas.
}

</script>

<script>
    // Tren animado + Timer
    document.addEventListener('DOMContentLoaded', () => {
        const estacionesDOM = document.querySelectorAll('.station');
        const tren = document.getElementById('tren');

        let index = 0;
        let direccion = 1;
        let segundos = 0;

        // Ubicar tren sobre la estación actual
        function posicionarTren() {
            const estacion = estacionesDOM[index];
            const rectEstacion = estacion.getBoundingClientRect();
            const rectLinea = document.getElementById('train-line').getBoundingClientRect();

            // Distancia horizontal desde el inicio del contenedor
            const offsetX = rectEstacion.left - rectLinea.left + 5;

            tren.style.transform = `translateX(${offsetX}px)`;
        }

        // Animar tren en intervalo
        function moverTren() {
            posicionarTren();

            index += direccion;

            if (index >= estacionesDOM.length) {
                direccion = -1;
                index = estacionesDOM.length - 2;
            } else if (index < 0) {
                direccion = 1;
                index = 1;
            }
        }

        // Iniciar temporizador
        setInterval(() => {
            segundos++;
            document.getElementById('timer').textContent = segundos;
        }, 1000);

        // Iniciar movimiento
        posicionarTren();
        setInterval(moverTren, 2000);
    });
</script>

@endsection
