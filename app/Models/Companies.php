<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\Access\Authorizable as AuthorizableTrait;

class Companies extends Model implements Authenticatable, Authorizable
{
    use HasFactory;
    use AuthorizableTrait;
    use HasRoles;
    use AuthenticatableTrait;

    protected $table = 'companies';

    public function getAuthIdentifierName()
    {
        return 'id'; // Reemplaza 'id' con el nombre de la columna que usas como identificador si es diferente
    }

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
