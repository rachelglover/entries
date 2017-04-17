<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * User can organise many events
     */
    public function events() {
        return $this->hasMany('App\Event');
    }

    /**
     * User can have many entries
     */
    public function entries() {
        return $this->hasMany('App\Entry');
    }

    /**
     * Should the user see the 'withdraw from the entire event' button?
     * True: >1 entry with status 'paid'
     * False: all entries with status 'pending_cancellation' or 'cancelled'
     */
    public function showWithdrawFromEventButton($event_id) {
        $entries = $this->hasMany('App\Entry')->where('event_id', '=', $event_id)->get();
        foreach ($entries as $entry) {
            if ($entry->paymentStatus == 'paid') {
                return True;
            }
        }
        return False;
    }

    /**
     * User has multiple entries to one event
     */
    public function eventEntries($event_id) {
        return $this->hasMany('App\Entry')->where('event_id','=',$event_id)->get();
    }

}
