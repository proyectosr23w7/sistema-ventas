<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permisos';

    protected $fillable = [
        'codigo',
        'descripcion',
        'modulo',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permiso')
            ->withPivot('tipo');
    }


    public function hasPermiso(string $codigo): bool
    {
        // 1️⃣ Denegación explícita
        $deny = $this->permisos()
            ->wherePivot('tipo', 'deny')
            ->where('codigo', $codigo)
            ->exists();

        if ($deny) {
            return false;
        }

        // 2️⃣ Permiso directo allow
        $allow = $this->permisos()
            ->wherePivot('tipo', 'allow')
            ->where('codigo', $codigo)
            ->exists();

        if ($allow) {
            return true;
        }

        // 3️⃣ Permisos por rol
        return $this->roles()
            ->whereHas('permisos', fn($q) => $q->where('codigo', $codigo))
            ->exists();
    }
}
