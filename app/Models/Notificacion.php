<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificacion';
    protected $primaryKey = 'NotID';
    protected $fillable = [
        'UsuID',
        'NotTipo',
        'NotMensaje',
        'NotEnviada',
        'NotFechaEnvio',

    ];
    public $timestamps = false;

        public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UsuID');

    }
}
