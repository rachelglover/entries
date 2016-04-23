@extends('layouts/app')

@section('content')

    <section id="heading-breadcrumbs">
        <div class="container">
            <div class="row">
                <h2 class="title">Edit: {{ $event->name }}</h2>
            </div>
        </div>
    </section>
    <div id="content">
        <div class="container">
            @include('flash::message')
            <div class="row">
                @include('errors/list')
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    {!! Form::model($event, array( 'action' => ['EventsController@update',$event->slug], 'method' => 'PATCH', 'files' => true)) !!}
                    @include ('events/_eventform', ['submitButtonText' => 'Save'])
                    {!! Form::close() !!}
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>

@endsection