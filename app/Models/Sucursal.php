<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $fillable = [
        'codigo_fiscal',
        'nombre',
        'es_global',
        'activo'
    ];
}
