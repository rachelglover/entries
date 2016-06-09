<?php

namespace App\Http\Controllers;

use App\Detail;
use App\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventFormRequest;
use App\Tag;
use App\Competition;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Khill\Lavacharts\Lavacharts;

class EventsController extends Controller
{
    //For this whole controller, trigger the 'auth' middleware.
    //Second variable restricts middleware to only the create method
    //Can also be ['except' => 'create'] to apply to all except create.
    /**
     * Create a new event's controller instance
     * EventsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => array('index','show')]);
    }

    /**
     * List all the current events
     *
     * @return $this
     */
    public function index()
    {
        // Get all the events
        $events = Event::latest()->published()->get();

        return view('events.index')->with('events', $events);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $slug) {
        //$event = Event::find($id);
        $event = Event::where('slug', '=', $slug)->firstOrFail();
        //Delete this event.
        if ($event && $event->user_id == $request->user()->id) {
            $event->delete();
            //Flash a message to the user
            \Flash::success('Event deleted');
        } else {
            //Flash a message to the user
            \Flash::danger('Sorry, permission denied');
        }

        //Redirect back to the admin page
        return redirect(action('PagesController@userEvents'));
    }

    /**
     * List a single event
     *
     * @param $id
     * @return $this
     */
    public function show($slug)
    {
        //$event = Event::findOrFail($id);
        $event = Event::where('slug', '=', $slug)->firstOrFail();
        $user = Auth::user();
        $guest = Auth::guest();
        $preview = 'false';
        if ($event->status == "unpublished") {
            $preview = 'true';
        }
        $chart = $this->produceCompetitionsFilledchart($event->competitions()->get());
        return view('events.show')->with(['event' => $event, 'user' => $user, 'preview' => $preview, 'chart' => $chart, 'guest' => $guest]);
    }

    /**
     * Create a new event.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $tags = Tag::lists('name', 'id');
        return view('events.create')->with(['tags' => $tags]);
    }

    /**
     * Store the data for the new event
     *
     * @param EventRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EventFormRequest $request)
    {

        $event = $this->createEvent($request);

        //flash a message to the user
        \Flash::success('Your event was created successfully. Now you need to add competitions and details');

        //redirect
        return redirect(action('EventsController@admin', $event->slug));
    }

    /**
     * @param $id
     * @return $this
     */
    public function edit($slug)
    {
        $tags = Tag::lists('name', 'id');

        //$event = Event::findOrFail($id);
        $event = Event::where('slug', '=', $slug)->firstOrFail();

        //check registration and latefees values and send as variables
        $registration = false;
        $lateEntries = false;
        if ($event->registration == 1) {
            $registration = true;
        }
        if ($event->lateEntries == 1) {
            $lateEntries = true;
        }
        return view('events.edit')->with(['event' => $event, 'tags' => $tags, 'lateEntriesCurrent' => $lateEntries,'registrationCurrent' => $registration]);
    }

    /**
     * Site administration page for me
     * @return $this
     */
    public function siteAdmin() {
        $user = Auth::user();
        if ($user->id == 1) {
            return view('events.edit')->with(['user' => $user]);
        } else {
            \Flash::warning('Sorry, you don\'t have access to that page');
            return redirect()->back();
        }

    }

    /**
     * Main event administration page for organisers
     *
     * @param $id
     * @return $this
     */
    public function admin($slug)
    {
        $event = Event::where('slug', '=', $slug)->firstOrFail();
        $user = Auth::user();
        $competitions = $event->competitions()->get();
        $entries = $event->entries()->get();
        $extrasOrdered = $event->extrasOrdered()->get();
        $competitors = array();
        foreach ($entries as $entry) {
            $competitors[] = $entry->user_id;
        }
        $numCompetitors = count(array_unique($competitors));
        $numEntries = $entries->count();
        $numExtrasOrdered = count($extrasOrdered);
        $totalFees = $this->totalCostAllEntryFees($event->id);
        $transferredFees = $this->transferredEntryFees();

        //Dates
        $now = Carbon::now();
        $differenceClosing = $event->closingDate->diffInDays($now);
        $differenceStart = $event->closingDate->diffInDays($now);

        //Charts for the overview carousel
        //1. Chart showing entries per competition as % filled
        $chart = $this->produceCompetitionsFilledchart($competitions);

        return view('events.admin')->with(['event' => $event, 'user' => $user, 'competitions' => $competitions, 'entries' => $entries, 'numCompetitors' => $numCompetitors, 'numExtrasOrdered' => $numExtrasOrdered, 'transferredFees' => $transferredFees,'totalFees' => $totalFees,'tabName' => 'competitions', 'differenceClosing' => $differenceClosing, 'differenceStarting' => $differenceStart, 'competitionsChart' => $chart, 'numEntries' => $numEntries]);
    }

