<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auctions extends Model
{
    use HasFactory;

    protected $table = 'auctions';

    protected $fillable = [
        'product_id',
        'event_id',
        'type_auction',
        'type_product',
        'auction_state',
        'auction_result',
        'total',
        'price_reference',
        'date_start',
        'hour_start',
        'duration_time',
        'porcentage_reductions',
        'porcentage_tolerance',
        'recovery_time',
        'observation',
        'status',
        'date_end'

    ];
}
