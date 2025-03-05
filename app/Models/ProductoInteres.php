<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoInteres extends Model
{
    use HasFactory;
    protected $table = 'producto_interes';

    protected $fillable = [
        'company_id',
        'nombre_producto',
        'pais_producto',
        'codigo_producto'
    ];
}
