<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //fillable fields
    protected $fillable = [
        'question',
        'answerType',
        'event_id',
        'listItems'
    ];

    /**
     * Get the event that this question belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event() {
        return $this->belongsTo('App\Event');
    }
}
