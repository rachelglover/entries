<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraOrder extends Model
{
    //fillable fields
    protected $fillable = [
        'extra_id',
        'user_id',
        'event_id',
        'multiple',
        'infoRequired',
    ];
}