    /**
     * Chart showing the % places filled for each event
     */
    private function produceCompetitionsFilledChart($competitions) {
        $competitionsChart = new Lavacharts;
        $competitionsTable = $competitionsChart->DataTable();
        $competitionsTable->addStringColumn('Competition')
            ->addNumberColumn('Percent full');
        foreach ($competitions as $competition) {
            $max = 0;
            $entries = 0;
            foreach ($competition->details()->get() as $detail) {
                $entries += $detail->entries()->get()->count();
                $max += $detail->max;
            }
            if ($max > 0 && $entries > 0) {
                $percentage = sprintf('%0.2f',(($entries / $max) * 100));
                $competitionsTable->addRow([$competition->name, $percentage]);
            }
        }
        $competitionsChart->BarChart('CompetitionsFilled', $competitionsTable, [
            'title' => 'Places already filled (%) for each competition',
            'legend' => ['position' => 'bottom'],
            'max' => 100,
            'min' => 0,
            'height' => 350,
        ]);
        return $competitionsChart;
    }

    /**
     * Calculate the total cost of all entries for this event.
     */
    private function totalCostAllEntryFees($id) {
        $event = Event::findOrFail($id);
        $entries = $event->entries()->get();
        $total = 0;
        foreach ($entries as $entry) {
            $competition = $entry->competition()->get();
            foreach ($competition as $comp) {
                $total = $total + $comp->fee;
            }
        }
        return $total;
    }

    /**
     * Return the total amount of entry fees already transferred to owners account
     */
    private function transferredEntryFees() {
        return 0.00;
    }
    
    /**
     * Updates the event
     *
     * @param $id
     * @param EventRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EventFormRequest $request,$slug)
    {
        //get the event
        //$event = Event::findOrFail($id);
        $event = Event::where('slug','=',$slug)->firstOrFail();

        //update the event
        $event->update($request->all());
        //sync the tags
        $this->syncTags($event, $request->input('taglist'));
        //redirect
        return redirect(action('EventsController@admin',$event->slug));
    }

    /**
     * Sync the tags for the event (crucial to update/create)
     *
     * @param Event $event
     * @param array $tags
     */
    private function syncTags(Event $event, array $tags)
    {
        $event->tags()->sync($tags);
    }


    /**
     * @param EventRequest $request
     * @return mixed
     */
    private function createEvent(EventFormRequest $request)
    {
        //event (and set status)
        $data = $request->all();

        //Create a slug from the event name
        $slug = Str::slug($data['name']);
        $numSlugs = Event::where('slug','=',$slug)->count();
        if ($numSlugs == 0) {
            $data['slug'] = $slug;
        } else {
            $data['slug'] = $slug . "-" . $numSlugs;
        }

        //modify the dates with carbon because we're using timedatepicker
        $data['startDate'] = Carbon::createFromFormat('Y-m-d', $data['startDate'])->format('Y-m-d H:i:s');
        $data['endDate'] = Carbon::createFromFormat('Y-m-d', $data['endDate'])->format('Y-m-d H:i:s');
        $data['closingDate'] = Carbon::createFromFormat('Y-m-d', $data['closingDate'])->format('Y-m-d H:i:s');
        //save the event
        $event = Auth::user()->events()->create($data);

        //Upload event image
        $imageName = $event->id . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(
            base_path() . '/public/img/events/',$imageName
        );

        //Insert imageName into the database
        $event->imageFilename = $imageName;
        $event->save();

        //event tags
        $this->syncTags($event, $request->input('taglist'));

        return $event;
    }

