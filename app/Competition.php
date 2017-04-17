<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'fee',
        'event_id',
    ];

    /**
     * Get the event this competition belongs to
     */
    public function event() {
        return $this->belongsTo('App\Event');
    }

    /**
     * Get all the details associated with this competition
     */
    public function details() {
        return $this->hasMany('App\Detail');
    }

    /**
     * Get all the entries associated with this competition
     */
    public function entries() {
        return $this->hasMany('App\Entry');
    }
}

