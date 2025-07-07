let selectedStations = [];
let rutaActualGlobal = 1;
let modoCompraActivo = false;

function mostrarAlerta(mensaje) {
    const alertaDiv = document.getElementById('mensaje-alerta');
    alertaDiv.textContent = mensaje;
    alertaDiv.classList.remove('hidden');
    setTimeout(() => {
        alertaDiv.classList.add('hidden');
    }, 5000);
}

function iniciarCompra() {
    if (selectedStations.length < 2) {
        mostrarAlerta("Selecciona origen y destino haciendo clic en estaciones.");
    }
    modoCompraActivo = true;
    selectedStations = [];
    document.getElementById('boleto-form').classList.add('hidden');
    document.querySelectorAll('.circle').forEach(c => c.classList.remove('bg-red-500', 'border-red-700'));
    document.querySelectorAll('.line').forEach(l => l.classList.remove('bg-red-500'));
}

function trenRutaActual() {
    return rutaActualGlobal || 1;
}

function resetSeleccion() {
    modoCompraActivo = false;
    selectedStations = [];
    document.getElementById('boleto-form').classList.add('hidden');
    document.querySelectorAll('.circle').forEach(c => c.classList.remove('bg-red-500', 'border-red-700'));
    document.querySelectorAll('.line').forEach(l => l.classList.remove('bg-red-500'));
    document.getElementById('tiempo-espera-info').classList.add('hidden');
}

function highlightRoute(est1, est2) {
    document.querySelectorAll('.circle').forEach(c => c.classList.remove('bg-red-500'));
    document.querySelectorAll('.line').forEach(l => l.classList.remove('bg-red-500'));

    const stationsArr = Array.from(document.querySelectorAll('.station'));
    let startIndex = stationsArr.findIndex(s => parseInt(s.dataset.id) === est1);
    let endIndex = stationsArr.findIndex(s => parseInt(s.dataset.id) === est2);

    if (startIndex > endIndex) [startIndex, endIndex] = [endIndex, startIndex];

    for (let i = startIndex; i <= endIndex; i++) {
        stationsArr[i].querySelector('.circle').classList.add('bg-red-500');
        if (i < endIndex) {
            const line = stationsArr[i].nextElementSibling;
            if (line && line.classList.contains('line')) {
                line.classList.add('bg-red-500');
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const tren = document.getElementById('tren');

    document.querySelectorAll('.station').forEach(stationDiv => {
        stationDiv.addEventListener('click', () => {
            const estId = parseInt(stationDiv.dataset.id);

            const destinoEstacion = destinos.filter(d => d.EstID === estId);
            const climaEstacion = climas.find(c => c.EstID === estId);

            let html = `<strong>Estación:</strong> ${stationDiv.innerText.trim()}<br>`;
            html += `<strong>Clima:</strong> ${climaEstacion ? climaEstacion.CliClima : 'No disponible'}<br>`;

            if (destinoEstacion.length > 0) {
                html += `<strong>Zonas Turísticas:</strong><ul>`;
                destinoEstacion.forEach(d => html += `<li>${d.DesTNombre}</li>`);
                html += `</ul>`;
            } else {
                html += `<strong>Zonas Turísticas:</strong> No hay zonas registradas.`;
            }

            document.getElementById('info-content').innerHTML = html;
            document.getElementById('info').classList.remove('hidden');

            if (modoCompraActivo && selectedStations.length < 2 && !selectedStations.includes(estId)) {
                selectedStations.push(estId);
                stationDiv.querySelector('.circle').classList.add
