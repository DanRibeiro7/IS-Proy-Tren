<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function linea()
    {
        $estaciones = \App\Models\Estacion::all();
        $destinos = \App\Models\DestinoTuristico::all();
        $climas = \App\Models\Clima::all();
        $rutas = \App\Models\Ruta::all();

       return view('linea_estaciones', compact('estaciones', 'destinos', 'climas', 'rutas'));

    }
}
