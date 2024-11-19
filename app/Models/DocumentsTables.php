<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsTables extends Model
{
    use HasFactory;

    protected $table = 'documents_tables';

    protected $fillable = [
        'document_id',
        'table_name',
        'table_id',
        'document_name',
        'attachment',
        'ext_document',
        'size_document',
        'img_front',
        'img_back',
        'img_selfie',
        'status',
    ];
}
