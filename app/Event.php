<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //Fields that the user can change
    protected $fillable = [
        'name',
        'slug',
        'description',
        'website',
        'postcode',
        'startDate',
        'endDate',
        'imageFilename',
        'closingDate',
        'paypal',
        'lateEntries',
        'lateEntriesFee',
        'registration',
        'featured',
        'registrationFee',
        'user_id', //temporary
    ];

    // Make the dates available to Carbon by protecting them
    protected $dates = ['startDate', 'endDate', 'closingDate'];

    //Scope for published events (query shorthand)
    public function scopePublished($query) {
        $query->where('status', '=', 'published');
    }

    //Scope for unpublished events (query shorthand)
    public function scopeUnpublished($query) {
        $query->where('status','=','unpublished');
    }

    //Scope for featured events (query shorthand)
    public function scopeFeatured($query) {
        $query->where('featured','=',1);
    }

    //Scope for archived events (query shorthand)
    public function scopeArchived($query) {
        $query->where('status','=','archived');
    }

    /**
     * An Event is organised by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the tags associated with this event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags() {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    /**
     * Get a list of tag iDs associated with this event
     * @return array
     */
    public function getTagListAttribute() {
        return $this->tags->lists('id')->all();
    }

    /**
     * Get the competitions associated with this event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function competitions() {
        return $this->hasMany('App\Competition');
    }

    /**
     * Retrieve all the specific questions that the organiser
     * wants to ask of competitors.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions() {
        return $this->hasMany('App\Question');
    }

    /**
     * Retrieve all the answers to questions that the organiser
     * asked of all the competitors.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers() {
        return $this->hasMany('App\Answer');
    }

    /**
     * Discounts associated with this event
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discounts() {
        return $this->hasMany('App\Discount');
    }

    /**
     * Optional extras associated with this event.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function extras() {
        return $this->hasMany('App\Extra');
    }

    /**
     * Optional extras (orders) associated with this event. 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function extrasOrdered() {
        return $this->hasMany('App\ExtraOrder');
    }

    /**
     * Event transactions
     */
    public function transactions() {
        return $this->hasMany('App\Transaction');
    }

    /**
     * Event can have many entries
     */
    public function entries() {
        return $this->hasMany('App\Entry');
    }

    

    /**
     * Event can have many competitors entered
     */
    public function competitors() {
        $entries = $this->hasMany('App\Entry');
        $competitors = $entries->groupBy('user_id');
        return $competitors;
    }

    /**
     * Get the name of the event organiser
     */
    public function getOrganiserName() {
        $organiser = User::findOrFail($this->user_id);
        $name = $organiser->firstname . " " . $organiser->lastname;
        return $name;
    }

    /**
     * Format the post-code for google maps search
     */
    public function getGoogleMapLink() {
        $postcode = $this->postcode;
        $formattedPostcode = preg_replace('/ /','+',$postcode);
        $link = "https://www.google.co.uk/maps/place/" . $formattedPostcode;
        return $link;
    }

    
}
