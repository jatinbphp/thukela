<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ URL::asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ URL::asset('assets/img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name', 'Thukela Metering') }} | {{ $menu }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/css/now-ui-dashboard.css?v=1.5.0') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/demo/demo.css') }}" rel="stylesheet" />
    <style>
        #payNowBtn{
            width: 50%;
            margin: 0 auto;
        }
        .table>thead>tr>th{
            font-size: 1.2em;
            font-weight: 400;
        }
    </style>
</head>
<body class="">
<div class="wrapper ">
    <div class="sidebar" data-color="orange">
        <div class="logo">
            <a href="{{route('user.provisionalbill')}}" class="simple-text logo-normal">
                {{ config('app.name', 'Thukela Metering') }}
            </a>
        </div>
        <div class="sidebar-wrapper" id="sidebar-wrapper">
            <ul class="nav">
                <!--<li class="@if($menu == 'Dashboard') active  @endif">
                    <a href="{{route('user.dashboard')}}">
                        <i class="now-ui-icons design_app"></i>
                        <p>Dashboard</p>
                    </a>
                </li>-->
                <!--<li class="@if($menu == 'Transactions') active  @endif">
                    <a href="{{route('user.transactions')}}">
                        <i class="now-ui-icons business_money-coins"></i>
                        <p>Transactions</p>
                    </a>
                </li>-->
                <li class="@if($menu == 'Provisional Bill') active  @endif">
                    <a href="{{route('user.provisionalbill')}}">
                        <i class="now-ui-icons business_bulb-63"></i>
                        <p>Provisional Bill</p>
                    </a>
                </li>
                <li class="@if($menu == 'Notifications') active  @endif">
                    <a href="{{route('user.notifications')}}">
                        <i class="now-ui-icons ui-1_bell-53"></i>
                        <p>Notifications</p>
                    </a>
                </li>
                <li class="@if($menu == 'Contact Us') active  @endif">
                    <a href="{{route('user.contactus')}}">
                        <i class="now-ui-icons ui-2_chat-round"></i>
                        <p>Contact Us</p>
                    </a>
                </li>
                <li class="active-pro">
                    <a href="{{route('user.logout')}}">
                        <i class="now-ui-icons media-1_button-power"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel" id="main-panel">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>
                    <a class="navbar-brand" href="{{route('user.'.strtolower(str_replace(' ','',$menu)))}}">{{$menu}}</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="panel-header panel-header-sm"></div>
        <div class="content">
            @yield('content')
        </div>
        <footer class="footer">
            <div class=" container-fluid ">
                <nav>
                    <ul>
                        <li>
                            <a href="{{route('user.dashboard')}}">
                                {{ config('app.name', 'Thukela Metering') }}
                            </a>
                        </li>
                    </ul>
                </nav>
                <!--<div class="copyright" id="copyright">
                    &copy; <script>
                        document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                    </script>, Designed by <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
                </div>-->
            </div>
        </footer>
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
<script>
    $(document).ready(function() {
        demo.initDashboardPageCharts();
    });
</script>
@yield('jquery')
</body>
</html>
