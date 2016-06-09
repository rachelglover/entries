@extends('layouts/app')

@section('content')

<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Your entries</h1>
            </div>
        </div>
    </div>
</div>
<div id="content">
    <div class="container">
        @include('flash::message')
            <div class="col-lg-12">
                <p>All your current entries are listed below. If a competition has multiple details, you can change your detail at any time before the closing date, providing there is space in the detail.</p>
                    @foreach ($events as $event)
                    {{-- Modal for cancelling the entire entry --}}
                    <div class="modal fade" id="cancelEntireEntryModal-{{$event->id}}" tabindex="-1" role="dialog" aria-labelledby="cancelEntireEntryModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="changeDetailModalLabel">Cancel all your entries for {{$event->name}}</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{ action('EntryController@cancelEntireEntry', $event->id) }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="bold">Are you sure you want to cancel your entire entry to this event?</div>
                                        <div>Once you have cancelled we will refund your entry fees (minus registration fees) and any additional extras you may have ordered and confirm by email. If you change your mind and wish to re-enter, you will have to submit a new entry from the event page.</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save"></i> Cancel your entry to this event</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Now display the table --}}
                    <h4><a href="{{action('EventsController@show',$event->slug)}}" target="_blank">{{$event->name}}</a>
                        {{--Only show the link to cancel entire entry if all entries statuses' are 'paid'. This stops the button
                         being shown if the competitor has already cancelled (pre-refund/post-refund but before event archived)--}}
                    @if ($user->showWithdrawFromEventButton($event->id))
                            <small><a href="#" class="pull-right" data-toggle="modal" data-target="#cancelEntireEntryModal-{{$event->id}}"><i class="fa fa-times-circle"></i>Withdraw from this event</a></small>
                    @endif
                    </h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="35%">Competition</th>
                            <th width="35%">Detail</th>
                            <th width="30%">Options</th>
                        </thead>
                        <tbody>
                            @foreach ($event->entries()->get()->where('user_id',$user->id) as $entry)
                                {{-- Modal for this entry (needs to be here rather than an include otherwise
                                it only shows the first competition --}}
                                <div class="modal fade" id="changeDetailModal-{{$entry->id}}" tabindex="-1" role="dialog" aria-labelledby="changeDetailModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="changeDetailModalLabel">Change your detail for {{$entry->competition()->first()->name}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ action('EntryController@changeDetail', $entry->id) }}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                Please select your new detail (only details with space are shown).<br>
                                                    <select name="newDetail" class="form-control">
                                                        <option>Select detail...</option>
                                                    @foreach ($entry->competition()->first()->details()->get() as $detail)
                                                        @if ($entry->detail_id != $detail->id)

                                                            <option value="{{$detail->id}}">{{$detail->name}} - {{$detail->dateTime->toDayDateTimeString()}} ({{$detail->placesLeft()}} places left)</option>
                                                        @endif
                                                    @endforeach
                                                    </select>
                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal for this entry (needs to be here rather than an include otherwise it only works for the first
                                competition. This is the cancellation modal --}}
                                <div class="modal fade" id="cancelCompetitionModal-{{$entry->id}}" tabindex="-1" role="dialog" aria-labelledby="cancelCompetitionModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="cancelCompetitionModalLabel">Cancel your entry for {{$entry->competition()->first()->name}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ action('EntryController@cancelCompetition', $entry->id) }}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div>
                                                        Once you have cancelled your entry to this competition, we will refund the entry fee within 48 hours. You will only be refunded the entry fee (£{{$entry->competition()->first()->fee}}) minus any proportional discounts received. You will receive an email confirmation of your refund once complete.
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save"></i> Cancel this competition entry</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <tr>
                                    <td>{{ $entry->competition()->first()->name}}</td>
                                    <td>{{ $entry->detail()->first()->name }}<br>{{$entry->detail()->first()->dateTime->toDayDateTimeString()}}</td>
                                    <td>
                                        {{-- Can cancel just this competition but not the event. Should check that it's a multi competition
                                        event, otherwise it's a full cancellation. --}}
                                        @if ($entry->paymentStatus == 'pending_cancellation')
                                            <div class="bold">Cancelled, pending refund</div>
                                        @elseif ($entry->paymentStatus == 'cancelled')
                                            <div class="alert-danger">CANCELLED AND REFUNDED</div>
                                        @elseif ($entry->paymentStatus == 'paid')
                                            {{-- If more than one detail with space: change detail --}}
                                            @if ($entry->competition()->first()->details()->count() > 1 && $entry->event())
                                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#changeDetailModal-{{$entry->id}}"><i class="fa fa-edit"></i>Change Detail</button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#cancelCompetitionModal-{{$entry->id}}"><i class="fa fa-times-circle"></i>Cancel this entry</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <hr>
                    @endforeach
            </div>
        </div>
    </div>

@endsection