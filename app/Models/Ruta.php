<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table = 'ruta';
    protected $primaryKey = 'RutID';
    protected $fillable = [
        'EstOrigenID',
        'EstDestinoID',
        'RutTiempoEstimado',
        'RutPrecio',
        

    ];
    public $timestamps = false;

         public function origen()
    {
        return $this->belongsTo(Estacion::class, 'EstOrigenID');
    }
           public function destino()
    {
        return $this->belongsTo(Estacion::class, 'EstDestinoID');
    }
}
