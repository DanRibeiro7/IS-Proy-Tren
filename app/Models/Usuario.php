<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
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

    protected $hidden = [
        'UsuPassword',
    ];

    public function getAuthPassword()
    {
        return $this->UsuPassword;
    }

    public function getAuthIdentifierName()
    {
        return 'UsuCorreo';
    }
}
