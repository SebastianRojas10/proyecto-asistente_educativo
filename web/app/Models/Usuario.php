<?php

// Historia: H-01, H-04, H-07, H-11

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';

    protected $primaryKey = 'usuario_id';

    public $timestamps = false;

    protected $guarded = ['*'];

    protected $hidden = ['contrasena_hash'];

    protected function casts(): array
    {
        return ['activo' => 'boolean'];
    }

    public function getAuthPasswordName(): string
    {
        return 'contrasena_hash';
    }

    public function gruposDocente(): BelongsToMany
    {
        return $this->belongsToMany(Grupo::class, 'docente_grupo', 'usuario_id', 'grupo_id');
    }
}
