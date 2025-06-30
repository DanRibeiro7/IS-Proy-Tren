<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrenSeeder extends Seeder
{
    public function run()
    {
        DB::table('tren')->insert([
            'TrenNombre'     => 'Tren A',
            'TrenVelocidad'  => 30.00, // solo de referencia
            'TrenEstado'     => 'activo',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }
}
