<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title')
    </title>

    <link rel="stylesheet" href="{{ URL::asset ('css/app.css') }}">
    <script src="{{ URL::asset ('js/app.js') }}"></script>
    @stack('head-scripts')

</head>
<body class="nav-md">

    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                <a href="index.html" class="site_title"><img src="{{URL('images/auth/uab-logo.png')}}" alt=""></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                <div class="profile_pic">
                    <img src="{{URL('images/auth/profile.png')}}" alt="..." class="img-circle profile_img">
                </div>
                <div class="profile_info">
                    <span>Welcome,</span>
                    <h2>{{Auth::user()->name}}</h2>
                </div>
                </div>
                <!-- /menu profile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                <div class="menu_section">
                    <ul class="nav side-menu">
                    <li class="active">
                        <a href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="appointment.html"><i class="fa fa-book"></i> Appointments <span class="badge badge-primary fa">12</span></a>
                    </li>
                    <li>
                        <a href="room.html"><i class="fa fa-square"></i> Rooms <span class="fa"></span></a>
                    </li>
                    <li><a><i class="fa fa-table"></i> Data <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                        <li><a href="staff.html"> <i class="fa fa-user"></i> Staff</a></li>
                        <li><a href="department.html"> <i class="fa fa-building"></i> Department</a></li>
                        <li><a href="branch.html"> <i class="fa fa-building"></i> Branch</a></li>
                        <li><a href="township.html"> <i class="fa fa-map-marker"></i> Township</a></li>
                        <li><a href="city.html"> <i class="fa fa-square"></i> City</a></li>
                        </ul>
                    </li>
                    <li>
                        <a><i class="fa fa-bar-chart-o"></i> Reports <span class="fa"></span></a>
                    </li>
                    <li>
                        <a><i class="fa fa-clone"></i> Logout <span class="fa"></span></a>
                    </li>
                    </ul>
                </div>
                </div>
                <!-- /sidebar menu -->
            </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav fixed-top">
            <div class="nav_menu">
                <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                <ul class=" navbar-right">
                    <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{URL('images/auth/profile.png')}}" alt=""> {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item"  href="javascript:;"> Profile</a>
                        <a class="dropdown-item"  href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </div>
                    </li>
                </ul>
                </nav>
            </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                @yield('content')
            </div>
            <!-- /page content -->
        </div>
    </div>

    @stack('body-scripts')
</body>
</html>
