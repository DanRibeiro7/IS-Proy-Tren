<?php

namespace App\Http\Controllers;

use App\Models\DestinoTuristico;
use App\Models\Clima;
use App\Models\Ruta;

use App\Models\Estacion;
use Illuminate\Http\Request;

class EstacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $estaciones = Estacion::all();
    return view('estacions.index', compact('estaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estacions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
        'EstNombre' => 'required|string|max:100',
        'EstUbicacion' => 'required|string|max:255',
    ]);

    Estacion::create($request->all());

    return redirect()->route('estacions.index')->with('success', 'Estación creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Estacion $estacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estacion $estacion)
    {
        return view('estacions.edit', compact('estacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estacion $estacion)
    {
        $request->validate([
        'EstNombre' => 'required|string|max:100',
        'EstUbicacion' => 'required|string|max:255',
    ]);

    $estacion->update($request->all());

    return redirect()->route('estacions.index')->with('success', 'Estación actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estacion $estacion)
    {
          $estacion->delete();
    return redirect()->route('estacions.index')->with('success', 'Estación eliminada.');
    }
public function mostrarLinea()
{
    $estaciones = Estacion::orderBy('EstID')->get();
    $destinos = DestinoTuristico::all();
    $climas = Clima::all();
    $rutas = Ruta::all();

    return view('linea_estaciones', compact('estaciones', 'destinos', 'climas', 'rutas'));
}

}

