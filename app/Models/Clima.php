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
        
    ];
    public $timestamps = false;

        public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'EstID');
    }
}
