<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    protected $table = 'estacion';
    protected $primaryKey = 'EstID';
    protected $fillable = [
        'EstNombre',
        'EstUbicacion',
    ];
    public $timestamps = false;
}
