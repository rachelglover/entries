<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    //Fields that the user can change
    protected $fillable = [
        'name',
        'description',
        'fee',
        'event_id',
    ];

    /**
     * Get the event that this competition belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event() {
        return $this->belongsTo('App\Event');
    }

    /**
     * Get all the details associated with this competition.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
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
