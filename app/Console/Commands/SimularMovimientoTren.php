<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tren;
use App\Models\TrenPosicion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            if ($ahora->lt(Carbon::parse($pos->HoraLlegadaEstimada))) {
                $this->info("Tren en movimiento hacia estación {$pos->EstacionSiguienteID}, llegará a las {$pos->HoraLlegadaEstimada}");
                return 0;
            }

            $pos->EstacionActualID = $pos->EstacionSiguienteID;
            $pos->HoraSalidaEstimada = $ahora->copy()->addSeconds(3);
            $pos->Estado = 'detenido';
            $pos->save();

            $this->info("Tren llegó a estación {$pos->EstacionActualID}, detenido hasta {$pos->HoraSalidaEstimada}");
        } 
        elseif ($pos->Estado === 'detenido') {
            if ($ahora->lt(Carbon::parse($pos->HoraSalidaEstimada))) {
                $this->info("Tren detenido en estación {$pos->EstacionActualID} hasta {$pos->HoraSalidaEstimada}");
                return 0;
            }

            $siguiente = $this->obtenerSiguienteEstacion($pos);

            if (!$siguiente) {
                if ($pos->RutaID == 1) {
                    $this->info("Tren terminó ruta de ida. Iniciando ruta de regreso...");

                    $pos->RutaID = 2;
                    $nuevaEstacion = $this->obtenerPrimeraEstacion(2);

                    if (!$nuevaEstacion) {
                        $this->error("No se encontró estación para ruta de regreso.");
                        return 0;
                    }

                    $pos->EstacionSiguienteID = $nuevaEstacion;
                    $pos->HoraLlegadaEstimada = $ahora->copy()->addSeconds(10);
                    $pos->Estado = 'en_movimiento';
                    $pos->save();

                    $this->info("Tren arrancó hacia estación {$pos->EstacionSiguienteID} (ruta de regreso), llegará a las {$pos->HoraLlegadaEstimada}");
                    return 0;
                } 
                elseif ($pos->RutaID == 2) {
                    $this->info("Tren completó el recorrido de ida y vuelta. Fin del trayecto en estación {$pos->EstacionActualID}");

                    if ($pos->EstacionActualID == 1) {
                        $tren->bucle_actual += 1;
                        $tren->save();

                        $this->info("Bucle número {$tren->bucle_actual} completado.");

                        if ($tren->bucle_actual >= 3) {
                            $this->info("🚦 El tren ha completado los 3 bucles. Finalizando operación.");
                            $tren->TrenEstado = 'fuera_servicio';
                            $tren->save();

                            $pos->Estado = 'detenido';
                            $pos->save();

                            return 0;
                        }

                        // Reiniciar a la ruta de ida
                        $this->info("🔄 Reiniciando a la ruta de ida...");
                        $pos->RutaID = 1;
                        $nuevaEstacion = $this->obtenerPrimeraEstacion(1);

                        if (!$nuevaEstacion) {
                            $this->error("No se encontró estación para ruta de ida.");
                            return 0;
                        }

                        $pos->EstacionSiguienteID = $nuevaEstacion;
                        $pos->HoraLlegadaEstimada = Carbon::now()->copy()->addSeconds(10);
                        $pos->Estado = 'en_movimiento';
                        $pos->save();

                        $this->info("Tren arrancó hacia estación {$pos->EstacionSiguienteID} (ruta ida), llegará a las {$pos->HoraLlegadaEstimada}");
                        return 0;
                    }

                    return 0;
                }

                $this->error("No se encontró estación siguiente válida.");
                return 0;
            }

            // Continuar ruta normal
            $pos->EstacionSiguienteID = $siguiente->EstacionID;
            $pos->HoraLlegadaEstimada = $ahora->copy()->addSeconds(10);
            $pos->Estado = 'en_movimiento';
            $pos->save();

            $this->info("Tren arrancó hacia estación {$pos->EstacionSiguienteID}, llegará a las {$pos->HoraLlegadaEstimada}");
        } 
        else {
            $this->error("Estado desconocido en la posición del tren.");
        }

        return 0;
    }

    private function obtenerSiguienteEstacion($pos)
    {
        $rutaId = $pos->RutaID ?? 1;

        $actualOrden = DB::table('ruta_estacion')
            ->where('RutaID', $rutaId)
            ->where('EstacionID', $pos->EstacionActualID)
            ->value('Orden');

        if (!$actualOrden) {
            return null;
        }

        return DB::table('ruta_estacion')
            ->where('RutaID', $rutaId)
            ->where('Orden', $actualOrden + 1)
            ->first();
    }

    private function obtenerPrimeraEstacion($rutaId)
    {
        $primera = DB::table('ruta_estacion')
            ->where('RutaID', $rutaId)
            ->orderBy('Orden')
            ->first();

        return $primera ? $primera->EstacionID : null;
    }
}
