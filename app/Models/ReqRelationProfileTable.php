<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReqRelationProfileTable extends Model
{
    use HasFactory;

    protected $table = 'req_relation_profile_tables';

    protected $fillable = [
        'req_id',
        'company_id',
        'type_profile',
        'status',
        'date_vence'
    ];
}
