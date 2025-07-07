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
    // Validación
    $request->validate([
        'estacion_origen_id' => 'required|exists:estacion,EstID',
        'estacion_destino_id' => 'required|exists:estacion,EstID',
        'metodo_pago' => 'required|string|max:50',
        'precio_unitario' => 'required|numeric|min:0',
        'distancia' => 'required|numeric|min:0',
        'cantidad' => 'required|integer|min:1|max:5',
        'ruta_id' => 'required|exists:ruta,RutID',
    ]);

    $tren = Tren::first();

    // Detectar si ya pasó la estación origen
    $ordenActual = RutaEstacion::where('RutaID', $request->ruta_id)
        ->where('EstacionID', $tren->TrenEstacionActual)
        ->value('Orden');

    $ordenOrigen = RutaEstacion::where('RutaID', $request->ruta_id)
        ->where('EstacionID', $request->estacion_origen_id)
        ->value('Orden');

    if ($ordenOrigen < $ordenActual) {
        return redirect()->back()->with('error', '❌ El tren ya pasó por la estación de origen.');
    }

    // Calcular tiempos
    $horaSalida = now();
    $horaLlegada = now()->addMinutes(($request->distancia / 5) * 10);

    // Datos del usuario logueado
    $usuario = auth()->user();
    if (!$usuario) {
        return redirect()->back()->with('error', 'Debe iniciar sesión para comprar.');
    }

    try {
        $boleto = Boleto::create([
            'UsuID'              => $usuario->UsuID,
            'RutID'              => $request->ruta_id,
            'BolFechaviaje'      => now()->toDateString(),
            'BolHoraSalida'      => $horaSalida->format('H:i:s'),
            'BolHoraLlegada'     => $horaLlegada->format('H:i:s'),
            'BolPrecio'          => $request->precio_unitario * $request->cantidad,
            'BolDistanciaKM'     => $request->distancia,
            'BolMetodoPago'      => $request->metodo_pago,
            'BolEstado'          => 'pendiente',
            'BolCreadoEn'        => now(),
            'BolEstacionOrigen'  => $request->estacion_origen_id,
            'BolEstacionDestino' => $request->estacion_destino_id,
        ]);
     

        return redirect()->route('cliente.ver_boleto', $boleto->BolID)
            ->with('success', '🎫 Boleto comprado con éxito');
    } catch (\Exception $e) {
        return back()->with('error', 'Error al guardar: ' . $e->getMessage());
    }
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

