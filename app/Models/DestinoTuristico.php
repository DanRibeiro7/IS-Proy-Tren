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
        'DesTUbicacion',
        'TipZonaID',
        'DesImagenURL',
    ];
    public $timestamps = false;

        public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'EstID');
    }
    // app/Models/DestinoTuristico.php

public function tipoZona()
{
    return $this->belongsTo(TipoZona::class, 'TipZonaID');
}

}
