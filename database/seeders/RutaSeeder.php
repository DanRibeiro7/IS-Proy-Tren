<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RutaSeeder extends Seeder
{
    public function run()
    {
        $numEstaciones = 14;
        $rutaData = [];

        // Crear rutas de ida (1 -> 2, 2 -> 3, ..., 13 -> 14)
        for ($i = 1; $i < $numEstaciones; $i++) {
            $rutaData[] = [
                'EstOrigenID' => $i,
                'EstDestinoID' => $i + 1,
                'RutTiempoEstimado' => 0.1667, // 10 segundos en minutos
                'RutPrecio' => 5,              // 5 soles
            ];
        }

        // Crear rutas de vuelta (14 -> 13, 13 -> 12, ..., 2 -> 1)
        for ($i = $numEstaciones; $i > 1; $i--) {
            $rutaData[] = [
                'EstOrigenID' => $i,
                'EstDestinoID' => $i - 1,
                'RutTiempoEstimado' => 0.1667,
                'RutPrecio' => 5,
            ];
        }

        DB::table('ruta')->insert($rutaData);
    }
}
