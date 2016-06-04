<div class="tab-pane" id="competitions">
    {{-- Vertical tabs within this (horizontal) tab-content--}}
    <div class="row">
        <div class="col-xs-3" style="padding:0px">
            {{! $active = True }}
            <ul id="competitionsTab" class="nav nav-tabs tabs-left">
                @foreach ($event->competitions()->get() as $competition)
                    <li class="tab-competition"><a href="#competition-{{$competition->id}}" data-toggle="tab"><i class="fa fa-trophy"></i>{{$competition->name}}</a></li>
                    @foreach ($competition->details()->get() as $detail)
                        <li class="tab-detail"><a href="#detail-{{$detail->id}}" data-toggle="tab"><i class="fa fa-caret-right"></i>{{$detail->name}}</a></li>
                    @endforeach
                @endforeach
            </ul>
        </div>
        <div class="col-xs-9" style="padding:0px">
            <div class="tab-content">
                @foreach ($event->competitions()->get() as $competition)
                    <div class="tab-pane" id="competition-{{$competition->id}}">
                        <h4>{{$competition->name}}</h4>
                        <p>{{$competition->description}}</p>
                        Click on the detail names to the left to see the current entries.<br>
                        <a href="{{ action('EventsController@export', ['type' => 'competition', 'id' => $competition->id]) }}" data-toggle="tooltip" data-placement="right" title="The also download includes competitor email addresses"><i class="fa fa-download fa-2x"></i><br>Download the entries for all details in this competition (Excel)</a>

                    </div>
                    @foreach ($competition->details()->get() as $detail)
                        <div class="tab-pane" id="detail-{{$detail->id}}">
                            <h4>{{$competition->name }} > {{$detail->name}}</h4>
                            @if ($detail->entries()->count() > 0)
                                {{$detail->description}}
                                <a href="{{ action('EventsController@export', ['type' => 'detail', 'id' => $detail->id]) }}" data-toggle="tooltip" data-placement="right" title="The also download includes competitor email addresses"><i class="fa fa-download fa-2x"></i><br>Download the entries for this detail (Excel)</a>
                            <table class="table table-striped table-condensed">
                                <thead>
                                    <th>Competitor</th>
                                    <th>Competitor ID</th>
                                    <th>Club</th>
                                    <th>Home Country</th>
                                </thead>
                                <tbody>
                                    @foreach ($detail->entries()->get()->sortBy('user_lastname') as $entry)
                                        {{! $thisUser = $entry->user()->first() }}
                                        <tr>
                                            <td><span class="text-uppercase">{{$thisUser->lastname}}</span>, {{$thisUser->firstname}}</td>
                                            <td>{{$thisUser->id + 1000}}</td>
                                            <td>{{$thisUser->club}}</td>
                                            <td>{{$thisUser->homeCountry}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else {{--No entries yet --}}
                                <div>No entries for this detail yet.</div>
                            @endif
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>