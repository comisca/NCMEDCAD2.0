<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReqRelationProfile extends Model
{
    use HasFactory;

    protected $table = 'req_relation_profiles';

    protected $fillable = [
        'req_id',
        'profile_id',
        'type_profile',
        'status'
    ];
}
