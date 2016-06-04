@extends('layouts/app')

@section('content')
<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <h1>FAQ</h1>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <p class="lead">
                We've listed our frequently asked questions below. If you can't find the answer to your question, please <a href="{{action('PagesController@contact')}}">contact us</a>.
            </p>
            <div class="panel-group" id="accordion">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#faq1">
                                1. How does this work?
                            </a>
                        </h4>
                    </div>
                    <div id="faq1" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas
                                semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                            <ul>
                                <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
                                <li>Aliquam tincidunt mauris eu risus.</li>
                                <li>Vestibulum auctor dapibus neque.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection