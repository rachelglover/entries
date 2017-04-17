<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="all,follow">
    <meta name="googlebot" content="index,follow,snippet,archive">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Foresight Entries</title>

    <meta name="keywords" content="">

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

    <!-- Bootstrap and Font Awesome css -->
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">

    <!-- Css animations  -->
    <link href="{{ URL::asset('css/animate.css') }}" rel="stylesheet">

    <!-- Theme stylesheet, if possible do not edit this stylesheet -->
    <link href="{{ URL::asset('css/style.violet.css') }}" rel="stylesheet" id="theme-stylesheet">

    <!-- Custom stylesheet - for your changes -->
    <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/foresight.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/summernote.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/bootstrap.vertical-tabs.css') }}" rel="stylesheet">

    <!-- Responsivity for older IE -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

    <!-- Favicon and apple touch icons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="img/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="img/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="img/apple-touch-icon-152x152.png" />
    <!-- owl carousel css -->

    <link href="{{ URL::asset('css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/owl.theme.css') }}" rel="stylesheet">
</head>

<body>

    <div id="all">

        <header>

            <!-- *** TOP ***
_________________________________________________________ -->
            <div id="top">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="social">
                                <a href="http://www.facebook.com/shootingentries" class="external facebook" data-animate-hover="pulse"><i class="fa fa-facebook"></i></a>
                                <a href="http://www.twitter.com/foresightshooting" class="external twitter" data-animate-hover="pulse"><i class="fa fa-twitter"></i></a>
                                <a href="{{action('PagesController@contact')}}" class="email" data-animate-hover="pulse"><i class="fa fa-envelope"></i></a>
                            </div>
                            @if (Auth::guest())
                            <div class="login">
                                <a href="{{ url('/login') }}"><i class="fa fa-sign-in"></i> <span class="hidden-xs text-uppercase">Sign in</span></a>
                                <a href="{{ url('/register') }}"><i class="fa fa-user"></i> <span class="hidden-xs text-uppercase">Sign up</span></a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- *** TOP END *** -->

            <!-- *** NAVBAR ***
    _________________________________________________________ -->

            <div class="navbar-affixed-top" data-spy="affix" data-offset-top="200">

                <div class="navbar navbar-default yamm" role="navigation" id="navbar">

                    <div class="container">
                        <div class="navbar-header">

                            <a class="navbar-brand home" href="{{ action('PagesController@index') }}">
                                <img src="{{ URL::asset('img/logo.png') }}" alt="Universal logo" class="hidden-xs hidden-sm"><span class="sr-only">Homepage</span>
                            </a>
                            <div class="navbar-buttons">
                                <button type="button" class="navbar-toggle btn-template-main" data-toggle="collapse" data-target="#navigation">
                                    <span class="sr-only">Toggle navigation</span>
                                    <i class="fa fa-align-justify"></i>
                                </button>
                            </div>
                        </div>
                        <!--/.navbar-header -->

                        <div class="navbar-collapse collapse" id="navigation">

                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a href="{{ action('PagesController@index') }}">Home</a>
                                </li>
                                <li class="dropdown">
                                    <a href="{{ action('EventsController@index') }}">All events</a>
                                </li>
                                <li class="dropdown">
                                    <a href="{{ action('EventsController@create') }}">Create event</a>
                                </li>

                                <li class="dropdown">
                                    <a href="javascript: void(0)" class="dropdown-toggle" data-toggle="dropdown">Info <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ action('PagesController@faq') }}">FAQs</a></li>
                                        <li><a href="{{ action('PagesController@about') }}">About</a></li>
                                        <li><a href="{{ action('PagesController@contact') }}">Contact</a></li>
                                    </ul>
                                </li>
                                @if (Auth::check())
                                <li class="dropdown">
                                    <a href="javascript: void(0)" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        {{! $user = Auth::user()}}
                                        @if ($user->id == 1)
                                            <li><a href="{{ action('EventsController@siteAdmin') }}">Site admin</a></li>
                                        @endif
                                        <li><a href="{{ action('PagesController@userProfile') }}">Edit profile</a>
                                        </li>
                                        <li><a href="{{ action('PagesController@userEntries') }}">My entries</a>
                                        </li>
                                        <li><a href="{{ action('PagesController@userEvents') }}">My events</a>
                                        </li>
                                        <li><a href="{{ url('/logout') }}">Logout</a>
                                    </ul>
                                </li>
                                @endif
                            </ul>

                        </div>
                        <!--/.nav-collapse -->



                        <div class="collapse clearfix" id="search">

                            <form class="navbar-form" role="search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <span class="input-group-btn">

                    <button type="submit" class="btn btn-template-main"><i class="fa fa-search"></i></button>

                </span>
                                </div>
                            </form>

                        </div>
                        <!--/.nav-collapse -->

                    </div>


                </div>
                <!-- /#navbar -->

            </div>

            <!-- *** NAVBAR END *** -->

        </header>


<!-- include errors if there are some -->
@include('errors.list')



<!-- Page Content -->

    @yield('content')

<!-- /.container -->
 <!-- *** FOOTER ***
_________________________________________________________ -->

{{--<footer id="footer">
    <div class="container">

    </div>
    <!-- /.container -->
</footer>--}}
<!-- /#footer -->

<!-- *** FOOTER END *** -->

<!-- *** COPYRIGHT ***
_________________________________________________________ -->

<div id="copyright">
    <div class="container">
        <div class="col-md-12">
            <p class="pull-left">&copy; 2017 <a href="http://www.foresightentries.com">Foresight Entries</a></p>
        </div>
    </div>
</div>
<!-- /#copyright -->

<!-- *** COPYRIGHT END *** -->



    </div>
    <!-- /#all -->

    <!-- #### JAVASCRIPT FILES ### -->

    <script src="{{ URL::asset('js/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}" type="text/javascript"></script>

    <script src="{{ URL::asset('js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/waypoints.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/jquery.counterup.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/jquery.parallax-1.1.3.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/front.js') }}" type="text/javascript"></script>

    <!-- owl carousel -->
    <script src="{{ URL::asset('js/owl.carousel.min.js') }}" type="text/javascript"></script>

    <!--FORESIGHT -->
    <script src="{{ URL::asset('js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/foresight.js') }}" type="text/javascript"></script>

</body>

</html>