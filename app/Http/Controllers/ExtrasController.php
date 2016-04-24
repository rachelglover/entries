<?php

namespace App\Http\Controllers;

use App\Event;
use App\Extra;
use App\Http\Requests\ExtrasFormRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ExtrasController extends Controller
{
    /**
     * Store the extras for this event.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ExtrasFormRequest $request) {

        Extra::create($request->all());

        \Flash::success('Extra added successfully');

        //return redirect(action('EventsController@admin', $request->input('event_id')));
        return Redirect::back()->with(['tabName'=>'extras']);
    }

    /**
     * Delete an extra
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id) {
        $event = Event::find($request->input('event'));
        $extra = Extra::find($id);
        if ($extra && $event->user_id == $request->user()->id) {
            $extra->delete();
            //Flash a message to the user
            \Flash::success('Extra deleted');
        } else {
            //Flash a message to the user
            \Flash::danger('Sorry, permission denied');
        }

        //Redirect back to the admin page
        //return redirect(action('EventsController@admin', $request->input('event')));
        return Redirect::back()->with(['tabName'=>'extras']);
    }
}
