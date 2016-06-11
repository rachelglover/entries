<div class="tab-pane" id="futuretransfers">
    @foreach ($events as $event)
        <h4>{{$event->name}}</h4>
        <table class="table table-condensed">
        @foreach ($event->transactions()->get() as $transaction)
            <tr><td>{{$transaction}}</td></tr>
        @endforeach
        </table>
    @endforeach
</div>