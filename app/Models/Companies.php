<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $fillable = [
        'legal_name',
        'country',
        'city',
        'address',
        'phone',
        'facsimile',
        'website',
        'first_name',
        'last_name',
        'email',
        'phone_contact',
        'user_name',
        'password',
        'type_company',
        'status',
        'logo_companies',
        'country_id',
        'state_id',
        'family_id',
        'phone_whatsapp'
    ];
}
