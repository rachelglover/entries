<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    protected $fillable = [
        'event_id',
        'type',
        'value',
        'for',
        'info',
    ];

    /**
     * Discount is associated with one event
     */
    public function event() {
        return $this->belongsTo('App\Event');
    }
}
