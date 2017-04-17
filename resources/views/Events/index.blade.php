
@extends('layouts/app')

@section('content')

<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h2>All events</h2>
            </div>
        </div>
    </div>
</div>

<div id="content">
    <div class="container">
        @include('flash::message')
        <div class="row portfolio">
            @foreach ($events as $event)
                <div class="col-md-4">
                    <div class="box-image-text">
                        <div class="top">
                            <div class="image">
                                {{! $image = 'img/events/' . $event->imageFilename }}
                                <center><img src="{{ URL::asset($image) }}" alt="" class="img-responsive" style="height:200px;"></center>
                                
                            </div>
                            <div class="bg"></div>
                            <div class="text">
                                <p class="buttons">
                                    <a href="{{ action('EventsController@show', [$event->slug]) }}" class="btn btn-template-transparent-primary"><i class="fa fa-link"></i> Click here</a>
                                </p>
                            </div>
                        </div>
                        <div class="content">
                            <h4><a href="{{ action('EventsController@show', [$event->slug]) }}">{{ $event->name }}</a></h4>
                            <h5><a href="{{ action('EventsController@show', [$event->slug]) }}">
                                    {{$event->tagstring()}}
                                </a></h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection