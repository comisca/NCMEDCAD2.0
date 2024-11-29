<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReqApplications extends Model
{
    use HasFactory;

    protected $table = 'req_applications';

    protected $fillable = [
        'application_id',
        'requirement_id',
        'distribution_id',
        'product_id',
        'fabric_id',
        'message',
        'states_req_applications',
        'status',
    ];
}
