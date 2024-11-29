<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'product_id',
        'family_id',
        'requirement_id',
        'distribution_id',
        'fabric_id',
        'message',
        'states_applications',
        'number_registration_salud',
        'number_registration_fabric',
        'trade_name',
        'country_id',
        'status'
    ];
}
