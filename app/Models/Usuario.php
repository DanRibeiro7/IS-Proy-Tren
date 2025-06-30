<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'UsuID';
    protected $fillable = [
        'UsuNombres',
        'UsuApellidos',
        'UsuCorreo',
        'UsuNumero',
        'UsuPassword',
        'UsuTipoUsuario'

    ];
    public $timestamps = false;
}
