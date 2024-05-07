<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamentos extends Model
{
    use HasFactory;
    protected $fillable = ['id_familia_producto', 'id_grupo_familia', 'id_grupo_requerimiento','cod_medicamento', 'descripcion', 'requiere_cadena_frio', 'activo'];
    public function fam_producto()
    {
        return $this->belongsTo(FamiliaProducto::class, 'id_familia_producto');
    }
    public function grp_requisitos()
    {
        return $this->belongsTo(GrupoRequisitos::class, 'id_grupo_requerimiento');
    }
    public function grp_familia()
    {
        return $this->belongsTo(GrupoFamilia::class, 'id_grupo_familia');
    }
    
}
