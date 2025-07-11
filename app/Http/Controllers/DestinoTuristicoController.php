<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DestinoTuristico;
use App\Models\Estacion;
use App\Models\TipoZona;
use Illuminate\Support\Facades\Storage;



class DestinoTuristicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $destinos = DestinoTuristico::with('estacion')->get(); // para incluir info de estación
        return view('destinos.index', compact('destinos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        

        $estaciones = Estacion::all(); // para mostrar en un <select>
        $tiposZona = TipoZona::all();
       return view('destinos.create', compact('estaciones', 'tiposZona'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'DesTNombre' => 'required',
            'DesTDescripcion' => 'required',
            'EstID' => 'required|exists:estacion,EstID',
            'TipZonaID' => 'required|exists:tipo_zona,TipZonaID',
            'DesTUbicacion' => 'required',
            'DesImagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
         $data = $request->except('DesImagen');

          if ($request->hasFile('DesImagen')) {
       $path = $request->file('DesImagen')->store('destinos', 'public');
         $data['DesImagenURL'] = $path;
    }
     DestinoTuristico::create($data);

        return redirect()->route('destinos.index')->with('success', 'Destino turístico creado correctamente'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $destino = DestinoTuristico::findOrFail($id);
        return view('destinos.show', compact('destino'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $destino = DestinoTuristico::findOrFail($id);
        $estaciones = Estacion::all();
        $tiposZona = TipoZona::all();
        return view('destinos.edit', compact('destino', 'estaciones', 'tiposZona'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'DesTNombre' => 'required',
            'DesTDescripcion' => 'required',
            'EstID' => 'required|exists:estacion,EstID',
            'TipZonaID' => 'required|exists:tipo_zona,TipZonaID',
            'DesTUbicacion' => 'required',
            'DesImagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $destino = DestinoTuristico::findOrFail($id);
        $data = $request->except('DesImagen');

        if ($request->hasFile('DesImagen')) {
            $path = $request->file('DesImagen')->store('destinos', 'public');
            $data['DesImagenURL'] = $path;
        }

        $destino->update($data);

        return redirect()->route('destinos.index')->with('success', 'Destino turístico actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $destino = DestinoTuristico::findOrFail($id);
        $destino->delete();

        return redirect()->route('destinos.index')->with('success', 'Destino turístico eliminado');
    }
}
