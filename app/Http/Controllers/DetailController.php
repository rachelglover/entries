<?php

namespace App\Http\Controllers;

use App\Detail;
use App\Event;
use App\Http\Requests\DetailFormRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DetailController extends Controller
{
    /**
     * Store a new detail
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(DetailFormRequest $request) {
        //name, max, datetime
        $input['competition_id'] = $request->input('competition');
        $input['name'] = $request->input('name');
        $input['max'] = $request->input('max');
        $input['dateTime'] = $request->input('dateTime');
        //dd($request);
        Detail::create($input);

        //flash a message to the user
        \Flash::success('Detail added successfully');
        $event = Event::findOrFail($request->input('event'));

        //redirect back to the admin page
        return redirect(action('EventsController@admin', $event->slug));
    }

    /**
     * Delete a detail
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id) {
        $event = Event::find($request->input('event'));
        $detail = Detail::find($id);
        if ($detail && $event->user_id == $request->user()->id) {
            $detail->delete();
            //Flash a message to the user
            \Flash::success('Detail deleted');
        } else {
            //Flash a message to the user
            \Flash::danger('Sorry, permission denied');
        }
        $event = Event::findOrFail($request->input('event'));
        //Redirect back to the admin page
        return redirect(action('EventsController@admin', $event->slug));
    }
}
