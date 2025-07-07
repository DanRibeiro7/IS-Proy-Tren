<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boleto;
use Barryvdh\DomPDF\Facade\Pdf;

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
    public function verBoleto($id)
{
    $boleto = Boleto::with(['usuario', 'estacion_origen', 'estacion_destino'])->findOrFail($id);
    return view('admin.ver_boleto', compact('boleto'));
}

public function anularBoleto($id)
{
    $boleto = Boleto::findOrFail($id);

    if ($boleto->BolEstado !== 'pendiente') {
        return back()->with('error', 'Este boleto no se puede anular.');
    }

    $boleto->BolEstado = 'cancelado';
    $boleto->save();

    return back()->with('success', 'Boleto anulado correctamente.');
}

public function generarPDF($id)
{
       $boleto = Boleto::with(['usuario', 'estacion_origen', 'estacion_destino'])->findOrFail($id);
    $pdf = Pdf::loadView('admin.pdf_boleto', compact('boleto'));
    return $pdf->download('boleto_' . $boleto->BolID . '.pdf');
}
}
