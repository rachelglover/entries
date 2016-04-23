<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordionDashboard" href="#collapseCompetitions">
                <i class="fa fa-trophy"></i>Competitions
            </a>
        </h4>
    </div>
    <div id="collapseCompetitions" class="panel-collapse collapse">
        <div class="panel-body">
            <div><button type="button" class="btn btn-sm btn-template-main"><a href="#">Export competition (<i class="fa fa-file-excel-o"></i>Excel)</a></button></div>

            @foreach ($event->competitions()->get() as $competition)
                <div class="panel-group accordion" id="competition{{$competition->id}}">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#competition{{$competition->id}}" href="#collapse{{$competition->id}}">
                                    <i class="fa fa-trophy"></i>{{$competition->name}}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse{{$competition->id}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="tabs">
                                    {{! $active = True }}
                                    <ul class="nav nav-tabs">
                                        @foreach ($competition->details()->get() as $detail)
                                            @if ($active == True)
                                                <li class="active">
                                                {{ $active = False }}
                                            @else
                                                <li class="">
                                                    @endif
                                                    <a href="#detail{{$detail->id}}" data-toggle="tab">{{$detail->name}}</a></li>
                                                @endforeach
                                    </ul>
                                    {{! $activeContent = True }}
                                    <div class="tab-content">
                                        @foreach ($competition->details()->get() as $detail)
                                            @if ($activeContent == True)
                                                <div class="tab-pane active" id="detail{{$detail->id}}">
                                                    {{ $activeContent = False }}
                                                    @else
                                                        <div class="tab-pane" id="detail{{$detail->id}}">
                                                            @endif
                                                            @if ($detail->entries()->count() > 0)
                                                                <div><button type="button" class="btn btn-sm btn-template-main"><a href="#">Export this detail (<i class="fa fa-file-excel-o"></i>Excel)</a></button></div>
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                    <th>Competitor</th>
                                                                    <th>Competitor ID</th>
                                                                    <th>Club</th>
                                                                    <th>Home Country</th>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach ($detail->entries()->get() as $entry)
                                                                        {{! $thisUser = $entry->user()->first() }}
                                                                        {{! $username = "asdf" }}
                                                                        <tr>
                                                                            <td><a href="#" data-toggle="modal" data-target="#viewEntryCompetitorInfoModal" data-username="{{$username}}">{{ $thisUser->firstname }} {{ $thisUser->lastname }}</a></td>
                                                                            <td>{{ $thisUser->id }}</td>
                                                                            <td>{{ $thisUser->club }}</td>
                                                                            <td>{{ $thisUser->homeCountry }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            @else
                                                                <p>No entries yet</p>
                                                            @endif
                                                        </div>
                                                        @endforeach
                                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        </div>
    </div>

