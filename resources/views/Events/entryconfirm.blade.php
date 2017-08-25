@extends('layouts.app')

@section('content')
<!-- variables: $event, $entries, $extras, $user -->
<div id="heading-breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-md-7">
				<h1>{{ $event->name }}</h1>
			</div>
		</div>
	</div>
</div>
<div id="content">
	<div class="container">
		@include('flash::message')
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

						@if (count($extras) > 0)
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
						@endif

						<h4>Totals</h4>
						<table class="table table-striped table-bordered">

							<tr>
								<td>Competitions
									@if (count($extras) > 0)
										and extras
									@endif
									sub-total</td>
								<td width="15%">£{{ $compExtraSubtotal }}</td>
							</tr>
							{{-- Discounts. FixedDiscounts and percentageDiscounts only present when being applied.--}}
							@foreach ($fixedDiscounts as $fd)
								<tr>
									<td>{{$fd->for}} discount</td>
									<td>-£{{sprintf("%4.2f",$fd->value)}}</td>
								</tr>
							@endforeach

							@foreach ($percentageDiscounts as $pd)
								<tr>
									<td>{{$pd->for}} discount ({{$pd->value}}%)</td>
									<td>-£{{sprintf("%4.2f",$percentageDiscountValues[$pd->id])}}</td>
								</tr>
							@endforeach
							<tr>

							</tr>
							@if ($lateEntryFee > 0)
								<tr>
									<td>Late Entry fee</td>
									<td>£{{ $lateEntryFee }}</td>
								</tr>
							@endif

							<tr>
								<td>Registration fee
									<br><small>
										This consists of a ForesightEntries fee of £{{$foresightFee}}
									@if ($event->registration == 1)
										 and a registration fee being charged by the Event organiser of £{{$discountedRegistrationFee}}
									@endif
										. The ForesightEntries fee is 10% of the sub-total minus any discounts applied.
									</small>
								</td>
								<td>£{{ $feesTotal }}</td>
							</tr>
							<tr>
								<td class="bold">Total</td>
								<td class="bold">£{{ $grandTotal }}</td>
							</tr>
						</table>
					</div>
					<div class="panel-footer">
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
							@if (key_exists('questions',$entrydata))
								@foreach ($entrydata['questions'] as $question_id => $answer)
									<input type="hidden" name="questions[{{ $question_id }}]" value="{{ $answer }}">
								@endforeach
							@endif
							<!-- Loop through the extras -->
							@foreach ($extras as $extra)
								<input type="hidden" name="extras[{{$extra['id']}}]" value="{{$extra['thisExtraCost']}}">
									@if ($extra['multiple'])
										<input type="hidden" name="extras[{{$extra['id']}}][multiple]" value="{{$extra['multiple']}}">
									@endif
									@if ($extra['infoRequired'])
										<input type="hidden" name="extras[{{$extra['id']}}][infoRequired]" value="{{ $extra['infoRequired'] }}">
									@endif
							@endforeach
							<input type="hidden" name="discounts_applied" value="{{$discounts_applied}}">

							<!-- pass over the pricing info -->
							<input type="hidden" name="total" value="{{ $grandTotal }}">

							<!-- T&Cs and enter button -->
							<div class="text-right">
								I accept the <a href=" {{ action('PagesController@terms') }} " target="_blank">Terms and Conditions  </a><input type="checkbox" value="1" id="terms"><br/>
								<button id="enterpay" type="submit" value="Enter" class="btn btn-success" disabled>Enter and pay</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection