@extends('layouts/app')

@section('content')

<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Site Admin</h1>
            </div>
        </div>
    </div>
</div>
<div id="content">
    <div class="container">
        @include('flash::message')
        <div class="col-lg-12">
            
        </div>
    </div>
</div>

@endsection