
    <div class="form-group">
        {!! Form::label('name', 'Event name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <table>
        <tr>
            <td width="33%">
                <div class="form-group" style="padding:0px 10px 0px 0px;">
                    {!! Form::label('startDate', 'Start date:') !!}
                    {!! Form::text('startDate', null, ['class' => 'form-control', 'id' => 'startDate']) !!}
                </div>
            </td>
            <td width="33%">
                <div class="form-group" style="padding:0px 0px 0px 10px;">
                    {!! Form::label('endDate', 'End date:') !!}
                    {!! Form::text('endDate', null, ['class' => 'form-control', 'id' => 'endDate']) !!}
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="form-group">
                    {!! Form::label('closingDate', 'Closing date for entries:') !!}
                    {!! Form::text('closingDate', null, ['class' => 'form-control', 'id' => 'closingDate']) !!}
                </div>
            </td>
        </tr>
    </table>

    <div class="form-group">
        {!! Form::label('description', 'Event description:') !!}
        <p class="small">Please provide general details about your event (a couple of paragraphs is ideal). This will be shown 'as is' on the page we create for your event. You'll add a list of competitions and their details on the next page.</p>
        {!! Form::textarea('description', null, ['class' => 'form-control','id' => 'description']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('image','Event image') !!}
        <p class="small">This is the main image that will be used for your event on the website. If you don't upload an image, a stock image will be used instead.</p>
        @if ($event != null)
            <p class="small">This is your current image:</p>
            {{! $image =  url('/') . '/img/events/' . $event->imageFilename }}
            <img src="{{ $image }}" style="width: 150px" />

        @endif
        {!! Form::file('image', null) !!}


    </div>

    <div class="form-group">
        {!! Form::label('website', 'Website (if available):') !!}
        {!! Form::text('website', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('postcode', 'Range Postcode:') !!}
        <p class="small">We'll use this to show the location of your range on a map. If you'd rather we didn't show a location, just leave it blank.</p>
        {!! Form::text('postcode', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('payment_option', 'Method of payment:') !!}
        <p class="small">We send the fees to you 24 hours after the closing date for entries - this is to ensure we can refund cancellations automatically. We transfer the entry fees to a PayPal account or to your bank account. We can also send entry fees to you before the closing date by arrangement if you <a href="{{action('PagesController@contact')}}">contact us</a>.</p>
        {!! Form::select('payment_option', $paymentOptions, null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group" id="payment_paypal_address_div">
        {!! Form::label('payment_paypal_address', 'Paypal email address:') !!}
        <p class="small">Please type carefully. You can sign up for a PayPal account here: <a href="http://www.paypal.com" target="_blank">www.paypal.com</a>.</p>
        {!! Form::text('payment_paypal_address', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group" id="payment_account_div">
        {!! Form::label('payment_account', 'Bank account number') !!}
        {!! Form::text('payment_account', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group" id="payment_sortcode_div">
        {!! Form::label('payment_sortcode', 'Bank sort code') !!}
        {!! Form::text('payment_sortcode', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('currency', 'Event currency:') !!}
        {!! Form::select('currency', $currencies, null, ['class' => 'form-control']) !!}
    </div>

    <?php if (empty($lateEntriesCurrent)) { $lateEntriesCurrent = false; } ?>
    <div class="form-group">
        {!! Form::label('lateEntries', 'Will you accept entries after the closing date?') !!}
        {!! Form::checkbox('lateEntries', 1, $lateEntriesCurrent, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group" id="lateEntriesCost">
        {!! Form::label('lateEntriesFee', 'Late entries fee (£):') !!}
       {!! Form::text('lateEntriesFee', "0.00", ['class' => 'form-control']) !!}
    </div>

    <?php if (empty($registrationCurrent)) { $registrationCurrent = false; } ?>
    <div class="form-group">
        {!! Form::label('registration', 'Will you be charging an overall registration fee in addition to competition entry fees?') !!}
        {!! Form::checkbox('registration', 1, $registrationCurrent, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group" id="registrationCost">
        {!! Form::label('registrationFee', "Registration fee (£):") !!}
        {!! Form::text('registrationFee', "0.00", ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('taglist', 'Tags:') !!}
        <p>You must choose at least one tag</p>
        {!! Form::select('taglist[]', $tags, null, ['id' => 'taglist', 'multiple' => 'multiple','class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit($submitButtonText, ['class' => 'btn']) !!}
    </div>