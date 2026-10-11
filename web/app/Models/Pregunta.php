<?php

// Historia: H-03, H-04, H-07, H-09

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pregunta extends Model
{
    protected $table = 'pregunta';

    protected $primaryKey = 'pregunta_id';

    public $timestamps = false;

    protected $guarded = ['*'];

    public function tema(): BelongsTo
    {
        return $this->belongsTo(Tema::class, 'tema_id');
    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(Respuesta::class, 'pregunta_id');
    }
}
