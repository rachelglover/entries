<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Omnipay\Omnipay;

class PagesController extends Controller
{
    
    /**
     * Show the home page
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

    // Static page: about
    public function about() {
        return view('pages.about');
    }

    // Static page: contact
    public function contact() {
        return view('pages.contact');
    }

    // Static page: why
    public function why() {
        return view('pages.why');
    }

    // Static page: terms and conditions
    public function terms() {
        return view('pages.terms');
    }

    // Static page: FAQs
    public function faq() {
        return view('pages.faq');
    }

    /**
     * Page for the users' events.
     * @return mixed
     */
    public function userEvents() {
        $user = Auth::user();
        return view('user.events')->with(['user' => $user]);
    }

    /**
     * Page for the users' entries.
     * @return mixed
     */
    public function userEntries() {
        $user = Auth::user();
        $event_ids = $user->entries()->pluck('event_id')->unique();
        $eventsarray = array();
        foreach ($event_ids as $event_id) {
            $eventsarray[] = Event::findOrFail($event_id);
        }
        $events = collect($eventsarray);
        return view('user.entries')->with(['user' => $user, 'events' => $events]);
    }

    /**
     * Page for the user profile.
     * @return mixed
     */
    public function userProfile() {
        $user = Auth::user();
        return view('user.profile')->with(['user' => $user]);
    }
    

    /**
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function publish(Request $request, $slug) {
        //get the event
        //$event = Event::findOrFail($id);
        $event = Event::where('slug','=',$slug)->firstOrFail();
        if ($event) {
            $event->status = "published";
            $event->save();
        }
        $user = Auth::user();
        \Flash::success('Congratulations, your event is now live and ready to accept entries');
        return redirect()->action('EventsController@admin', $event->slug)->with(['user' => $user, 'event' => $event]);
    }
    /**
     * Site administration page for me - toggle Featured event
     */
    public function siteAdminToggleFeatured(Request $request,$slug) {
        $event = Event::where('slug','=',$slug)->firstOrFail();
        #dd($event);
        if ($event->featured == 1) {
            $event->featured = 0;
            $event->save();
            \Flash::success($event->name . " no longer featured");
        } else{
            if ($event->status == "published") {
                $event->featured = 1;
                $event->save();
                \Flash::success($event->name . " is now featured!");
            } else {
                \Flash::error($event->name . " can't be featured as it hasn't been published by the organiser yet.");
            }
        }
        return redirect()->action('EventsController@siteAdmin');
    }

    /**
     * Contact form - sends email
     */
    public function processContactForm(Request $request) {
        \Mail::send('pages.contact',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message')
            ), function($message)
            {
                $message->from('contact@foresightentries.com');
                $message->to('contact@foresightentries.com', 'Admin')->subject('Contact from ForesightEntries.com');
            });

        \Flash::success('Thanks for contacting us! We\'ve received your message and We\'ll respond as soon as possible (normally within 24 hours or less).');
        return redirect()->back();
    }

}
