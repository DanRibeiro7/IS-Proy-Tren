@extends('layouts.app')

@section('content') {{-- 🔧 Aquí empieza la sección correcta --}}

@if(Auth::user()->rol === 'cliente')
    <p>Estás navegando como <strong>Cliente</strong>.</p>
@elseif(Auth::user()->rol === 'admin')
    <p>Estás navegando como <strong>Administrador</strong>.</p>
@endif

@section('content')
<div id="mensaje-alerta" style="
    display: none;
    margin-top: 20px;
    padding: 10px;
    border: 1px solid #f5c6cb;
    background-color: #f8d7da;
    color: #721c24;
    border-radius: 5px;
    font-weight: bold;
">
</div>

@if(session('success'))
    <div style="background: #d4edda; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb;">
        {{ session('error') }}
    </div>
@endif

<h1>Línea de Estaciones</h1>

<div style="margin-bottom: 10px;">
    <strong>⏱ Tiempo de viaje:</strong> <span id="timer">0</span> segundos
</div>
<div style="margin-bottom: 10px;">
    <strong>🚦 Estado del tren:</strong> <span id="estado-tren">Cargando...</span>
</div>


<div id="train-line" style="position:relative; display:flex; align-items:center; gap:40px;">

    <!-- Tren flotante -->
    <div id="tren" style="position:absolute; top:-30px; left:0; transition: transform 1.5s ease; font-size: 24px;">🚆</div>

    @foreach ($estaciones as $estacion)
       <div id="estacion-{{ $estacion->EstID }}" class="station" data-id="{{ $estacion->EstID }}" style="cursor:pointer; text-align:center; position: relative;">

            <div class="circle" style="width:40px; height:40px; border-radius:50%; background:#3490dc; margin:auto;"></div>
            <div>{{ $estacion->EstNombre }}</div>
        </div>

        @if (!$loop->last)
            <div class="line" style="flex-grow:1; height:4px; background:#ccc;"></div>
        @endif
    @endforeach

</div>
<!-- Evaluar si el tren ya pasó por esta estación -->






<div id="info" style="margin-top:30px; border:1px solid #ccc; padding:15px; display:none;">
    <h3>Información de Estación</h3>
   

    <div id="info-content"></div>
    <div id="tiempo-espera-info" style="margin-top: 10px; display:none; font-weight: bold; color: #ff6600;">
    ⏳ <span id="texto-tiempo-espera"></span>
</div>

     <button id="activar-compra" onclick="iniciarCompra()">🎟️ Comprar Boleto</button>
    
<div id="boleto-form" style="margin-top: 30px; display:none;">
    <h3>Comprar Boleto</h3>
    @dump(session()->token())
    <form method="POST" action="{{ route('boleto.store') }}">
        @csrf
        <input type="hidden" name="estacion_origen_id" id="input-origen">
        <input type="hidden" name="estacion_destino_id" id="input-destino">
        <input type="hidden" name="precio" id="input-precio">
        <input type="hidden" name="distancia_km" id="input-distancia">
        <input type="hidden" name="ruta_id" id="input-ruta">

       

        <div>
            <label>Distancia estimada: <span id="distancia-text">0</span> km</label>
        </div>
        <div>
            <label>Precio total: S/ <span id="precio-text">0.00</span></label>
        </div>
        <div>
    <label for="metodo_pago">Método de pago:</label>
    <select name="metodo_pago" required>
        <option value="tarjeta">Tarjeta</option>
        <option value="efectivo">Efectivo</option>
        <option value="yape">Yape</option>
    </select>
</div>

<div>
    <label for="hora_llegada">Hora estimada de llegada:</label>
    <span id="hora-estimada-llegada">--:--</span>
</div>


        <button type="submit">Comprar</button>
    </form>
    <button onclick="resetSeleccion()" style="margin-top:10px;">🔄 Reiniciar Selección</button>

</div>


</div>

<script>
    const estaciones = @json($estaciones);
    const destinos = @json($destinos);
    const climas = @json($climas);
    const rutas = @json($rutas);

    let selectedStations = [];
     let rutaActualGlobal = 1;
     let modoCompraActivo = false;

     function mostrarAlerta(mensaje) {
    const alertaDiv = document.getElementById('mensaje-alerta');
    alertaDiv.textContent = mensaje;
    alertaDiv.style.display = 'block';

    setTimeout(() => {
        alertaDiv.style.display = 'none';
    }, 7000); // se oculta después de 5 segundos
}

