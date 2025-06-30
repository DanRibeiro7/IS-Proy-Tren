<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use App\Models\Estacion;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    public function index()
    {
        $rutas = Ruta::with(['origen', 'destino'])->get();
        return view('rutas.index', compact('rutas'));
    }

    public function create()
    {
        $estaciones = Estacion::all();
        return view('rutas.create', compact('estaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'EstOrigenID' => 'required|different:EstDestinoID|exists:estacion,EstID',
            'EstDestinoID' => 'required|exists:estacion,EstID',
            'RutTiempoEstimado' => 'required',
            'RutPrecio' => 'required|numeric',
        ]);

        Ruta::create($request->all());

        return redirect()->route('rutas.index')->with('success', 'Ruta creada correctamente');
    }

    public function edit(Ruta $ruta)
    {
        $estaciones = Estacion::all();
        return view('rutas.edit', compact('ruta', 'estaciones'));
    }

    public function update(Request $request, Ruta $ruta)
    {
        $request->validate([
            'EstOrigenID' => 'required|different:EstDestinoID|exists:estacion,EstID',
            'EstDestinoID' => 'required|exists:estacion,EstID',
            'RutTiempoEstimado' => 'required',
            'RutPrecio' => 'required|numeric',
        ]);

        $ruta->update($request->all());

        return redirect()->route('rutas.index')->with('success', 'Ruta actualizada correctamente');
    }

    public function destroy(Ruta $ruta)
    {
        $ruta->delete();
        return redirect()->route('rutas.index')->with('success', 'Ruta eliminada correctamente');
    }
}
