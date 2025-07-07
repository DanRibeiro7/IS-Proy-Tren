<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estacion;
use App\Models\ZonaTuristica;
use App\Models\Clima;
use App\Models\Boleto;
use App\Models\Ruta;
use App\Models\DestinoTuristico; // ✅ IMPORTACIÓN FALTANTE
use App\Models\PreferenciaUsuario;
use App\Models\TipoClima;
use App\Models\TipoZona;



class ClienteController extends Controller
{
    // Vista principal del cliente
public function dashboard()
{
    $usuario = auth()->user();
    $preferencias = PreferenciaUsuario::where('UsuID', $usuario->UsuID)->first();

    if (!$preferencias) {
        return redirect()->route('cliente.preferencias.form');
    }

    // Obtener estación base
    $estacionBase = Estacion::find($preferencias->EstID);

    // Obtener climas recientes en la estación preferida con el tipo deseado
    $climas = Clima::where('EstID', $preferencias->EstID)
        ->where('TipClimaID', $preferencias->TipClimaID)
        ->latest('CliFecha')
        ->take(3)
        ->with('tipoClima')
        ->get();

    // Obtener destinos turísticos con su estación y clima precargados
    $destinos = DestinoTuristico::with(['tipoZona', 'estacion.clima'])
        ->where('TipZonaID', $preferencias->TipZonaID)
        ->get()
        ->filter(function ($destino) use ($preferencias) {
            // Verificamos si la estación del destino tiene algún clima del tipo preferido
            $climasEstacion = $destino->estacion->clima->where('TipClimaID', $preferencias->TipClimaID);
            return $climasEstacion->count() > 0;
        });

    return view('cliente.dashboard', compact('destinos', 'climas', 'preferencias'));
}




function climaEmoji($nombre)
{
    return match(strtolower($nombre)) {
        'soleado' => '☀️',
        'nublado' => '☁️',
        'lluvioso' => '🌧️',
        'ventoso' => '💨',
        'tormentoso' => '⛈️',
        default => '🌡️',
    };
}


public function mostrarFormularioPreferencias()
{
    $estaciones = Estacion::all();
    $tiposZona = TipoZona::all();
    $tiposClima = TipoClima::all();

    return view('cliente.definir_preferencias', compact('estaciones', 'tiposZona', 'tiposClima'));
}

public function guardarPreferencias(Request $request)
{
    $request->validate([
        'EstID' => 'required|exists:estacion,EstID',
        'TipZonaID' => 'required|exists:tipo_zona,TipZonaID',
        'TipClimaID' => 'required|exists:tipo_clima,TipClimaID',
        'PreUDistanciaMaxima' => 'required|numeric',
    ]);

    PreferenciaUsuario::updateOrCreate(
        ['UsuID' => auth()->user()->UsuID],
        [
            'EstID' => $request->EstID,
            'TipZonaID' => $request->TipZonaID,
            'TipClimaID' => $request->TipClimaID,
            'PreUDistanciaMaxima' => $request->PreUDistanciaMaxima,
        ]
    );

    return redirect()->route('cliente.dashboard')->with('success', 'Preferencias guardadas correctamente.');
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
   $usuarioID = auth()->user()->UsuID;

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
