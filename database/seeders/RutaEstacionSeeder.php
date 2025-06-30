<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RutaEstacionSeeder extends Seeder
{
    public function run()
    {
        $orden = 1;

        // Ruta de ida: RutaID = 1
        for ($i = 1; $i <= 14; $i++) {
            DB::table('ruta_estacion')->insert([
                'RutaID'      => 1,
                'EstacionID'  => $i,
                'Orden'       => $orden++,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $orden = 1;

        // Ruta de vuelta: RutaID = 2
        for ($i = 14; $i >= 1; $i--) {
            DB::table('ruta_estacion')->insert([
                'RutaID'      => 2,
                'EstacionID'  => $i,
                'Orden'       => $orden++,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
