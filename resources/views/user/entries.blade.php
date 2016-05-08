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
                    @foreach ($events as $event)
                    <h4>{{$event->name}}</h4>
                    <h6><a href="#"><i class="fa fa-times-circle"></i>Withdraw from this event</a></h6>
                    <table class="table table-striped">
                        <thead>
                            <th>Competition</th>
                            <th>Detail</th>
                            <th>Options</th>
                        </thead>
                        <tbody>
                            @foreach ($event->entries()->get()->where('user_id',$user->id) as $entry)
                                <tr>
                                    <td>{{ $entry->competition()->first()->name}}</td>
                                    <td>{{ $entry->detail()->first()->name }}<br>{{$entry->detail()->first()->dateTime->toDateTimeString()}}</td>
                                    <td>
                                        {{-- If more than one detail with space: change detail --}}
                                        <a href="#"><i class="fa fa-times-circle"></i>Change detail</a><br>
                                        {{-- If more than one detail but no space: don't display anything --}}
                                        {{-- Can cancel just this competition but not the event. Should check that it's a multi competition
                                        event, otherwise it's a full cancellation. --}}
                                        <a href="#"><i class="fa fa-times-circle"></i>Withdraw from this competition</a>
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