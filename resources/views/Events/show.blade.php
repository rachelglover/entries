@extends('layouts.app')

@section('content')
<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>{{ $event->name }}</h1>
            </div>
        </div>
    </div>
</div>

@if ($preview == 'true')
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8 bold alert-success center">You are viewing this page as your competitors will see it.</div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </div>
    <p></p>

@endif

<div id="content">
    <div class="container">
        <div class="row">
            <section>
                <div class="col-sm-8">
                    <div class="project owl-carousel">
                        <div class="item">
                            {{! $image = 'img/events/' . $event->imageFilename }}
                            <img src="{{ URL::asset($image) }}" alt="" class="img-responsive">
                        </div>
                        <div class="item" id="competitions-chart">
                            {!! $chart->render('BarChart', 'CompetitionsFilled', 'competitions-chart') !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="project-more">
                        <h4>Organiser</h4>
                        <p>{{ $event->getOrganiserName() }}</p>
                        @if ($event->website != "http://www")
                            <h4>Website</h4>
                            <p><a href="{{$event->website}}" target="_blank">{{$event->website}}</a></p>
                        @endif
                        <h4>Range Location</h4>
                        <p><a href="{{$event->getGoogleMapLink()}}" target="_blank">click here</a></p>
                        <h4>Tags</h4>
                        <p>
                            @foreach ($event->tags()->get() as $tag)
                                {{ $tag->name }},
                            @endforeach
                        </p>
                        <h4>Dates</h4>
                        <p>{{ $event->startDate->toFormattedDateString() }} to {{ $event->endDate->toFormattedDateString() }}</p>
                        <h4>Closing date for entries</h4>
                        <p>{{ $event->closingDate->toFormattedDateString() }}</p>
                    </div>
                </div>
            </section>
            <section>
                <div class="col-sm-12">
                    <div class="heading">
                        <h3>Event description</h3>
                    </div>
                    <div>{!! $event->description !!}</div>

                    <h4>Late Entries</h4>
                    @if ($event->lateEntries == 1)
                        <p>The organiser will accept late entries for this event
                        @if ($event->lateEntriesFee > 0)
                            and an additional charge of £{{ $event->lateEntriesFee }} will be payable after {{ $event->closingDate->toFormattedDateString()}}.
                        @else
                            There is no charge for late entries for this event.
                        @endif
                    @else
                        <p>Late entries are not accepted for this event. Please enter before {{ $event->closingDate->toFormattedDateString() }}
                    @endif
                        </p>

                </div>
            </section>

            <section>


                <div class="col-sm-12">
                    <div class="heading">
                        <h3>Enter</h3>
                    </div>
                    @if ($guest)
                        <div>You must be logged in to access the entry form.</div>
                        <div class="login">
                            <button class="btn btn-template-main"><a href="{{ url('/login') }}"><i class="fa fa-sign-in"></i>Sign in</a></button>

                            <button class="btn btn-template-main"><a href="{{ url('/register') }}"><i class="fa fa-user"></i> <span class="hidden-xs text-uppercase">Sign up</span></a></button>
                        </div>
                    @else {{-- The user is logged in --}}
                        {{-- If the closing date < now --}}
                        @if ($event->closingDate->lt(\Carbon\Carbon::now('Europe/London')))
                            {{-- The closing date for entries has passed. check whether late entries are OK--}}
                            @if ($event->lateEntries == 1)
                                {{--Late entries are OK, show the entry form. --}}
                                <h4>The closing date for entries has passed but the organiser is accepting late entries with an extra fee of £{{$event->lateEntriesFee}}.</h4>
                                @include('events._entryform')
                            @else
                                <h3>Entries for this event and the organiser has chosen not to accept late entries.</h3>
                            @endif
                        @else
                            {{-- The closing date > now. There's still time to enter before the closing date --}}
                            @include('events._entryform')
                        @endif {{-- end if closing date --}}
                    @endif {{--end if Auth::guest() --}}
                </div>
            </section>

            <section><!-- related events --></section>
        </div>
    </div>
</div>
<p></p>
@stop