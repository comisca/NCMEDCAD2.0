<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostorEvent extends Model
{
    use HasFactory;

    protected $table = 'postor_events';

    protected $fillable = [
        'event_id',
        'postor_id',
        'type_postor',
        'id_product_event',
        'name_anonimous',
        'status'
    ];
}
