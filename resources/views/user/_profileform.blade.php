<div>
    {!! Form::open(array('action' => 'PagesController@editProfile')) !!}
</div>

<div class="form-group">
    {!! Form::label('firstname', 'First name:') !!}
    {!! Form::text('firstname', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('lastname', 'Last name:') !!}
    {!! Form::text('lastname', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('email', 'Email address:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('club', 'Shooting club:') !!}
    {!! Form::text('club', null, ['class' => 'form-control']) !!}
</div>

<div class="form-control">
    {!! Form::label('homeCountry', 'Home country:') !!}
    <small>e.g. England, Scotland, Isle of Man</small>
    {!! Form::text('homeCountry', null, ['class' => 'form-control']) !!}
</div>

<div class="form-control">
    {!! Form::label('phone', 'Phone number:') !!}
    {!! form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<div class="form-control">
    {!! Form::submit('Submit', ['class' => 'btn']) !!}
</div>

<div>
    {!! Form::close() !!}
</div>