<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoZona extends Model
{
        protected $table = 'tipo_zona';
    protected $primaryKey = 'TipZonaID';
    public $timestamps = false;

    protected $fillable = ['TipZonaNombre'];

    public function destinos()
    {
        return $this->hasMany(DestinoTuristico::class, 'TipZonaID');
    }
}
