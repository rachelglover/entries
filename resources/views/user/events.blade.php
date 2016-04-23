@extends('layouts/app')

@section('content')
<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>{{ $user->firstname }}'s events</h1>
            </div>
        </div>
    </div>
</div>

<!-- Start of the main content -->  
<div id="content">
    <div class="container">
        <div class="col-lg-12">
            <table class="table table-striped">
                <thead>
                    <th>Events under construction</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($user->events()->unpublished()->get() as $event)
                            <!--Delete event modal code -->
                    <div class="modal fade" id="deleteEventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="exampleModalLabel">Delete your event</h4>
                                </div>
                                <div class="modal-body">
                                    <h4>Are you sure you want to delete this event?</h4>
                                    <p>This is permanent.</p>
                                </div>
                                {!! Form::open(array('action' => array('EventsController@destroy', $event->slug), 'method' => 'DELETE')) !!}
                                <div class="modal-footer">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="submit" class="btn btn-danger"><i class="fa fa-times"></i> Delete</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                        <tr>
                            <td>
                                <h4><a href="{{ action('EventsController@admin', $event->slug) }}">{{ $event->name }}</a></h4>
                            </td>
                            <td>
                                <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteEventModal"><i class="fa fa-times"></i> Delete Event</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table table-striped">
                <thead>
                    <th>Events accepting entries</th>
                </thead>
                <tbody>
                    @foreach ($user->events()->published()->get() as $event)
                        <tr>
                            <td>
                                <h4><a href="{{ action('EventsController@admin', $event->slug) }}">{{ $event->name }}</a></h4>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table table-striped">
                <thead>
                <th>Finished (archived) events</th>
                </thead>
                <tbody>
                @foreach ($user->events()->archived()->get() as $event)
                    <tr>
                        <td>
                            <h4><a href="{{ action('EventsController@admin', $event->slug) }}">{{ $event->name }}</a></h4>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection