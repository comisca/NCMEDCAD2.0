<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentApplications extends Model
{
    use HasFactory;

    protected $table = 'document_applications';

    protected $fillable = [
        'req_application_id',
        'document_name',
        'descriptions',
        'attachment',
        'status'
    ];
}
