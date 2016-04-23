@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">First name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="firstname">

                                    @if ($errors->has('firstname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Last name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lastname">

                                    @if ($errors->has('lastname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('club') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Shooting club</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="club">

                                    @if ($errors->has('club'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('club') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Phone number</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone">

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('homeCountry') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Home Country</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="homeCountry">
                                        <option value="ENG">England (ENG)</option>
                                        <option value="GIB">Gibraltar (GIB)</option>
                                        <option value="GUE">Guernsey (GUE)</option>
                                        <option value="IOM">Isle of Man (IOM)</option>
                                        <option value="JER">Jersey (JER)</option>
                                        <option value="NI">Northern Ireland (NI)</option>
                                        <option value="SCO">Scotland (SCO)</option>
                                        <option value="WAL">Wales (WAL)</option>
                                        <option value="NON">Non-GB</option>
                                    </select>
                                    @if ($errors->has('homeCountry'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('homeCountry') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i>Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
