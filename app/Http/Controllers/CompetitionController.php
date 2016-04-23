<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use App\Competition;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CompetitionController extends Controller
{
    /**
     * Create a new competition for a particular event
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        //name, description, fee
        $input['event_id'] = $request->input('event');
        $input['name'] = $request->input('name');
        $input['description'] = $request->input('description');
        $input['fee'] = $request->input('fee');
        //dd($request);
        Competition::create($input);

        //flash a message to the user
        \Flash::success('Competition added successfully');

        //redirect back to the admin page
        //return redirect(action('EventsController@admin', $request->input('event')));
        return Redirect::back()->with(['tabName'=>'competitions']);
    }

    /**
     * Delete a competition
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id) {
        $event = Event::find($request->input('event'));
        $competition = Competition::find($id);
        if ($competition && $event->user_id == $request->user()->id) {
            $competition->delete();
            //Flash a message to the user
            \Flash::success('Competition deleted');
        } else {
            //Flash a message to the user
            \Flash::danger('Sorry, permission denied');
        }

        //Redirect back to the admin page
        //return redirect(action('EventsController@admin', $request->input('event')));
        return Redirect::back()->with(['tabName'=>'competitions']);
    }

    /**
     * Updates the competition
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        //get the event
        $competition = Competition::findOrFail($id);
        //update the event
        $competition->update($request->all());

        //redirect
        //return redirect(action('EventsController@admin', $request->input('event')));
        return Redirect::back()->with(['tabName'=>'competitions']);
    }
}
