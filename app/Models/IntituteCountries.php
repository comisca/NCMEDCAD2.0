<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntituteCountries extends Model
{
    use HasFactory;

    protected $table = 'intitute_countries';

    protected $fillable = [
        'country_event_id',
        'events_id',
        'intitute_id',
        'product_id',
        'qty',
        'price',
        'type_product',
        'status'
    ];

}
