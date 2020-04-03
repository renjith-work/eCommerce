<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CMS</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/cmadmin/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/cmadmin/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/cmadmin/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/cmadmin/bower_components/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="/cmadmin/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="/cmadmin/dist/css/custom.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/cmadmin/dist/css/skins/_all-skins.css">
    <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
   <script src="/cmadmin/dist/js/jquery.js"></script>
   <script src="/cmadmin/dist/js/jquery-ui.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @yield('header')
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="/dashboard" class="logo"> <span class="logo-mini"><b>P</b>XT</span> <span class="logo-lg"><b>PIX</b>TENT</span> </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="/cmadmin/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> <span class="hidden-xs"> {{-- {{ Auth::user()->name }} --}}</span> </a>
                            <ul class="dropdown-menu admin-top-link">
                                <li><a href="#"><i class="fa fa-user text-aqua"></i>Profile</a></li>
                                {{-- <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out text-danger"></i>Sign Out</a></li> --}}
                                {{-- <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">{{csrf_field()}}</form> --}}
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>