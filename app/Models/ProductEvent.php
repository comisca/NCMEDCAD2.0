<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEvent extends Model
{
    use HasFactory;

    protected $table = 'product_events';
    protected $fillable = ['product_id', 'event_id', 'type_product', 'status'];
}
