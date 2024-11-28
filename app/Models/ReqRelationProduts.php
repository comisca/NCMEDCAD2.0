<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReqRelationProduts extends Model
{
    use HasFactory;

    protected $table = 'req_relation_produts';

    protected $fillable = [
        'product_id',
        'requirement_id',
        'status'
    ];
}
