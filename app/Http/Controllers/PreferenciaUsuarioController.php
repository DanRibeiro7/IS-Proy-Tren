<?php

namespace App\Http\Controllers;

use App\Models\PreferenciaUsuario;
use App\Models\Usuario;
use App\Models\Estacion;
use Illuminate\Http\Request;

class PreferenciaUsuarioController extends Controller
{
    public function index()
    {
        $preferencias = PreferenciaUsuario::with(['usuario', 'estacion'])->get();
        return view('preferencias.index', compact('preferencias'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        $estaciones = Estacion::all();
        return view('preferencias.create', compact('usuarios', 'estaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'UsuID' => 'required|exists:usuario,UsuID',
            'EstID' => 'required|exists:estacion,EstID',
            'PreUTipoZona' => 'required|string',
            'PreUClimaDeseado' => 'required|string',
            'PreUDistanciaMaxima' => 'required|numeric',
        ]);

        PreferenciaUsuario::create($request->all());

        return redirect()->route('preferencias.index')->with('success', 'Preferencia creada correctamente.');
    }

    public function edit($id)
    {
        $preferencia = PreferenciaUsuario::findOrFail($id);
        $usuarios = Usuario::all();
        $estaciones = Estacion::all();
        return view('preferencias.edit', compact('preferencia', 'usuarios', 'estaciones'));
    }

    public function update(Request $request, $id)
    {
        $preferencia = PreferenciaUsuario::findOrFail($id);

        $request->validate([
            'UsuID' => 'required|exists:usuario,UsuID',
            'EstID' => 'required|exists:estacion,EstID',
            'PreUTipoZona' => 'required|string',
            'PreUClimaDeseado' => 'required|string',
            'PreUDistanciaMaxima' => 'required|numeric',
        ]);

        $preferencia->update($request->all());

        return redirect()->route('preferencias.index')->with('success', 'Preferencia actualizada correctamente.');
    }

    public function destroy($id)
    {
        $preferencia = PreferenciaUsuario::findOrFail($id);
        $preferencia->delete();

        return redirect()->route('preferencias.index')->with('success', 'Preferencia eliminada correctamente.');
    }
}
