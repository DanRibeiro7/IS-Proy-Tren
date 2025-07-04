<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estacion;
use App\Models\ZonaTuristica;
use App\Models\Clima;
use App\Models\Boleto;
use App\Models\Ruta;
use App\Models\DestinoTuristico; // ✅ IMPORTACIÓN FALTANTE

class ClienteController extends Controller
{
    // Vista principal del cliente
    public function dashboard()
    {
        return view('cliente.dashboard');
    }

    // Mostrar línea del tren y estaciones
    public function lineaEstaciones()
    {
        $estaciones = Estacion::with(['zonaTuristica', 'clima'])->get();
        $destinos = DestinoTuristico::all();
        $climas = Clima::all();
        $rutas = Ruta::all();

        return view('linea_estaciones', compact('estaciones', 'destinos', 'climas', 'rutas'));
    }

    // Mostrar detalles al hacer clic en una estación
    public function verDetallesEstacion($id)
    {
        $estacion = Estacion::with(['zonaTuristica', 'clima'])->findOrFail($id);
        return response()->json($estacion);
    }

    // Mostrar formulario para seleccionar origen y destino
    public function seleccionarViaje()
    {
        $estaciones = Estacion::orderBy('EstID')->get();
        return view('cliente.seleccionar_viaje', compact('estaciones'));
    }
    

    // Mostrar boleto tras la compra
    public function verBoleto($id)
{
    $boleto = Boleto::with(['estacion_origen', 'estacion_destino'])->findOrFail($id);

    // Validación extra: solo el dueño del boleto puede verlo
    if ($boleto->UsuID != auth()->user()->UsuID) {
        abort(403);
    }

    return view('cliente.ver_boleto', compact('boleto'));
}
public function historialBoletos()
{
    $usuarioID = auth()->id();

    $boletos = Boleto::with(['estacion_origen', 'estacion_destino'])
                ->where('UsuID', $usuarioID)
                ->orderBy('BolFechaviaje', 'desc')
                ->get();

    return view('cliente.historial_boletos', compact('boletos'));
}
public function anularBoleto($id)
{
    $boleto = Boleto::where('UsuID', auth()->user()->UsuID)->findOrFail($id);

    if ($boleto->BolEstado !== 'pendiente') {
        return back()->with('error', 'Este boleto no puede ser anulado.');
    }

    // Verificamos si es el último boleto
    $ultimoID = Boleto::where('UsuID', auth()->user()->UsuID)->max('BolID');
    if ($boleto->BolID !== $ultimoID) {
        return back()->with('error', 'Solo puedes anular tu última compra.');
    }

    $boleto->BolEstado = 'cancelado';
    $boleto->save();

    return back()->with('success', 'Boleto anulado correctamente.');
}




}
