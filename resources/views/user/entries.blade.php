@extends('layouts/app')

@section('content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <h3>{{ $user->firstname }}'s entries</h3>
            <ul>
            @foreach ($user->entries()->get() as $entry)
            	<li>{{ $entry->id }} {{ $entry->competition()->get() }}</li>
            	
            @endforeach
            </ul>
        </div>
    </div>

@endsection