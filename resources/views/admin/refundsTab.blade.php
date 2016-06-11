<div class="tab-pane active" id="refunds">
    <p>Remember to check whether this is a whole-event cancellation. If it is, check whether there are optional extras to refund and any discounts were applied. Look at the transactions!</p>
    <p>This section will not send automatic emails. You will need to send an email to the competitor detailing the amount being refunded through paypal along with a reminder that fees are non-refundable as per T&Cs.</p>
    <table class="table table-condensed table-striped">
            <thead>
                <th>Entry ID</th>
                <th>Competitor name<br/>(ID)</th>
                <th>Event<br/>(ID)</th>
                <th>Competition<br/>(ID)</th>
                <th>Detail<br/>(ID)</th>
                <th>Refundable amount (cost - fees)</th>
                <th>Options</th>
            </thead>
        @foreach ($refundsPending as $entry)
            <form method="post" action="{{ action('EntryController@entryRefunded',$entry->id) }}">
                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
                <tr>
                    <td>{{$entry->id}}</td>
                    <td>{{$entry->user()->first()->firstname}} {{$entry->user()->first()->lastname}}<br/>({{$entry->user()->first()->id}})</td>
                    <td>{{$entry->event()->first()->name}}<br/>({{$entry->event()->first()->id}})</td>
                    <td>{{$entry->competition()->first()->name}}<br/>({{$entry->competition()->first()->id}})</td>
                    <td>{{$entry->detail()->first()->name}}<br />({{$entry->detail()->first()->id}})</td>
                    <td>{{$entry->paymentStatus}}<br/>Refundable amount here ($entry->discountsApplied gives discount IDs applied)</td>
                    <td><button type="submit" name="submit" value="{{$entry->id}}" class="btn btn-success">Mark as refunded</button></td>
                </tr>
            </form>
        @endforeach
    </table>
</div>