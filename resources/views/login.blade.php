<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ URL::asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ URL::asset('assets/img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name', 'Thukela Metering') }} | Log In</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/css/now-ui-dashboard.css?v=1.5.0') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/demo/demo.css') }}" rel="stylesheet" />
    <style>
        .panel-header-sm{
            height: 100vh!important;
        }
    </style>
</head>
<body class="">
<div class="wrapper">
    <div class="" id="main-panel">
        <div class="panel-header panel-header-sm">
            <div class="content">
                <div class="row">
                    <div class="col-md-4 offset-4">
                        @include("error")
                        <div class="card mt-5">
                            <div class="card-header text-center">
                                <a href="{{ URL::to('/') }}">
                                    <h4 class="card-title"><b>{{ config('app.name', 'Thukela Metering') }}</b></h4>
                                </a>
                            </div>
                            <div class="card-body text-center">
                                <p class="login-box-msg">Sign in to start your session</p>
                                <form class="" role="form" method="POST" action="{{ route('user.login') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} has-feedback">
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}">
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        @if ($errors->has('username'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        @if ($errors->has('password'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 offset-8">
                                            <button type="submit" class="btn btn-danger btn-block btn-flat">Sign In</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL('assets/js/core/jquery.min.js')}}"></script>
<script src="{{ URL('assets/js/core/popper.min.js')}}"></script>
<script src="{{ URL('assets/js/core/bootstrap.min.js')}}"></script>
<script src="{{ URL('assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<script src="{{ URL('assets/js/plugins/chartjs.min.js')}}"></script>
<script src="{{ URL('assets/js/plugins/bootstrap-notify.js')}}"></script>
<script src="{{ URL('assets/js/now-ui-dashboard.min.js?v=1.5.0')}}" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ URL('assets/demo/demo.js')}}"></script>
</body>
</html>
