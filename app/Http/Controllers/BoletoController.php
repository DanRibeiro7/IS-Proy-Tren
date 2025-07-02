<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\Usuario;
use App\Models\Ruta;
use App\Models\Tren;
use App\Models\RutaEstacion;
use Illuminate\Http\Request;

class BoletoController extends Controller
{
    public function index()
    {
        $boletos = Boleto::with(['usuario', 'ruta'])->get();
        return view('boletos.index', compact('boletos'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        $rutas = Ruta::with(['origen', 'destino'])->get();
        return view('boletos.create', compact('usuarios', 'rutas'));
    }

public function store(Request $request)
{
    // Validación de los campos
    $request->validate([
        'estacion_origen_id'   => 'required|integer|exists:estacion,EstID',
        'estacion_destino_id'  => 'required|integer|exists:estacion,EstID',
        'precio'               => 'required|numeric|min:0',
        'distancia_km'         => 'required|numeric|min:0',
        'ruta_id'              => 'required|integer|exists:ruta,RutID',
        'metodo_pago'          => 'required|string|max:50',
    ]);

    // Obtener el tren actual y su estación
    $tren = Tren::first();

    $ordenActual = RutaEstacion::where('RutaID', $request->ruta_id)
        ->where('EstacionID', $tren->TrenEstacionActual)
        ->value('Orden');

    $ordenOrigen = RutaEstacion::where('RutaID', $request->ruta_id)
        ->where('EstacionID', $request->estacion_origen_id)
        ->value('Orden');

    if ($ordenOrigen < $ordenActual) {
        return redirect()->back()->with('error', '❌ El tren ya pasó por la estación de origen.');
    }

    // Calcular hora estimada de llegada (1 km = 1 minuto)
    $minutosExtra = (int) $request->distancia_km;
    $horaLlegada = now()->addMinutes($minutosExtra)->format('H:i:s');

    // Crear el boleto
    $boleto = Boleto::create([
        'UsuID'              => auth()->user()->UsuID ?? 1,
        'RutID'              => $request->ruta_id,
        'BolFechaviaje'      => now()->toDateString(),
        'BolHoraSalida'      => now()->format('H:i:s'),
        'BolHoraLlegada'     => $horaLlegada,
        'BolPrecio'          => $request->precio,
        'BolDistanciaKM'     => $request->distancia_km,
        'BolMetodoPago'      => $request->metodo_pago,
        'BolEstado'          => 'pendiente',
        'BolCreadoEn'        => now(),
        'BolEstacionOrigen'  => $request->estacion_origen_id,
        'BolEstacionDestino' => $request->estacion_destino_id,
    ]);

    return redirect()->route('cliente.ver_boleto', ['id' => $boleto->BolID])
        ->with('success', '🎫 Boleto comprado con éxito');
}




    public function edit($id)
    {
        $boleto = Boleto::findOrFail($id);
        $usuarios = Usuario::all();
        $rutas = Ruta::with(['origen', 'destino'])->get();

        return view('boletos.edit', compact('boleto', 'usuarios', 'rutas'));
    }

    public function update(Request $request, $id)
    {
        $boleto = Boleto::findOrFail($id);

        $request->validate([
            'UsuID' => 'required|exists:usuario,UsuID',
            'RutID' => 'required|exists:ruta,RutID',
            'BolFechaviaje' => 'required|date',
            'BolHoraSalida' => 'required',
            'BolPrecio' => 'required|numeric',
            'BolEstado' => 'required',
        ]);

        $boleto->update($request->all());

        return redirect()->route('boletos.index')->with('success', 'Boleto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $boleto = Boleto::findOrFail($id);
        $boleto->delete();

        return redirect()->route('boletos.index')->with('success', 'Boleto eliminado correctamente.');
    }
}

