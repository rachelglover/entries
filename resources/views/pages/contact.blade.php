@extends('layouts/app')

@section('content')
<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Contact us</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        @include('flash::message')
        <div class="row">
            <form method="post" action="{{ action('PagesController@processContactForm') }}">
                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    {!! Form::label('Your name') !!}
                    {!! Form::text('name', null,
                        array('required',
                            'class' => 'form-control',
                            'placeholder' => 'Your name'
                        )) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Your email address') !!}
                    {!! Form::text('email', null,
                        array('required',
                            'class' => 'form-control',
                            'placeholder' => 'Your email address'
                        )) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Your message') !!}
                    {!! Form::textarea('message', null,
                        array('required',
                            'class' => 'form-control',
                            'placeholder' => 'Your message'
                        )) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Send',
                        array('class' => 'btn btn-primary')) !!}
                </div>
            </form>
        </div>
    </div>
</div>

@endsection