<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Viva Multi Karya</title>
    <link href="{{ asset('assets/style/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="dark">
	<div id="app">
        <div class="wrapper">
            @include('layouts.sidebar',['menus'=>$menus])
            <div class="site-content">
                <nav class="navbar navbar-default navbar-fixed-top">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" id="sidebarCollapse" class="navbar-btn">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
                                        {{session('user')->fullname}}<span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#/app/userprofile">Ubah Profil</a></li>
                                        <li><a href="#/app/changepassword">Ubah Password</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{url('auth/logout')}}" title="Keluar">
                                        <i class="fa fa-sign-out"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="bg-white">
                    <transition>
                        <router-view token="{{session('user')->remember_token}}"></router-view>
                    </transition>
                </div>
            </div>
        </div>
	</div>
	<script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>