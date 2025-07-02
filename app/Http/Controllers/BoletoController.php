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
    // Validar datos básicos
    $request->validate([
        'estacion_origen_id' => 'required|integer',
        'estacion_destino_id' => 'required|integer',
        'precio' => 'required|numeric|min:0',
        'distancia_km' => 'required|numeric|min:0',
        'ruta_id' => 'required|integer',
    ]);

    // Obtener orden actual del tren (basado en estación actual y ruta actual)
    $tren = Tren::first(); // o el que esté activo

    $ordenActual = RutaEstacion::where('RutaID', $request->ruta_id)
        ->where('EstacionID', $tren->TrenEstacionActual)
        ->value('Orden');

    $ordenOrigen = RutaEstacion::where('RutaID', $request->ruta_id)
        ->where('EstacionID', $request->estacion_origen_id)
        ->value('Orden');

    if ($ordenOrigen < $ordenActual) {
        return redirect()->back()->with('error', '❌ El tren ya pasó por la estación de origen.');
    }

    // Crear boleto
    Boleto::create([
        'UsuID'         => auth()->user()->UsuID ?? 1,
        'RutID'         => $request->ruta_id,
        'BolFechaviaje' => now()->toDateString(),
        'BolHoraSalida' => now()->format('H:i:s'),
        'BolPrecio'     => $request->precio,
        'BolEstado'     => 'pendiente',
        'BolCreadoEn'   => now(),
    ]);
     return redirect()->route('cliente.ver_boleto', ['id' => $boleto->id])
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

