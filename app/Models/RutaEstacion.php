<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RutaEstacion extends Model
{
    protected $table = 'ruta_estacion'; // si el nombre de la tabla es diferente al plural de la clase
    protected $primaryKey = 'id'; // o 'id' si usas otro PK
    public $timestamps = false;
}
