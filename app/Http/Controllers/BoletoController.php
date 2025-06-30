<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\Usuario;
use App\Models\Ruta;
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
    $request->validate([
        'RutID' => 'required|exists:ruta,RutID',
        'BolFechaviaje' => 'required|date',
        'BolHoraSalida' => 'required',
        'BolPrecio' => 'required|numeric',
    ]);

    $boleto = Boleto::create([
        'UsuID'         => auth()->user()->UsuID, // toma el usuario logueado
        'RutID'         => $request->RutID,
        'BolFechaviaje' => $request->BolFechaviaje,
        'BolHoraSalida' => $request->BolHoraSalida,
        'BolPrecio'     => $request->BolPrecio,
        'BolEstado'     => 'pendiente',
        'BolCreadoEn'   => now(),
    ]);

    return redirect()->route('boletos.index')->with('success', '🎫 Boleto comprado correctamente.');
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

