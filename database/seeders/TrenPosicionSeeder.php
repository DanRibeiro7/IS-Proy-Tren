<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrenPosicionSeeder extends Seeder
{
    public function run()
    {
        DB::table('tren_posicion')->insert([
            'TrenID'                => 1,
            'EstacionActualID'      => 1,
            'EstacionSiguienteID'   => 2,
            'HoraLlegadaEstimada'   => now()->addSeconds(10),
            'updated_at'            => now(),
        ]);
    }
}
