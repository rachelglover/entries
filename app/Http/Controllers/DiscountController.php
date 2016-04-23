<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Event;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class DiscountController extends Controller
{
    //
    public function destroy(Request $request, $id) {
        $event = Event::find($request->input('event'));
        $discount = Discount::find($id);
        if ($discount && $event->user_id == $request->user()->id) {
            $discount->delete();
            \Flash::success('Discount deleted');
        } else {
            \Flash::danger('Sorry, permission denied');
        }
        //return redirect(action('EventsController@admin', $request->input('event')));
        return Redirect::back()->with(['tabName' => 'discounts']);
    }

    public function store(Request $request)
    {
        $input['event_id'] = $request->input('event');
        $input['type'] = $request->input('type');
        $input['for'] = $request->input('for');
        $input['value'] = $request->input('value');
        $input['info'] = $request->input('info');
        Discount::create($input);
        \Flash::success('Discount added successfully');
        return Redirect::back()->with(['tabName'=>'discounts']);
    }
}
