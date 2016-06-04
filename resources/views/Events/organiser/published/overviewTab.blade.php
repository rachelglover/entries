<div class="tab-pane active" id="overview">
    <div class="row">
        <div class="col-md-12">
            <h4>Promoting your event</h4>
            {{! $eventUrl = 'http://foresightentries.app/events/'.$event->slug }}
            {{-- request()->fullUrl() can be used instead of a hardcoded link --}}
            <p>Share your event with this link (<a href="{{$eventUrl}}" target="_blank">{{$eventUrl}}</a>) or use these social network links:</p>
            @include('components.socialshare', [
                'url' => $eventUrl,
                'description' => $event->name,
                'image' => 'http://foresightentries.app/img/event/'.$event->id.'.jpg',
                ])

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4>Overview</h4>

            <ul>

                <li>{{$differenceClosing}} days until entries close</li>
                <li>{{$differenceStarting}} days until your event starts</li>
                @if ($numCompetitors == 0)
                    <li>No competitors have entered yet</li>
                @elseif ($numCompetitors == 1)
                    <li>{{ $numCompetitors }} competitor has entered</li>
                @else
                    <li>{{ $numCompetitors }} competitors have made {{  $numEntries }} entries to your competitions</li>
                @endif
            </ul>
            {{-- graph in here of entries over time --}}
            <div id='competitions-chart' width="100%">
                {!! $competitionsChart->render('BarChart', 'CompetitionsFilled', 'competitions-chart') !!}
            </div>
        </div>
    </div>
    <hr>

    <div class="row center">
        <a href="{{ action('EventsController@export', ['type' => 'event', 'id' => $event->id]) }}" data-toggle="tooltip" data-placement="right" title="The also download includes competitor email addresses"><i class="fa fa-download fa-3x"></i><br></a>
        Download all the entries for your event so far.
        @if ($event->closingDate->gt(\Carbon\Carbon::now('Europe/London')))
            Entries are still being accepted so this spreadsheet may change.
        @else
            @if ($event->lateEntries == 1)
                The closing date has passed, but you have allowed our system to accept entries after the closing date. This means that this spreadsheet could still change.
            @else
                Your event has closed to entries. This is the final confirmed entries list.
            @endif
        @endif

    </div>
    <hr>

</div>