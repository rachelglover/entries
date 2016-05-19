<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $fillable = [
    	'question_id',
    	'competitor_id',
    	'event_id',
    	'answer',
    ];
}
