@extends('layouts.app')

@section('content')

<section>
    <!-- *** HOMEPAGE CAROUSEL ***
_________________________________________________________ -->

    <div class="home-carousel">

        <div class="dark-mask"></div>

        <div class="container">
            <div class="homepage owl-carousel">
                {{-- duplicate this bit --}}
                <div class="item">
                    <div class="row">
                        <div class="col-sm-6 right">
                            <h1>Online shooting competition entries</h1>
                            <p>Easy for organisers
                                <br />Easy for competitors
                            <br/><span class="strong">Online payment</p>
                        </div>
                        <div class="col-sm-6">
                            <img class="img-responsive" src="{{ URL::asset('img/template-emmons-kneeling.png') }}" alt="">
                        </div>
                    </div>
                {{-- duplicate end --}}
                </div>
            </div>
            <!-- /.project owl-slider -->
        </div> <!-- container -->
    </div> <!-- carousel -->

    <!-- *** HOMEPAGE CAROUSEL END *** -->
</section>

<!-- FEATURED EVENTS -->

<section class="bar background-white no-mb">
    
    <div class="container">
    @if (count($featuredevents) != 0)
        <div class="col-md-12">
            <div class="heading text-center">
                <h2>Featured events</h2>
            </div>

            <!-- *** FEATURED EVENTS (max 4) *** -->

            <div class="row">
                @foreach ($featuredevents as $event)
                    <div class="col-md-3 col-sm-6">
                        <div class="box-image-text blog">
                            <div class="top">
                                <div class="image">
                                    {{! $image = "img/events/".$event->imageFilename}}
                                    <img src="{{ URL::asset($image) }}" alt="" class="img-responsive">
                                    
                                </div>
                                <div class="bg"></div>
                                <div class="text">
                                    <p class="buttons">
                                        <a href="{{ action('EventsController@show', $event->slug) }}" class="btn btn-template-transparent-primary"><i class="fa fa-link"></i> Read more</a>
                                    </p>
                                </div>
                            </div>
                            <div class="content">
                                <h4><a href="{{ action('EventsController@show',$event->slug) }}">{{ $event->name }}</a></h4>

                                <p class="read-more"><a href="{{ action('EventsController@show',$event->slug) }}" class="btn btn-template-main">Enter</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div><!-- end row-->
        </div><!-- end col12 -->
    </div><!-- /.container -->
    @endif
</section>

<!-- /.bar end featured events -->

<!-- choice bar -->
<section class="bar background-image-fixed-2 no-mb color-white text-center">
    <div class="dark-mask"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="icon icon-lg"><i class="fa fa-question-circle"></i>
                </div>
                <h1>What would you like to do?</h1>
                <p class="text-center">
                    <a href="{{ action('EventsController@index') }}" class="btn btn-template-transparent-black btn-lg">Enter an event</a>
                    <a href="{{ action('EventsController@create') }}" class="btn btn-template-transparent-black btn-lg">Organise an event</a>
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
