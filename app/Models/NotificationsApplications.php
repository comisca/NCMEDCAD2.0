<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsApplications extends Model
{
    use HasFactory;

    protected $table = 'notifications_applications';

    protected $fillable = [
        'req_application_id',
        'distribuidor_id',
        'message',
        'status',
    ];
}
