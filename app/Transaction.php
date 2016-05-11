<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //fillable fields
    protected $fillable = [
        'event_id',
        'user_id',
        'transaction_type', // 'competitor_payment','organiser_transfer','competitor_refund'
        'paypal_sale_id',
        'payment_method',
        'status',
        'total',
        'currency',
        'transaction_fee'
    ];

    /**
     * Transaction can be associated with many entries
     */
    public function entries() {
        return $this->hasMany('App\Entry');
    }
}
