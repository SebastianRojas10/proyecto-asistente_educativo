<?php

// Historia: H-03, H-04, H-07, H-09

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $table = 'respuesta';

    // Clave compuesta usuario_id/pregunta_id. Modelo exclusivamente de lectura.
    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = ['*'];
}
