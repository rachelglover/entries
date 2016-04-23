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

    // List user-created events
    public function userEvents() {
        $user = Auth::user();
        return view('user.events')->with(['user' => $user]);
    }

    // List user entries
    public function userEntries() {
        $user = Auth::user();
        return view('user.entries')->with(['user' => $user]);
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
