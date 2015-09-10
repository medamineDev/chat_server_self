<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{!! csrf_token() !!}"/>
    @yield("meta")
    <title>Laravel</title>
    @yield("style")
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>


    <![endif]-->


    <link rel="stylesheet" href="{{ URL::asset('libs/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('libs/css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('libs/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('libs/css/mycss.css') }}">

    <script src="{{ URL::asset('libs/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('libs/js/bootstrap.min.js') }}"></script>


    @yield("css")


</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Chat-Room</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Home</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="{{ url('/auth/login') }}">Login</a></li>
                    <li><a href="{{ url('/auth/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>

<script language="javascript">


    var host = "http://" + window.location.host;
    var sock_host = window.location.hostname;
    console.log("host ---->" + host);
    console.log("sock_host ---->" + sock_host);
    var logged_user = [];


    var socket = io.connect(sock_host + ':8890');


    function get_logged_user(_callback) {

        $.ajax({
            type: "GET",
            url: host + '/get_logged_user',
            data: {}
        }).done(function (response) {

            console.log(response.user_id);
            var logged_user_id = response.user_id;
            _callback(response);

        });

    }

    get_logged_user(function (response) {

        logged_user = response;
        socket.emit('chat_init', response.user_id);

    });


</script>


@yield('js')


</body>
</html>
