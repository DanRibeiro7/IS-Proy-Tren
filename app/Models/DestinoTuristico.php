<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinoTuristico extends Model
{
     protected $table = 'destino_turistico';
    protected $primaryKey = 'DesTID';
    protected $fillable = [
        'DesTNombre',
        'DesTDescripcion',
        'EstID',
        'DesTUbicacion'
    ];
    public $timestamps = false;

        public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'EstID');
    }
}
