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
        margin-bottom: 30px;
        font-size: 32px;
    }

    #train-line-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 40px;
    }

    .train-line {
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 90%;
        height: 160px;
        margin-top: 40px;
    }

    .station {
        position: relative;
        text-align: center;
        cursor: pointer;
    }

    .station-icon {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
        border: 4px solid #0e1a4f;
        z-index: 10;
    }

    .station-name {
        margin-top: 10px;
        font-weight: bold;
        color: white;
    }

    .zigzag {
        position: absolute;
        top: 25px;
        height: 4px;
        background: white;
        z-index: 1;
    }

    .zigzag.down { transform: translateY(20px) rotate(10deg); }
    .zigzag.up { transform: translateY(-20px) rotate(-10deg); }

    .train {
        position: absolute;
        top: -70px;
        font-size: 48px;
        transition: transform 1.2s ease-in-out;
        z-index: 100;
    }

    #info-panel {
        background: white;
        color: #333;
        margin-top: 40px;
        padding: 20px;
        border-radius: 12px;
        width: 70%;
        display: none;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
    }

    #info-panel img {
        width: 100%;
        max-height: 180px;
        object-fit: cover;
        border-radius: 8px;
    }

    .estacion-activa { border-color: #ff9800 !important; }
    .alerta { background: #ffc107; color: black; padding: 10px; margin: 20px auto; width: 70%; border-radius: 8px; text-align: center; }
</style>

<h1>🚆 Línea del Tren Interurbano</h1>

<div class="alerta" id="mensaje-alerta" style="display: none;"></div>
<div style="text-align: center; margin-top: 10px;">
    <strong>🚦 Estado del tren:</strong>
    <span id="estado-tren" style="font-weight: bold; color: #ffff66;">Cargando...</span>
</div>

<div id="train-line-container">
    <div class="train-line" id="train-line">
        <div id="train" class="train">🚄</div>
        @foreach($estaciones as $index => $estacion)
            <div class="station" data-id="{{ $estacion->EstID }}">
                <div class="station-icon" id="station-icon-{{ $estacion->EstID }}"></div>
                <div class="station-name">{{ $estacion->EstNombre }}</div>
                @if(!$loop->last)
                    <div class="zigzag {{ $loop->iteration % 2 == 0 ? 'down' : 'up' }}" style="left: 100%; width: 60px;"></div>
                @endif
            </div>
        @endforeach
    </div>
</div>

<div id="info-panel">
    <h3 id="info-nombre"></h3>
    <p><strong>Clima:</strong> <span id="info-clima"></span></p>
    <p><strong>Zonas Turísticas:</strong></p>
    <ul id="info-zonas"></ul>
    <img id="info-imagen" src="" alt="Imagen zona turística">

    <div id="tiempo-espera-info" style="margin-top: 10px; font-weight: bold; color: #ff6600; display:none;">
        ⏳ <span id="texto-tiempo-espera"></span>
    </div>

    <button onclick="iniciarCompra()">🎟️ Comprar Boleto</button>

    <form method="POST" action="{{ route('boleto.store') }}" id="boleto-form" style="margin-top: 20px; display:none;">
        @csrf
        <input type="hidden" name="estacion_origen_id" id="input-origen">
        <input type="hidden" name="estacion_destino_id" id="input-destino">
        <input type="hidden" name="precio" id="input-precio">
        <input type="hidden" name="distancia_km" id="input-distancia">
        <input type="hidden" name="ruta_id" id="input-ruta">

        <p>Distancia: <span id="distancia-text">0</span> km</p>
        <p>Precio: S/ <span id="precio-text">0.00</span></p>
        <p>Hora estimada de llegada: <span id="hora-estimada-llegada">--:--</span></p>

        <label for="metodo_pago">Método de pago:</label>
        <select name="metodo_pago" required>
            <option value="tarjeta">Tarjeta</option>
            <option value="efectivo">Efectivo</option>
            <option value="yape">Yape</option>
        </select>

        <button type="submit" style="margin-top:10px;">Comprar</button>
        <button type="button" onclick="resetSeleccion()" style="margin-top:10px;">🔄 Reiniciar</button>
    </form>
</div>

<script>
    const estaciones = @json($estaciones);
    const destinos = @json($destinos);
    const climas = @json($climas);
    let selectedStations = [];
    let modoCompraActivo = false;
    let rutaActualGlobal = 1;

    const train = document.getElementById('train');
    const stationElements = document.querySelectorAll('.station');

    function moverTren() {
        fetch('/api/tren-posicion')
            .then(res => res.json())
            .then(data => {
                const estadoTexto = data.estado === 'en_movimiento'
    ? 'En movimiento 🚆'
    : data.estado === 'detenido'
    ? 'Detenido ⏸️'
    : 'Desconocido ❓';

document.getElementById('estado-tren').textContent = estadoTexto;

                const estacionActual = document.getElementById('station-icon-' + data.estacion_actual);
                const line = document.getElementById('train-line');
                const rect = estacionActual.getBoundingClientRect();
                const parentRect = line.getBoundingClientRect();
                const offsetX = rect.left - parentRect.left;

                train.style.transform = `translateX(${offsetX}px)`;
                rutaActualGlobal = data.ruta_id;
            });
    }

    setInterval(moverTren, 3000);
    moverTren();

    function mostrarAlerta(mensaje) {
        const alerta = document.getElementById('mensaje-alerta');
        alerta.textContent = mensaje;
        alerta.style.display = 'block';
        setTimeout(() => alerta.style.display = 'none', 5000);
    }

    function iniciarCompra() {
        modoCompraActivo = true;
        selectedStations = [];
        document.getElementById('boleto-form').style.display = 'none';
        document.getElementById('tiempo-espera-info').style.display = 'none';
        document.querySelectorAll('.station-icon').forEach(i => i.style.borderColor = '#0e1a4f');
    }

    function resetSeleccion() {
        selectedStations = [];
        modoCompraActivo = false;
        document.getElementById('boleto-form').style.display = 'none';
        document.getElementById('tiempo-espera-info').style.display = 'none';
        document.querySelectorAll('.station-icon').forEach(i => i.style.borderColor = '#0e1a4f');
    }

    stationElements.forEach(station => {
        station.addEventListener('click', () => {
            const id = parseInt(station.dataset.id);
            const estacion = estaciones.find(e => e.EstID === id);
            const clima = climas.find(c => c.EstID === id);
            const zonas = destinos.filter(d => d.EstID === id);

            document.getElementById('info-nombre').textContent = estacion.EstNombre;
            document.getElementById('info-clima').textContent = clima ? clima.CliClima : 'No disponible';

            const ul = document.getElementById('info-zonas');
            ul.innerHTML = '';
            if (zonas.length > 0) {
                zonas.forEach(z => ul.innerHTML += `<li>${z.DesTNombre}</li>`);
                document.getElementById('info-imagen').src = zonas[0].DesTImagen || 'https://via.placeholder.com/400x200';
            } else {
                ul.innerHTML = '<li>No registradas.</li>';
                document.getElementById('info-imagen').src = 'https://via.placeholder.com/400x200';
            }

            document.getElementById('info-panel').style.display = 'block';

            if (modoCompraActivo && selectedStations.length < 2 && !selectedStations.includes(id)) {
                selectedStations.push(id);
                station.querySelector('.station-icon').style.borderColor = '#ff9800';

                if (selectedStations.length === 1) {
                    fetch(`/api/tiempo-espera/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            const mensaje = data.espera === 0
                                ? "🚆 El tren aún no ha pasado por esta estación."
                                : `⌛ El tren ya pasó. Tiempo de espera: ${data.espera} horas.`;
                            document.getElementById('texto-tiempo-espera').textContent = mensaje;
                            document.getElementById('tiempo-espera-info').style.display = 'block';
                        });
                }

                if (selectedStations.length === 2) {
                    const i1 = estaciones.findIndex(e => e.EstID === selectedStations[0]);
                    const i2 = estaciones.findIndex(e => e.EstID === selectedStations[1]);
                    const estacionesEntre = Math.abs(i2 - i1);
                    const distancia = estacionesEntre * 5;
                    const costo = distancia * 1;
                    const ahora = new Date();
                    ahora.setMinutes(ahora.getMinutes() + estacionesEntre * 2);
                    const hora = ahora.getHours().toString().padStart(2, '0');
                    const min = ahora.getMinutes().toString().padStart(2, '0');

                    document.getElementById('input-origen').value = selectedStations[0];
                    document.getElementById('input-destino').value = selectedStations[1];
                    document.getElementById('input-precio').value = costo.toFixed(2);
                    document.getElementById('input-distancia').value = distancia;
                    document.getElementById('input-ruta').value = rutaActualGlobal;

                    document.getElementById('distancia-text').textContent = distancia;
                    document.getElementById('precio-text').textContent = costo.toFixed(2);
                    document.getElementById('hora-estimada-llegada').textContent = `${hora}:${min}`;

                    document.getElementById('boleto-form').style.display = 'block';
                }
            }
        });
    });
</script>
@endsection
