<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreferenciaUsuario extends Model
{
    protected $table = 'preferencia_usuario';
    protected $primaryKey = 'PreUID';
    protected $fillable = [
        'UsuID',
        'EstID',
        'PreUTipoZona',
        'PreUClimaDeseado',
        'PreUDistanciaMaxima',

    ];
    public $timestamps = false;

    
        public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UsuID');

    }
        public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'EstID');
    }

}
