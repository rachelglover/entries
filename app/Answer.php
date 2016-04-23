<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $fillable = [
    	'question',
    	'competitor',
    	'event',
    	'answer',
    ];
}
