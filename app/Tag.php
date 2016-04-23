<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //allow name to be filled
    protected $fillable = [
        'name'
    ];

    /**
     * Get the events associated with this tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events() {
        return $this->belongsToMany('App\Event');
    }
}