    /**
     * Export list of competitors and competitions
     */
    public function export($type, $id) {
        $header = array('Competitor name','ID','Email','Club','Home Country');
        if ($type == 'competitors') {
            $event = Event::findOrFail($id);
            $entries = $event->entries()->get()->sortBy('user_lastname');
            $competitor_ids = $entries->pluck('user_id')->unique();
            $competitions = $event->competitions()->get();
            $header = array();
            foreach ($competitions as $competition) {
                $header[] = $competition->name;
            }
            $sheetdata = array($header);
            foreach ($competitor_ids as $competitor_id) {
                $competitorEntries = $event->entries()->get()->where('user_id',$competitor_id);
                $thisCompetitor = User::findOrFail($competitor_id);
                $name = $thisCompetitor->lastname . ", " . $thisCompetitor->firstname;
                $row = array($name);
                foreach ($competitions as $competition) {
                    $entered_competition_ids = array();
                    foreach ($competitorEntries as $entry) {
                        $entered_competition_ids[] = $entry->competition_id;
                    }
                    if (in_array($competition->id,$entered_competition_ids)) {
                        $row[] = "Entered";
                    } else {
                        $row[] = "";
                    }
                }
                $sheetdata[] = $row;
            }
            Excel::create('competitors', function ($excel) use ($sheetdata) {
                $excel->setTitle('Competitors List');
                $excel->setCreator('Foresight Entries');
                $excel->setCompany('Foresightentries.com');
                $excel->setDescription('Competitors list');
                // Create the sheet
                $excel->sheet('Competitors', function($sheet) use ($sheetdata) {
                    $sheet->fromArray($sheetdata);
                });
            })->export('xlsx');
            return redirect()->back();
        }
        if ($type == 'event') {
            $event = Event::findOrFail($id);
            $competitions = $event->competitions()->get();
            $sheets = array();
            foreach ($competitions as $competition) {
                $details = $competition->details()->get();
                foreach ($details as $detail) {
                    $entries = $detail->entries()->get()->sortBy('user_lastname');
                    $sheetdata = array($header);
                    $competitor_ids = $entries->pluck('user_id')->unique();
                    foreach ($competitor_ids as $competitor_id) {
                        $competitor = User::findOrFail($competitor_id);
                        $row = array(
                            $competitor->firstname . " " . $competitor->lastname,
                            $competitor->id + 1000,
                            $competitor->email,
                            $competitor->club,
                            $competitor->homeCountry,
                        );
                        $sheetdata[] = $row;
                    }
                    $sheets[$competition->name . "-" . $detail->name] = $sheetdata;
                }
            }
            Excel::create($event->name, function ($excel) use ($sheets,$competitions) {
                $excel->setTitle('Competitors');
                $excel->setCreator('Foresight Entries');
                $excel->setCompany('ForesightEntries.com');
                $excel->setDescription('Competitors List');
                foreach ($competitions as $competition) {
                    $details = $competition->details()->get();
                    foreach ($details as $detail) {
                        $sheet = $sheets[$competition->name . '-' . $detail->name];
                        $excel->sheet($competition->name . '-' . $detail->name, function ($thissheet) use ($sheet) {
                            $thissheet->fromArray($sheet);
                        });
                    }
                }
            })->export('xlsx');
            return redirect()->back();
        }
        if ($type == 'competition') {
            $competition = Competition::findOrFail($id);
            $details = $competition->details()->get();
            $sheets = array();
            foreach ($details as $detail) {
                $entries = $detail->entries()->get()->sortBy('user_lastname');
                $sheetdata = array($header);
                $competitor_ids = $entries->pluck('user_id')->unique();
                foreach ($competitor_ids as $competitor_id) {
                    $competitor = User::findOrFail($competitor_id);
                    $row = array(
                        $competitor->firstname . " " . $competitor->lastname,
                        $competitor->id + 1000,
                        $competitor->email,
                        $competitor->club,
                        $competitor->homeCountry,
                    );
                    $sheetdata[] = $row;
                }
                $sheets[$detail->name] = $sheetdata;
            }
            Excel::create($competition->name, function ($excel) use ($sheets,$details) {
                $excel->setTitle('Competitors');
                $excel->setCreator('Foresight Entries');
                $excel->setCompany('ForesightEntries.com');
                $excel->setDescription('Competitors List');
                foreach ($details as $detail) {
                    $sheet = $sheets[$detail->name];
                    $excel->sheet($detail->name, function ($thissheet) use ($sheet) {
                        $thissheet->fromArray($sheet);
                    });
                }
            })->export('xlsx');
            return redirect()->back();
        }
        if ($type == 'detail') {
            $detail = Detail::findOrFail($id);
            $entries = $detail->entries()->get()->sortBy('user_lastname');
            $sheetdata = array($header);
            $competitor_ids = $entries->pluck('user_id')->unique();
            foreach ($competitor_ids as $competitor_id) {
                $competitor = User::findOrFail($competitor_id);
                $row = array(
                        $competitor->firstname . " " . $competitor->lastname,
                        $competitor->id + 1000,
                        $competitor->email,
                        $competitor->club,
                        $competitor->homeCountry,
                    );
                $sheetdata[] = $row;
            }
            Excel::create($detail->competition()->first()->name . "-" . $detail->name, function ($excel) use ($sheetdata) {
                $excel->setTitle('Competitors');
                $excel->setCreator("Foresight Entries");
                $excel->setCompany("ForesightEntries.com");
                $excel->setDescription("Competitors List");
                $excel->sheet('Competitors', function($sheet) use ($sheetdata) {
                    $sheet->fromArray($sheetdata);
                });
            })->export('xlsx');
            return redirect()->back();
        }
    }
}
