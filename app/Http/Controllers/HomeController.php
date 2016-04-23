<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Maximum of four featured events can be accomodated on the website
        //The featured events will be set by rachel in the overall admin.

        $featuredevents = Event::published()->featured()->get();

        return view('home')->with('featuredevents', $featuredevents);
    }
}
