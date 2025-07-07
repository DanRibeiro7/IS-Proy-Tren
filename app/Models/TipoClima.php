<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoClima extends Model
{
    protected $table = 'tipo_clima';
    protected $primaryKey = 'TipClimaID';
    public $timestamps = false;

    protected $fillable = ['TipClimaNombre'];

    // Relación inversa con clima (si existe)
    public function climas()
    {
        return $this->hasMany(Clima::class, 'TipClimaID');
    }
}
