<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordionDashboard" href="#collapseOverview">
                <i class="fa fa-bar-chart"></i>Overview
            </a>
        </h4>
    </div>
    <div id="collapseOverview" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    {{-- graph in here of entries over time --}}
                    <div id='competitions-chart'>
                            {!! $competitionsChart->render('BarChart', 'CompetitionsFilled', 'competitions-chart') !!}
                    </div>
                </div>
            </div>
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
                </div>
            </div>
        </div>
    </div>
</div>