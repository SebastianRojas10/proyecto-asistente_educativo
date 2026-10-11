<?php

// Historia: H-07, H-09, H-11

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Grupo extends Model
{
    protected $table = 'grupo';

    protected $primaryKey = 'grupo_id';

    public $timestamps = false;

    protected $guarded = ['*'];

    public function estudiantes(): BelongsToMany
    {
        return $this->belongsToMany(Usuario::class, 'estudiante_grupo', 'grupo_id', 'usuario_id')
            ->wherePivot('vigente', 1)->where('usuario.activo', 1)->where('usuario.rol', 'estudiante');
    }

    public function simulacros(): BelongsToMany
    {
        return $this->belongsToMany(Simulacro::class, 'simulacro_grupo', 'grupo_id', 'simulacro_id');
    }
}
