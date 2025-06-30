<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tren;
use App\Models\TrenPosicion;
use App\Models\RutaEstacion;
use Carbon\Carbon;

class SimularMovimientoTren extends Command
{
    protected $signature = 'tren:simular-movimiento';
    protected $description = 'Simula el movimiento del tren entre estaciones';

    public function handle()
    {
        $tren = Tren::with('posicion')->where('TrenEstado', 'activo')->first();

        if (!$tren || !$tren->posicion) {
            $this->error("No hay tren activo o posición inicial.");
            return 1;
        }

        $pos = $tren->posicion;
        $ahora = Carbon::now();

        if ($pos->Estado === 'en_movimiento') {
            // Si aún no ha llegado a la siguiente estación
            if ($ahora->lt(Carbon::parse($pos->HoraLlegadaEstimada))) {
                $this->info("Tren en movimiento, llegará a la estación {$pos->EstacionSiguienteID} a las {$pos->HoraLlegadaEstimada}");
                return 0; // Esperar a que llegue
            }

            // Llegó a la estación siguiente
            $pos->EstacionActualID = $pos->EstacionSiguienteID;
            $pos->HoraSalidaEstimada = $ahora->addSeconds(3); // Se detiene 3 segundos
            $pos->Estado = 'detenido';
            $pos->save();

            $this->info("Tren llegó a estación {$pos->EstacionActualID}, detenido hasta {$pos->HoraSalidaEstimada}");
        } 
        elseif ($pos->Estado === 'detenido') {
            if ($ahora->lt(Carbon::parse($pos->HoraSalidaEstimada))) {
                $this->info("Tren detenido en estación {$pos->EstacionActualID} hasta {$pos->HoraSalidaEstimada}");
                return 0; // Sigue detenido
            }

            // Busca la siguiente estación en la ruta
            // Aquí debes buscar la siguiente estación basada en la ruta y el orden actual
            $siguiente = $this->obtenerSiguienteEstacion($pos);

            if (!$siguiente) {
                $this->info("Tren terminó recorrido en estación {$pos->EstacionActualID}");
                return 0; // Fin de la ruta
            }

            $pos->EstacionSiguienteID = $siguiente->EstacionID;
            $pos->HoraLlegadaEstimada = $ahora->addSeconds(10); // 10 segundos para llegar
            $pos->Estado = 'en_movimiento';
            $pos->save();

            $this->info("Tren arrancó hacia estación {$pos->EstacionSiguienteID}, llegará a las {$pos->HoraLlegadaEstimada}");
        } else {
            $this->error("Estado desconocido en la posición del tren.");
        }

        return 0;
    }

    private function obtenerSiguienteEstacion($pos)
    {
        // Aquí debes implementar la lógica para determinar la siguiente estación
        // Puede ser con base en la tabla ruta_estacion, orden, etc.
        // Ejemplo simple: buscar la estación siguiente con orden +1 en la misma ruta

        $rutaId = $pos->RutaID ?? 1; // Asume ruta 1 si no hay ruta definida

        $actualOrden = \DB::table('ruta_estacion')
            ->where('RutaID', $rutaId)
            ->where('EstacionID', $pos->EstacionActualID)
            ->value('Orden');

        if (!$actualOrden) {
            return null; // No encontró orden actual
        }

        $siguiente = \DB::table('ruta_estacion')
            ->where('RutaID', $rutaId)
            ->where('Orden', $actualOrden + 1)
            ->first();

        return $siguiente;
    }
}
