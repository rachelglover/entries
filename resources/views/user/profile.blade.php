@extends('layouts/app')

@section('content')

    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h2>Profile</h2>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            @include('flash::message')
            <div class="col-lg-12">
                <h4>Hi {{$user->firstname}}</h4>
            </div>
        </div>
    </div>

    @include('user/_profileform')
@endsection