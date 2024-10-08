<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoFamilia extends Model
{
    use HasFactory;

    protected $table = 'grupos_productos';

    protected $fillable = [
        'id_familia_producto',
        'grupo',
        'descripcion',
        'status'
    ];
}
