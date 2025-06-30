<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrenPosicion extends Model
{
    protected $table = 'tren_posicion';
    protected $primaryKey = 'PosID';

    protected $fillable = [
        'TrenID',
        'EstacionActualID',
        'EstacionSiguienteID',
        'HoraLlegadaEstimada'
    ];

    public $timestamps = false;

    public function tren()
    {
        return $this->belongsTo(Tren::class, 'TrenID');
    }

    public function estacionActual()
    {
        return $this->belongsTo(Estacion::class, 'EstacionActualID');
    }

    public function estacionSiguiente()
    {
        return $this->belongsTo(Estacion::class, 'EstacionSiguienteID');
    }
}
