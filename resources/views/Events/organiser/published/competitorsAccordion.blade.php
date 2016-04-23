<?php use App\User; ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordionDashboard" href="#collapseCompetitors">
                <i class="fa fa-user"></i>Competitors
            </a>
        </h4>
    </div>
    <div id="collapseCompetitors" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="row">
                <div style="padding:10px;"><button type="button" class="btn btn-sm btn-template-main"><a href="#">Export (<i class="fa fa-file-excel-o"></i>Excel)</a></button></div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                        <th>Competitor</th>
                        <th>Competitor ID</th>
                        @foreach ($event->competitions()->get() as $competition)
                            <th><div><span>{{ $competition->name }}</span></div></th>
                        @endforeach
                        @foreach ($event->questions()->get() as $question)
                            <th><div><span>{{ $question->question }}</span></div></th>
                        @endforeach
                        </thead>
                        <tbody>
                        {{! $entries = $event->entries()->get()->sortBy('user_lastname') }}
                        {{! $competitors = $entries->pluck('user_id')->unique()}}

                        @foreach ($competitors as $competitor)
                            {{! $compEntries = $event->entries()->get()->where('user_id',$competitor) }}
                            {{! $thisCompetitor = User::findOrFail($competitor) }}
                            <tr><td class="bold">{{ $thisCompetitor->lastname }}, {{ $thisCompetitor->firstname }}</td>
                                <td class="center">{{$thisCompetitor->id}}</td>
                                @foreach ($event->competitions()->get() as $competition)
                                    @foreach ($compEntries as $entry)
                                        {{! $comps = $entry->competition()->get() }}
                                        @foreach ($comps as $comp)
                                            @if ($comp->id == $competition->id)
                                                <td class="center"><i class="fa fa-check"></i></td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>