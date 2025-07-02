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
    public function zonaTuristica()
{
    return $this->hasOne(\App\Models\DestinoTuristico::class, 'EstID', 'EstID');
}

public function clima()
{
    return $this->hasOne(\App\Models\Clima::class, 'EstID', 'EstID');
}
}

