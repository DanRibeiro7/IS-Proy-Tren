<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tren extends Model
{
        protected $table = 'tren';
    protected $primaryKey = 'TrenID';

    protected $fillable = [
        'TrenNombre',
        'TrenVelocidad',
        'TrenEstado'
    ];

    public function posiciones()
    {
        return $this->hasMany(TrenPosicion::class, 'TrenID');
    }

    public function posicion()
{
    return $this->hasOne(TrenPosicion::class, 'TrenID');
}

}
