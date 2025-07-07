<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clima extends Model
{
    protected $table = 'clima';
    protected $primaryKey = 'CliID';
    protected $fillable = [
        'CliFecha',
        'CliClima',
        'EstID',
        'TipClimaID',
        
    ];
    public $timestamps = false;

        public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'EstID');
    }
    public function tipoClima()
{
    return $this->belongsTo(TipoClima::class, 'TipClimaID');
}
}
