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
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="dark">
    <div>
        <div class="wrapper">
            <div id="main" class="padding-bottom65 padding-top55">
                <div class="container-fluid">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-md-offset-4">
                                <div class="col-sm-4 col-md-4 col-md-offset-4">
                                    <img ng-if="profile" src="" class="img-responsive" />
                                </div>
                                <div class="account-wall">
                                    <div class="clearfix"></div>
                                    <form class="form-signin" method="post" action="{{url('auth/do_login')}}">
                                        <h4 class="login-title text-center">Sign in to start your session</h4>
                                        {{ csrf_field() }}
                                        <input type="text" required="required" class="form-control" placeholder="Username" name="username" autofocus/>
                                        <input type="password" required="required" class="form-control" placeholder="Password" name="password" />
                                        @if( session('danger') )
                                            <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                </i></h3> {{ session('danger') }}
                                            </div>
                                        @endif
                                        <button class="btn btn-lg btn-primary btn-block" type="submit">
                                            Sign in</button>
                                        <div class="clearfix"></div>
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-6 no-padding">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="remember" value="1">Remember Me</label>
                                                </div>
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
    <script src="{{ asset('assets/script/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/script/bootstrap.min.js') }}"></script>
</body>

</html>