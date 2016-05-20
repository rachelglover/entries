@extends('layouts/app')

@section('content')
<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                @if ($event->status == 'unpublished')
                <h2>Under construction:</h2>
                @endif
                <h3>{{$event->name}}</h3>
            </div>
        </div>
    </div>
</div>
<div id="content">
    <div class="container">
        @include('flash::message')
        {{-- bring in all the modals --}}
        @include('Events.organiser.underconstruction.modals.addCompetition')
        @include('Events.organiser.underconstruction.modals.addDetail')
        @include('Events.organiser.underconstruction.modals.publishEvent')
        @include('Events.organiser.underconstruction.modals.addExtra')



    @if ($event->status == 'unpublished')
        <div class="row">
            <div class="col-lg-12">
                <div class="lead"><b>Hi {{ $user->firstname }}!</b></div>
                <p>Now that we have the basic information about your event you can add competitions and details to it. You can also add optional extras, discounts and questions that you would like answered on the entry form.</p>
                <button type="button" class="btn btn-sm"><a href="{{ action('EventsController@edit',$event->slug) }}">Edit basic info</a></button>
                <button type="button" class="btn btn-sm"><a href="{{ action('EventsController@show',$event->slug) }}" target="_blank">Preview entry form</a></button>
                <div class="pull-right">
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#publishModal">Make your event LIVE!</button>
                </div>
                <p></p>
            </div>
        </div>
            {{ $tabName = !empty(Session::get('tabName')) ? (string)Session::get('tabName') : 'competitions' }}
        <div class="tabs">
            <ul class="nav nav-pills nav-justified">
                <li class="{{ $tabName == 'competitions' ? 'active' : '' }}"><a href="#competitions" data-toggle="tab">Competitions and details</a></li>
                <li class="{{ $tabName == 'questions' ? 'active' : '' }}"><a href="#questions" data-toggle="tab">Entry form questions</a></li>
                <li class="{{ $tabName == 'extras' ? 'active' : '' }}"><a href="#extras" data-toggle="tab">Optional Extras</a></li>
                <li class="{{ $tabName == 'discounts' ? 'active' : '' }}"><a href="#discounts" data-toggle="tab">Discounts</a></li>
            </ul>
            <div class="tab-content tab-content-inverse">
                @include('Events.organiser.underconstruction.questionsTab')
                @include('Events.organiser.underconstruction.extrasTab')
                @include('Events.organiser.underconstruction.competitionsTab')
                @include('Events.organiser.underconstruction.discountsTab')
            </div>
        </div>
        <p></p>
    @endif {{-- end of 'unpublished' event admin --}}

    @if ($event->status == 'published')
        <div class="row">
            <div class="col-lg-12">
                <h4>Hello {{ $user->firstname }}, welcome to your event dashboard.</h4>
            </div>
        </div>
        <div class="col-lg-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#overview" data-toggle="tab"><i class="fa fa-bar-chart"></i>Overview</a></li>
                <li><a href="#competitions" data-toggle="tab"><i class="fa fa-trophy"></i>Competitions</a></li>
                <li><a href="#competitors" data-toggle="tab"><i class="fa fa-user"></i>Competitors</a></li>
                <li><a href="#finances" data-toggle="tab"><i class="fa fa-gbp"></i>Finances</a></li>
                @if ($event->questions()->get()->count() > 0)
                    <li><a href="#questions" data-toggle="tab"><i class="fa fa-question"></i>Your questions</a></li>
                @endif
                @if ($event->extras()->get()->count() > 0)
                    <li><a href="#extras" data-toggle="tab"><i class="fa fa-ticket"></i>Your extras</a></li>
                @endif
                <li><a href="#communications" data-toggle="tab"><i class="fa fa-envelope"></i>Communication</a></li>
            </ul>
            <div class="tab-content">
                @include('Events.organiser.published.overviewTab')
                @include('Events.organiser.published.competitionsTab')
                @include('Events.organiser.published.competitorsTab')
                @include('Events.organiser.published.financesTab')
                @if ($event->questions()->get()->count() > 0)
                    @include('Events.organiser.published.questionsTab')
                @endif
                @if ($event->extras()->get()->count() > 0)
                    @include('Events.organiser.published.extrasTab')
                @endif
                @include('Events.organiser.published.commsTab')
            </div>
        </div>
    @endif {{-- end of 'published' event admin version --}}
    </div> {{-- end of container --}}
</div>
@endsection