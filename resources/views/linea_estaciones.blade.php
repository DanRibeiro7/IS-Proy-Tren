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
    color: #ffffff !important;
    font-size: 16px;
    text-shadow: 0 0 4px rgba(0, 0, 0, 0.6);
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

#info-panel h3 {
    font-size: 24px;
    margin-bottom: 10px;
    color: white;
    text-shadow: 0 0 6px rgba(0, 0, 0, 0.7);
}

}
#info-panel ul {
    padding-left: 20px;
    list-style: disc;
    color: #444;
}
#info-panel img {
    width: 300px;
    height: 200px;
    object-fit: cover;
    object-position: center;
    display: block;
    margin: 15px 0;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
}





    .estacion-activa { border-color: #ff9800 !important; }
    .alerta { background: #ffc107; color: black; padding: 10px; margin: 20px auto; width: 70%; border-radius: 8px; text-align: center; }

#boleto-form button,
#info-panel button {
    background: #00bcd4;
    border: none;
    color: white;
    padding: 10px 18px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    margin-right: 10px;
    transition: background 0.3s ease;
}

#boleto-form button:hover,
#info-panel button:hover {
    background: #0097a7;
}
#boleto-form select {
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-weight: bold;
    background-color: #ffffff;
    color: #333;
    margin-right: 10px;
    transition: box-shadow 0.3s ease;
}

#boleto-form select:focus {
    outline: none;
    box-shadow: 0 0 6px rgba(0, 188, 212, 0.8);
}


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
        <input type="hidden" name="precio_unitario" id="input-precio-unitario">
        <input type="hidden" name="distancia" id="input-distancia">   {{-- OK --}}

        <input type="hidden" name="ruta_id" id="input-ruta">
        


        <p>Distancia: <span id="distancia-text">0</span> km</p>
        <p>Precio: S/ <span id="precio-text">0.00</span></p>
        <p>Total a pagar: S/ <span id="precio-total">0.00</span></p>

        <p>Hora estimada de llegada: <span id="hora-estimada-llegada">--:--</span></p>

       <label for="metodo_pago">Método de pago:</label>
<select name="metodo_pago" id="metodo_pago" required>
    <option value="tarjeta">💳 Tarjeta</option>
    <option value="efectivo">💵 Efectivo</option>
    <option value="yape">🟪 Yape</option>
</select>

<label for="cantidad">Cantidad de personas (máximo 5):</label>
<input type="number" name="cantidad" id="cantidad" min="1" max="5" value="1" required>

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
    mostrarAlerta("🔔 Por favor, selecciona estación de origen y destino.");
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

        // Mostrar info de estación
        document.getElementById('info-nombre').textContent = estacion.EstNombre;
        document.getElementById('info-clima').textContent = clima ? clima.CliClima : 'No disponible';

        const ul = document.getElementById('info-zonas');
        ul.innerHTML = '';
        if (zonas.length > 0) {
            zonas.forEach(z => ul.innerHTML += `<li>${z.DesTNombre}</li>`);
            document.getElementById('info-imagen').src = zonas[0].DesImagenURL 
                ? `/storage/${zonas[0].DesImagenURL}` 
                : 'https://via.placeholder.com/400x200';
        } else {
            ul.innerHTML = '<li>No registradas.</li>';
            document.getElementById('info-imagen').src = 'https://via.placeholder.com/400x200';
        }

        document.getElementById('info-panel').style.display = 'block';

        // Modo compra
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
                const origenID = selectedStations[0];
                const destinoID = selectedStations[1];

                const i1 = estaciones.findIndex(e => e.EstID === origenID);
                const i2 = estaciones.findIndex(e => e.EstID === destinoID);

                if (i1 === -1 || i2 === -1) {
                    console.error("No se encontraron índices de estaciones");
                    return;
                }

                const estacionesEntre = Math.abs(i2 - i1);
                const distancia = estacionesEntre * 5;
                const precioUnitario = distancia * 1;

                const now = new Date();
                now.setMinutes(now.getMinutes() + (estacionesEntre * 10));
                const hora = now.getHours().toString().padStart(2, '0');
                const min = now.getMinutes().toString().padStart(2, '0');

                document.getElementById('input-precio-unitario').value = precioUnitario.toFixed(2);
                document.getElementById('input-distancia').value = distancia;
                document.getElementById('input-ruta').value = rutaActualGlobal;
                document.getElementById('input-origen').value = origenID;
                document.getElementById('input-destino').value = destinoID;

                document.getElementById('distancia-text').textContent = distancia;
                document.getElementById('precio-text').textContent = precioUnitario.toFixed(2);
                document.getElementById('hora-estimada-llegada').textContent = `${hora}:${min}`;

                const cantidad = parseInt(document.getElementById('cantidad').value) || 1;
                document.getElementById('precio-total').textContent = (cantidad * precioUnitario).toFixed(2);

                document.getElementById('boleto-form').style.display = 'block';
            }
        }
    });
});

document.getElementById('cantidad').addEventListener('input', () => {
    const cantidad = parseInt(document.getElementById('cantidad').value) || 1;
    const precioUnitario = parseFloat(document.getElementById('input-precio-unitario').value) || 0;
    const total = cantidad * precioUnitario;
    document.getElementById('precio-total').textContent = total.toFixed(2);
});
</script>

@endsection
