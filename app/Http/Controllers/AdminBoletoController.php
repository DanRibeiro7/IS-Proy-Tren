<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Boleto;
use App\Models\Estacion;
use App\Models\Usuario;

class AdminBoletoController extends Controller
{
    public function historial()
    {
        $boletos = Boleto::with(['usuario', 'estacion_origen', 'estacion_destino'])->orderBy('BolFechaviaje', 'desc')->get();
        return view('admin.boletos.historial', compact('boletos'));
    }
}
