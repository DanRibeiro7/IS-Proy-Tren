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
    'BolHoraLlegada',
    'BolPrecio',
    'BolDistanciaKM',
    'BolMetodoPago',
    'BolEstado',
    'BolCreadoEn',
    'BolEstacionOrigen',
    'BolEstacionDestino',
];

    public $timestamps = false;

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UsuID');
    }

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'RutID');
    }

    public function estacion_origen()
    {
        return $this->belongsTo(Estacion::class, 'BolEstacionOrigen', 'EstID');
    }

    public function estacion_destino()
    {
        return $this->belongsTo(Estacion::class, 'BolEstacionDestino', 'EstID');
    }
}

