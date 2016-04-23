<?php

namespace App\Http\Controllers;

use App\Event;
use App\Question;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class QuestionController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        //question, answerType, event_id
        $input['event_id'] = $request->input('event');
        $input['question'] = $request->input('question');
        $input['answerType'] = $request->input('answerType');
        $input['listItems'] = $request->input('listItems');
        // put the formatted dropdownlist into $input['listItems']
        Question::create($input);

        //Flash a message to the user
        \Flash::success('Question added successfully');

        //Redirect back to the admin page
        //return redirect(action('EventsController@admin', $request->input('event')));
        return Redirect::back()->with(['tabName'=>'questions']);
    }

    /**
     * Delete a question
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id) {
        $event = Event::find($request->input('event'));
        $question = Question::find($id);
        if ($question && $event->user_id == $request->user()->id) {
            $question->delete();
            //Flash a message to the user
            \Flash::success('Question deleted');
        } else {
            //Flash a message to the user
            \Flash::danger('Sorry, permission denied');
        }

        //Redirect back to the admin page
        //return redirect(action('EventsController@admin', $request->input('event')));
        return Redirect::back()->with(['tabName'=>'questions']);
    }
}
