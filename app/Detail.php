<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    //fields that the user can change.
    protected $fillable = [
        'name',
        'max',
        'dateTime',
        'competition_id'
    ];

    //carbon date
    protected $dates = [
        'dateTime',
    ];

    /**
     * Get the competition that this detail belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function competition() {
        return $this->belongsTo('App\Competition');
    }

    /**
     * Get all the entries for this detail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries() {
        return $this->hasMany('App\Entry');
    }
}
