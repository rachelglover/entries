<?php use App\User; ?>
<div class="tab-pane" id="questions">
    <a href="{{ action('EventsController@export', ['type' => 'competitor_answers', 'id' => $event->id]) }}" data-toggle="tooltip" data-placement="right" title="The also download includes competitor email addresses"><i class="fa fa-download"></i><br>Download answers to Excel</a>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <th>Competitor</th>
        <th>Competitor ID</th>
        @foreach ($event->questions()->get() as $question)
            <th><div class="center"><span>{{ $question->question }}</span></div></th>
        @endforeach
        </thead>
        <tbody>
        {{! $entries = $event->entries()->get()->sortBy('name') }}
        {{! $competitors = $entries->pluck('user_id')->unique()}}

        @foreach ($competitors as $competitor)
            {{! $competitorAnswers = $event->answers()->get()->where('competitor_id',$competitor) }}
            {{! $thisCompetitor = User::findOrFail($competitor) }}
            <tr><td class="bold">{{ $thisCompetitor->lastname }}, {{ $thisCompetitor->firstname }}</td>
                <td class="center">{{$thisCompetitor->id + 1000}}</td>
                @foreach ($event->questions()->get() as $question)
                    <td class="center">
                        @foreach ($competitorAnswers as $competitorAnswer)
                            @if ($competitorAnswer->question_id == $question->id)
                                {{$competitorAnswer->answer}}
                            @endif
                        @endforeach
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>