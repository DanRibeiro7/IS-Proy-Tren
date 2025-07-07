<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
public function tiempoEspera($estacionId)
{
    $tren = Tren::with('posicion')->where('TrenEstado', 'activo')->first();

    if (!$tren || !$tren->posicion) {
        return response()->json(['error' => 'Tren no disponible.'], 404);
    }

    $pos = $tren->posicion;
    $rutaActual = $pos->RutaID;

    $ordenTren = DB::table('ruta_estacion')
        ->where('RutaID', $rutaActual)
        ->where('EstacionID', $pos->EstacionActualID)
        ->value('Orden');

    $ordenOrigen = DB::table('ruta_estacion')
        ->where('RutaID', $rutaActual)
        ->where('EstacionID', $estacionId)
        ->value('Orden');

    if (is_null($ordenOrigen) || is_null($ordenTren)) {
        return response()->json(['error' => 'No se pudo obtener orden.'], 400);
    }

    // 🟢 El tren aún no ha pasado
    if ($ordenOrigen >= $ordenTren) {
        return response()->json([
            'espera' => 0,
            'espera_segundos' => 0,
            'espera_formateada' => '00:00',
            'mensaje' => 'El tren aún no ha pasado por esta estación.',
        ]);
    }

    // 🔴 El tren ya pasó
    $total_estaciones = 14;
    $tiempo_por_tramo = 10; // segundos por tramo
    $tramos_restantes = $ordenTren - $ordenOrigen;

    $tiempo_faltante = ($total_estaciones * 2 - $tramos_restantes) * $tiempo_por_tramo;

    $horas = floor($tiempo_faltante / 3600);
    $minutos = floor(($tiempo_faltante % 3600) / 60);
    $segundos = $tiempo_faltante % 60;

    $formateado = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);

    return response()->json([
        'espera' => round($tiempo_faltante / 3600, 2), // 👈 clave para JS
        'espera_segundos' => $tiempo_faltante,
        'espera_formateada' => $formateado,
        'mensaje' => 'El tren ya pasó. Este es el tiempo estimado hasta que vuelva.',
    ]);
}

}

