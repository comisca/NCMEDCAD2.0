<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intitutions extends Model
{
    use HasFactory;

    protected $table = 'intitutions';

    protected $fillable = [
        'country_id',
        'name_institution',
        'acronym',
        'status'
    ];


}
