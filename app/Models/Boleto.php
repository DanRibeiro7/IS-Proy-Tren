<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boleto extends Model
{
        protected $table = 'boleto';
    protected $primaryKey = 'BolID';
    protected $fillable = [
        'UsuID',
        'RutID',
        'BolFechaviaje',
        'BolHoraSalida',
        'BolPrecio',
        'BolEstado',
        'BolCreadoEn',

    ];
    public $timestamps = false;

        public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UsuID');
    }

    // Un boleto pertenece a una ruta
    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'RutID');
}
}