function iniciarCompra() {
      if (selectedStations.length < 2) {
         mostrarAlerta("Por favor, selecciona estación de origen y destino haciendo clic en la estacion deseada.");
    }
    modoCompraActivo = true;
    selectedStations = [];
    document.getElementById('boleto-form').style.display = 'none';
    document.querySelectorAll('.circle').forEach(c => c.style.background = '#3490dc');
    document.querySelectorAll('.line').forEach(l => l.style.background = '#ccc');
}

     function trenRutaActual() {
    return rutaActualGlobal || 1; // default a 1 si aún no cargó
}

    function resetSeleccion() {
 modoCompraActivo = false;

    selectedStations = [];
    document.getElementById('boleto-form').style.display = 'none';
    document.querySelectorAll('.circle').forEach(c => c.style.background = '#3490dc');
    document.querySelectorAll('.line').forEach(l => l.style.background = '#ccc');
    document.getElementById('tiempo-espera-info').style.display = 'none';

}

  


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

       if (modoCompraActivo && selectedStations.length < 2 && !selectedStations.includes(estId)) {
    selectedStations.push(estId);
    stationDiv.querySelector('.circle').style.background = '#e3342f';

    if (selectedStations.length === 1) {
        // Llamar a la API para ver si el tren ya pasó por esta estación
        fetch(`/api/tiempo-espera/${estId}`)
            .then(res => res.json())
            .then(data => {
                const esperaDiv = document.getElementById('tiempo-espera-info');
                const textoEspera = document.getElementById('texto-tiempo-espera');

                if (data.espera === 0) {
                    textoEspera.textContent = "🚆 El tren aún no ha pasado por esta estación.";
                } else {
                    textoEspera.textContent = `⌛ El tren ya pasó. Tiempo estimado de espera para el próximo recorrido: ${data.espera} horas.`;
                }

                esperaDiv.style.display = 'block';
            })
            .catch(err => {
                console.error('Error al consultar tiempo de espera:', err);
            });
    }
}


        if (modoCompraActivo && selectedStations.length === 2){
            

            highlightRoute(selectedStations[0], selectedStations[1]);

            const estacionesArr = Array.from(document.querySelectorAll('.station'));
            let startIndex = estacionesArr.findIndex(s => parseInt(s.dataset.id) === selectedStations[0]);
            let endIndex = estacionesArr.findIndex(s => parseInt(s.dataset.id) === selectedStations[1]);

            const estacionesEntre = Math.abs(endIndex - startIndex);
            // Calcular hora estimada de llegada
const minutosPorEstacion = 2;
const minutosTotales = estacionesEntre * minutosPorEstacion;

const ahora = new Date();
ahora.setMinutes(ahora.getMinutes() + minutosTotales);

const horas = ahora.getHours().toString().padStart(2, '0');
const minutos = ahora.getMinutes().toString().padStart(2, '0');

const horaEstimada = `${horas}:${minutos}`;
document.getElementById('hora-estimada-llegada').textContent = horaEstimada;
            const distancia = estacionesEntre * 5;
            const costo = distancia * 1;

            document.getElementById('input-origen').value = selectedStations[0];
            document.getElementById('input-destino').value = selectedStations[1];
            document.getElementById('input-precio').value = costo.toFixed(2);
            document.getElementById('input-distancia').value = distancia;
            document.getElementById('input-ruta').value = trenRutaActual();

            document.getElementById('distancia-text').innerText = distancia;
            document.getElementById('precio-text').innerText = costo.toFixed(2);
            document.getElementById('boleto-form').style.display = 'block';
        }
    });
});

</script>

<script>
   

    document.addEventListener('DOMContentLoaded', () => {
        const tren = document.getElementById('tren');

        function actualizarTren() {
            fetch('/api/tren-posicion')
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        console.warn(data.error);
                        return;
                    }
                     rutaActualGlobal = data.ruta_id || null;
                    // Resaltar estación actual
                    document.querySelectorAll('.station .circle').forEach(c => c.style.border = 'none');

                    const actual = document.getElementById(`estacion-${data.estacion_actual}`);
                    

                    if (actual) {
                        actual.querySelector('.circle').style.border = '3px solid yellow';

                        // Posicionar tren visualmente sobre la estación
                        const rectEstacion = actual.getBoundingClientRect();
                        const rectLinea = document.getElementById('train-line').getBoundingClientRect();
                        const offsetX = rectEstacion.left - rectLinea.left + 5;

                        tren.style.transform = `translateX(${offsetX}px)`;
                    }

                    // Mostrar estado actual
                   document.getElementById('estado-tren').textContent =
    data.estado === 'en_movimiento' ? 'En movimiento' :
    data.estado === 'detenido' ? 'Detenido' :
    'Desconocido';

                })
                .catch(err => {
                    console.error('Error al obtener datos del tren:', err);
                });
        }
       

        setInterval(actualizarTren, 3000); // Cada 3 segundos
        actualizarTren(); // Llamar al inicio
    });
</script>

<style>
#tren {
    position: absolute;
    top: -40px; /* Más centrado verticalmente */
    left: 0;
    transition: transform 1.5s ease;
    font-size: 32px; /* Un poco más grande para visibilidad */
}
</style>

@endsection
