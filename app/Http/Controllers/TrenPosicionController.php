<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tren;
use App\Models\TrenPosicion;
use App\Models\Estacion;

class TrenPosicionController extends Controller
{
    public function estadoActual()
    {
        $tren = Tren::with('posicion')->where('TrenEstado', 'activo')->first();

        if (!$tren || !$tren->posicion) {
            return response()->json(['error' => 'No hay tren activo o sin posición.'], 404);
        }

        $pos = $tren->posicion;

        return response()->json([
            'tren' => $tren->TrenNombre,
            'estado' => $pos->Estado,
            'estacion_actual' => $pos->EstacionActualID,
            'estacion_siguiente' => $pos->EstacionSiguienteID,
            'hora_llegada' => $pos->HoraLlegadaEstimada,
            'hora_salida' => $pos->HoraSalidaEstimada,
        ]);
    }
}

