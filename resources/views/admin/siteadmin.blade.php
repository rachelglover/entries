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
            <ul class="nav nav-tabs">
                <li class="active"><a href="#refunds" data-toggle="tab">Refunds/Cancellations</a></li>
                <li><a href="#futuretransfers" data-toggle="tab">Future Transfers</a></li>
                <li><a href="#pasttransfers" data-toggle="tab">Past Transfers</a></li>
                <li><a href="#currentevents" data-toggle="tab">Current events</a></li>
            </ul>
            <div class="tab-content">
                @include('admin.refundsTab')
                @include('admin.futuretransfersTab')
                @include('admin.pasttransfersTab')
                @include('admin.currenteventsTab')
            </div>
        </div>
    </div>
</div>

@endsection