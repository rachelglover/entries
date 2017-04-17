<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    //
    protected $fillable = [
        'name',
        'max',
        'dateTime',
        'competition_id'
    ];

    //carbond ate
    protected $dates = [
        'dateTime',
    ];

    /**
     * Get the competition that this detail belongs to
     */
    public function competition() {
        return $this->belongsTo('App\Competition');
    }

    /**
     * Get all the entries for this detail
     */
    public function entries() {
        return $this->hasMany('App\Entry');
    }

    /**
     * Return the number of free places on this detail
     */
    public function placesLeft() {
        $entries = Entry::where('detail_id', '=', $this->id);
        $numEntries = $entries->count();
        $left = $this->max - $numEntries;
        return $left;
    }
}
