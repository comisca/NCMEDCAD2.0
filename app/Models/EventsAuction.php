<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsAuction extends Model
{
    use HasFactory;

    protected $table = 'events_auctions';
    protected $fillable = ['family_id', 'years', 'event_name', 'observation', 'status'];

}
