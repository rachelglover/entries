<div class="tab-pane" id="futuretransfers">
    <div>This doesn't include refunds! Not sure how to account for partial refunds of competitions. will need to be included in this table somehow.</div>
    @foreach ($events as $event)
        <h4>{{$event->name}}</h4>
        <table class="table table-condensed">
            <tr><th>Transaction</th>
                <th>Event</th>
                <th>User</th>
                <th>Type</th>
                <th>Paypal Sale ID</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Total</th>
                <th>Paypal Fee</th>
                <th>Transfer amount</th>
            </tr>
            {{! $transfer_subtotal = 0}}
        @foreach ($event->transactions()->get() as $transaction)
            {{! $transfer_amount = $transaction->total - $transaction->transaction_fee - env('FORESIGHT_FEE')}}
            {{! $transfer_subtotal += $transfer_amount}}
            <tr>
                <td>{{$transaction->id}}</td>
                <td>{{$transaction->event_id}}</td>
                <td>{{$transaction->user_id}}</td>
                <td>{{$transaction->transaction_type}}</td>
                <td>{{$transaction->paypal_sale_id}}</td>
                <td>{{$transaction->payment_method}}</td>
                <td>{{$transaction->status}}</td>
                <td>{{$transaction->total}}</td>
                <td>{{$transaction->transaction_fee}}</td>
                <td>{{$transfer_amount}}</td>
            </tr>
        @endforeach
            <tr><td colspan="10" align="right">Awaiting transfer: {{$transfer_subtotal}}</td></tr>
        </table>

    @endforeach
</div>