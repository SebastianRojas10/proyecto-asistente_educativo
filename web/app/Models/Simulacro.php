<?php

// Historia: H-03, H-04, H-07, H-09

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Simulacro extends Model
{
    protected $table = 'simulacro';

    protected $primaryKey = 'simulacro_id';

    public $timestamps = false;

    protected $guarded = ['*'];

    protected function casts(): array
    {
        return ['fecha_aplicacion' => 'date'];
    }

    public function preguntas(): HasMany
    {
        return $this->hasMany(Pregunta::class, 'simulacro_id');
    }
}
