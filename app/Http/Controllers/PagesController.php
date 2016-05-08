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

}
