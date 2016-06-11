
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
        <div>
        <p>tabs here when ready</p>
        </div>
        <div class="row portfolio">
            @foreach ($events as $event)
                <div class="col-md-3">
                    <div class="box-image-text">
                        <div class="top">
                            <div class="image">
                                {{! $image = "img/portfolio-" . rand(1,4) . ".jpg"}}
                                <img src="{{ URL::asset($image) }}" alt="" class="img-responsive">
                                
                            </div>
                            <div class="bg"></div>
                            <div class="text">
                                <p class="buttons">
                                    <a href="{{ action('EventsController@show', [$event->slug]) }}" class="btn btn-template-transparent-primary"><i class="fa fa-link"></i> Read more</a>
                                </p>
                            </div>
                        </div>
                        <div class="content">
                            <h4><a href="{{ action('EventsController@show', [$event->slug]) }}">{{ $event->name }}</a></h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection