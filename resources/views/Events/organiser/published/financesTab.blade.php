<?php use App\User; ?>
<div class="tab-pane" id="finances">
    <p>We will transfer the entry fees to your
        @if ($event->payment_option == 'paypal')
            PayPal account (<strong>{{$event->payment_paypal_address}}</strong>)
        @else
            bank account (<strong>{{$event->payment_account}}  {{$event->payment_sortcode}}</strong>)
        @endif
        24 hours after the date you chose to close the entries ({{$event->closingDate->toFormattedDateString()}}).</p>
    @if ($event->lateEntries == 1)
        <p>As you are accepting late entries, we will transfer the fees for any late entries 24 hours after the start of your event ({{$event->startDate->toFormattedDateString()}}).</p>
    @endif
    <p>Should you need your entry fees earlier than this date please <a href="{{action('PagesController@contact')}}">contact us</a> to arrange an alternative payment schedule.</p>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <th width="10%">Transaction ID</th>
            <th width="25%">From</th>
            <th width="25%">To</th>
            <th width="15%">Net amount</th>
            <th width="25%">Notes</th>
        </thead>
        <tbody>
            @foreach ($event->transactions()->get()->sortByDesc('id') as $transaction)
                {{! $transactionUser = User::find($transaction->user_id)}}
                {{! $foresight_fee = env('FORESIGHT_FEE')}}
                {{! $transactionAmount = $transaction->total - $transaction->transaction_fee - $foresight_fee  }}

                @if ($transaction->transaction_type == 'competitor_payment')
                    <td class="alert-success">{{$transaction->id}}</td>
                    <td class="alert-success">{{$transactionUser->firstname}} {{$transactionUser->lastname}}</td>
                    <td class="alert-success">Foresight Entries</td>
                    <td class="alert-success">£{{sprintf("%4.2f",$transactionAmount)}}</td>
                    <td class="alert-success">Competitor entry fees</td>
                @elseif($transaction->transaction_type == 'competitor_refund')
                    <td class="alert-danger">{{$transaction->id}}</td>
                    <td class="alert-danger">Foresight Entries</td>
                    <td class="alert-danger">{{$transactionUser->firstname}} {{$transactionUser->lastname}}</td>
                    <td class="alert-danger">-£{{sprintf("%4.2f",$transactionAmount)}}</td>
                    <td class="alert-danger">Competitor entry fee refund</td>
                @elseif($transaction->transaction_type == 'organiser_transfer')
                    <td class="alert-info">{{$transaction->id}}</td>
                    <td class="alert-info">Foresight Entries</td>
                    <td class="alert-info">{{$user->firstname}} {{$user->lastname}}</td>
                    <td class="alert-info">-£{{sprintf("%4.2f",$transactionAmount)}}</td>
                    <td class="alert-info">Transfer to event organiser</td>
                @endif
            @endforeach
        </tbody>
    </table>
</div>