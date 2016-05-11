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
                    <h4><a href="{{action('EventsController@show',$event->slug)}}" target="_blank">{{$event->name}}</a></h4>
                    <h6><a href="#"><i class="fa fa-times-circle"></i>Withdraw from this event</a></h6>
                    <table class="table table-striped">
                        <thead>
                            <th>Competition</th>
                            <th>Detail</th>
                            <th>Options</th>
                        </thead>
                        <tbody>
                            @foreach ($event->entries()->get()->where('user_id',$user->id) as $entry)
                                {{-- Modal for this entry (needs to be here rather than an include otherwise
                                it only shows the first competition --}}
                                <div class="modal fade" id="changeDetailModal-{{$entry->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="exampleModalLabel">Change your detail for {{$entry->competition()->first()->name}}</h4>
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

                                <tr>
                                    <td>{{ $entry->competition()->first()->name}}</td>
                                    <td>{{ $entry->detail()->first()->name }}<br>{{$entry->detail()->first()->dateTime->toDayDateTimeString()}}</td>
                                    <td>
                                        {{-- If more than one detail with space: change detail --}}
                                        @if ($entry->competition()->first()->details()->count() > 1 && $entry->event())
                                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#changeDetailModal-{{$entry->id}}"><i class="fa fa-edit"></i>Change Detail</button>
                                        @endif
                                        {{-- Can cancel just this competition but not the event. Should check that it's a multi competition
                                        event, otherwise it's a full cancellation. --}}
                                        <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i>Cancel your entry</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endforeach
            </div>
        </div>
    </div>

@endsection