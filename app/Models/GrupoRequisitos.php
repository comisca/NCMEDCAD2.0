<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoRequisitos extends Model
{
    use HasFactory;

    protected $table = 'grupos_requisitos';

    protected $fillable = [
        'id_familia_producto',
        'grupo',
        'descripcion',
        'orden',
        'status'
    ];
}
