<?php use App\User; ?>
<div class="tab-pane" id="extras">
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <th>Competitor</th>
        <th>Competitor ID</th>
        @foreach ($event->extras()->get() as $extra)
            <th><div class="center"><span>{{ $extra->name }}</span></div></th>
        @endforeach
        </thead>
        <tbody>
        {{! $competitors = $entries->pluck('user_id')->unique()}}

        @foreach ($competitors as $competitor)
            {{! $competitorExtraOrders = $event->extrasOrdered()->get()->where('user_id',$competitor) }}
            {{! $thisCompetitor = User::findOrFail($competitor) }}
            <tr><td class="bold">{{ $thisCompetitor->lastname }}, {{ $thisCompetitor->firstname }}</td>
                <td class="center">{{$thisCompetitor->id + 1000}}</td>
                @foreach ($event->extras()->get() as $extra)
                    <td class="center">
                        @foreach ($competitorExtraOrders as $competitorOrder)
                            @if ($competitorOrder->id == $extra->id)
                                {{-- extras with multiples need to show how many --}}
                                {{-- extras with info required need to show competitor response --}}
                                <i class="fa fa-check"></i>
                                @if ($extra->multiples == 1)
                                    x {{ $competitorOrder->multiple }}
                                @endif
                                @if ($extra->infoRequired == 1)
                                    {{$competitorOrder->infoRequired}}
                                @endif
                            @endif
                        @endforeach
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>