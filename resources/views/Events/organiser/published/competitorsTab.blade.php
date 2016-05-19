<?php use App\User; ?>
<div class="tab-pane" id="competitors">
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <th>Competitor</th>
        <th>Competitor ID</th>
        @foreach ($event->competitions()->get() as $competition)
            <th><div><span>{{ $competition->name }}</span></div></th>
        @endforeach
        </thead>
        <tbody>
        {{! $entries = $event->entries()->get()->sortBy('user_lastname') }}
        {{! $competitors = $entries->pluck('user_id')->unique()}}

        @foreach ($competitors as $competitor)
            {{! $compEntries = $event->entries()->get()->where('user_id',$competitor) }}
            {{! $thisCompetitor = User::findOrFail($competitor) }}
            <tr><td class="bold">{{ $thisCompetitor->lastname }}, {{ $thisCompetitor->firstname }}</td>
                <td class="center">{{$thisCompetitor->id + 1000}}</td>
                @foreach ($event->competitions()->get() as $competition)
                    <td class="center">
                        @foreach ($compEntries as $entry)
                            @if ($entry->competition_id == $competition->id)
                                <i class="fa fa-check"></i>
                            @endif
                        @endforeach
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>