<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    //
    protected $fillable = [
        'user_id',
        'event_id',
        'competition_id',
        'detail_id',
        'transaction_id',
        'user_lastname',
        'paymentStatus',
        'discounts_applied'
    ];

    /**
     * Entry is associated with one user
     */
    public function user() {
    	return $this->belongsTo('App\User');
    }

    /**
     * Entry is associated with one event
     */
    public function event() {
        return $this->belongsTo('App\Event');
    }

    /**
     * Return the competition
     */
    public function competition() {
        return $this->belongsTo('App\Competition');
    }

    /**
     * Return the detail
     */
    public function detail() {
        return $this->belongsTo('App\Detail');
    }

    /**
     * Return the transaction
     */
    public function transaction() {
        return $this->belongsTo('App\Transaction');
    }

}
