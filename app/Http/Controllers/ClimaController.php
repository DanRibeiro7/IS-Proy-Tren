<?php

namespace App\Http\Controllers;

use App\Models\Clima;
use App\Models\Estacion;
use Illuminate\Http\Request;

class ClimaController extends Controller
{
    public function index()
    {
        $climas = Clima::with('estacion')->get();
        return view('climas.index', compact('climas'));
    }

    public function create()
    {
        $estaciones = Estacion::all();
        return view('climas.create', compact('estaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'CliFecha' => 'required|date',
            'CliClima' => 'required',
            'EstID' => 'required|exists:estacion,EstID',
        ]);

        Clima::create($request->all());

        return redirect()->route('climas.index')->with('success', 'Clima registrado correctamente');
    }

    public function edit(Clima $clima)
    {
        $estaciones = Estacion::all();
        return view('climas.edit', compact('clima', 'estaciones'));
    }

    public function update(Request $request, Clima $clima)
    {
        $request->validate([
            'CliFecha' => 'required|date',
            'CliClima' => 'required',
            'EstID' => 'required|exists:estacion,EstID',
        ]);

        $clima->update($request->all());

        return redirect()->route('climas.index')->with('success', 'Clima actualizado correctamente');
    }

    public function destroy(Clima $clima)
    {
        $clima->delete();
        return redirect()->route('climas.index')->with('success', 'Clima eliminado correctamente');
    }
}

