@extends('layouts.app')

@section('content')
@include('flash::message')
<!-- variables: $event, $entries, $extras, $user -->
<div class="row">
    <div class="col-lg-12">
    <!-- display the overview -->
        <div class="panel panel-primary">
            <div class="panel-heading">Your entry for {{$event->name}}</div>
            <div class="panel-body">
            	<h4>Competitions</h4>
                <table class="table table-striped table-bordered">
                	<thead>
                		<th>Competition</th>
                		<th>Detail date/time</th>
                		<th width="15%">Entry fee</th>
                	</thead>
                	@foreach ($entries as $entry)
                		<tr>
                			<td>{{ $entry['competition']->name }}</td>
                			<td>{{ $entry['detail']->dateTime->toDayDateTimeString() }}</td>
                			<td>£{{ sprintf("%4.2f",$entry['competition']->fee) }}</td>
                		</tr>
                	@endforeach
                    <tr>
                    	<td colspan="2" class="text-right">Competitions sub-total</td>
                    	<td>£{{ $compSubTotal }}</td>
                	</tr>
                </table>

                <h4>Optional Extras</h4>
                <table class="table table-striped table-bordered">
                	@foreach ($extras as $extra)
                		<tr>
                			<td>{{ $extra['extra']->name }}</td>
                			<td>{{ $extra['multiple'] }}</td>
                			<td width="15%">£{{ sprintf("%4.2f",$extra['thisExtraCost']) }}</td>
                		</tr>
                	@endforeach
                    <tr>
                    	<td colspan="2" class="text-right">Extras sub-total</td>
                    	<td>£{{ $extraSubTotal }}</td>
                	</tr>
                </table>

                <h4>Totals</h4>
                <table class="table table-striped table-bordered">

                    <tr>
                    	<td>Competitions sub-total</td>
                    	<td width="15%">£{{ $compSubTotal }}</td>
                	</tr>
                	<tr>
                		<td>Extras sub-total</td>
                		<td>£{{ $extraSubTotal}}</td>
            		</tr>
            		@if ($lateEntriesFee > 0)
	                	<tr>
	                		<td>Late Entry fee</td>
	                		<td>£{{ $lateEntriesFee }}</td>
	            		</tr>
            		@endif
            		<tr>
            			<td>Event registration fee
            			@if ($event->registration == 1)
            				<br><small>This includes a fee of £{{ $event->registrationFee }} requested by the event organiser</small>
            			@endif
            			</td>
            			<td>£{{ $registrationFees }}</td>
            		<tr>
            			<td>Paypal/card processing fees</td>
            			<td>£{{ $paypalFees }}</td>
        			</tr>
        			<tr>
        				<td class="bold">Total</td>
        				<td class="bold">£{{ $grandTotal }}</td>
    				</tr>
                </table>
            </div>
        </div>

        <!-- Form with all the event data -->
        <form method="post" action="{{ action('EntryController@store') }}">
        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<input type="hidden" name="event_id" value="{{ $event->id }}">
        	<input type="hidden" name="user-phone" value="{{ $entrydata['user-phone'] }}">
        	<input type="hidden" name="user-club" value="{{ $entrydata['user-club'] }}">
        	<input type="hidden" name="user-country" value="{{ $entrydata['user-country'] }}">
        	<!-- Loop through the entered competitions -->
        	@foreach ($entries as $entry)
        		<input type="hidden" name="competitions[{{ $entry['competition']->id }}]" value="{{ $entry['detail']->id }}">
        	@endforeach
        	<!-- Loop through the answers to questions -->
        	@foreach ($entrydata['questions'] as $question_id => $answer)
        		<input type="hidden" name="questions[{{ $question_id }}]" value="{{ $answer }}">
        	@endforeach
        	<!-- Loop through the extras -->
        	@foreach ($extras as $extra_id => $extraInfo)
        		<input type="hidden" name="extras[{{ $extra_id }}]" value="{{ $extraInfo->thisExtraCost }} ">
        		@if ($extraInfo->multiple)
        			<input type="hidden" name="extras[{{ $extra_id }}][multiple]" value="{{ $extraInfo->multiple }}">
        		@endif
        		@if ($extraInfo->infoRequired)
        			<input type="hidden" name="extras[{{ $extra_id }}][infoRequired]" value="{{ $extraInfo->infoRequired }}">
    			@endif
        	@endforeach
        	<!-- pass over the pricing info -->
        	<input type="hidden" name="total" value="{{ $grandTotal }}">

        <!-- T&Cs and enter button -->
        <div class="text-right">
        	<table>
        		<tr>
        			<td width="40%"></td>
        			<td>
        				<small>We'd like to send you an email occasionally with events you might be interested in. If this is OK please tick the box.</small>
    				</td>
    				<td width="5%"><input type="checkbox" value="1" name="contactable"></td>
    			</tr>
        		<tr>
        			<td></td>
        			<td>
        				I accept the <a href=" {{ action('PagesController@terms') }} " target="_blank">Terms and Conditions  </a>
    				</td>
    				<td><input type="checkbox" value="1" id="terms"></td>
    			</tr>
    			<tr>
    			<td colspan="3">
    				<button id="enterpay" type="submit" value="Enter" class="btn btn-success pull-right" disabled>Enter and pay</button>
    			</td>
    			</tr>
        	</table>
        </div>
        </form>
    </div>
</div>

@endsection