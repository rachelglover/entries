<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    //fillable fields
    protected $fillable = [
        'name',
        'event_id',
        'cost',
        'multiples',
        'infoRequired',
        'infoRequiredLabel'
    ];

    /**
     * Get the event that this extra belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event() {
        return $this->belongsTo('App\Event');
    }
}
