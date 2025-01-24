<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pujas extends Model
{
    use HasFactory;

    protected $table = 'pujas';

    protected $fillable = [
        'auction_id',
        'postor_id',
        'amount',
        'puja_time',
        'code_postor',
        'winner_puja',
        'status',
    ];
}
