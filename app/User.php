<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * User can have many events
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
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
        $entries = $this->hasMany('App\Entry')->where('event_id','=', $event_id)->get();
        #dd($entries);
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
    
    
    /**
     * Fillable user fields (for registration)
     */
    protected $fillable = array(
        'email',
        'firstname',
        'lastname',
        'club',
        'homeCountry',
        'phone'
    );

}
