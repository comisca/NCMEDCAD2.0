<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $fillable = [
        'name',
        'iso2',
        'iso3',
        'phone_code',
        'capital',
        'currency',
        'currency_symbol',
        'status'
    ];


    public function states()
    {
        return $this->hasMany(StateCountries::class);
    }

}
