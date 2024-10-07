<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisitos extends Model
{
    use HasFactory;

    protected $table = 'requisitos';

    protected $fillable = [
        'grupo_requisito_id',
        'id_familia_producto',
        'codigo',
        'tipo_requisitos',
        'tipo_participante',
        'tipo_validacion',
        'descripcion',
        'mensaje_nocumple',
        'obligatorio',
        'ficha',
        'vence',
        'entregable',
    ];
}
