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
     * User has multiple entries to one event
     */
    public function eventEntries($event_id) {
        $entries = $this->hasMany('App\Entry');
        $eventEntries = array();
        foreach ($entries as $entry) {
            if ($entry->event_id == $event_id) {
                $eventEntries[] = $entry;
            }
        }
        return collect($eventEntries);
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
