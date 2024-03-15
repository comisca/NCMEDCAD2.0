<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instituciones extends Model
{
    use HasFactory;
    protected $fillable = ['id_pais', 'institucion', 'id_institucion_padre','paga_cuota', 'cuota_pagada', 'es_minsa', 'encabezado_nota_cobro'];
}
