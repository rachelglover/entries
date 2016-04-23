@extends('layouts/app')

@section('content')

<section id="heading-breadcrumbs">
    <div class="container">
		<div class="row">
			<h2 class="title">Create a new event</h2>
		</div>
    </div>
</section>
<div id="content">
	<div class="container">
		@include('flash::message')
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				{!! Form::open(array( 'action' => 'EventsController@index', 'files' => true)) !!}
		        	@include ('events/_eventform', ['submitButtonText' => 'Save and continue'])
		    	{!! Form::close() !!}
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>
</div>

@endsection
