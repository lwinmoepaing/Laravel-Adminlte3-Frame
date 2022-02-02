<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('admin.index') }}" class="site_title"><img src="{{URL('images/auth/uab-logo.png')}}" alt=""></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
        <div class="profile_pic">
            <img src="{{URL('images/auth/profile.png')}}" alt="..." class="img-circle profile_img">
        </div>
        <div class="profile_info">
            <span> uab </span>
            @auth
                <h2>{{Auth::user()->name}}</h2>
            @endauth
        </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <ul class="nav side-menu">
            <li class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                <a href="{{ route('admin.index') }}"><i class="fa fa-home"></i> Dashboard</a>
            </li>
            <li class="{{ request()->routeIs('admin.appointment') ? 'active' : '' }}">
                <a href="{{ route('admin.appointment') }}"><i class="fa fa-address-book"></i> Appointments</a>
            </li>
            <li class="{{ request()->routeIs('admin.rooms') ? 'active' : '' }}">
                <a href="{{ route('admin.rooms') }}"><i class="fa fa-clone"></i> Rooms </a>
            </li>
            <li><a><i class="fa fa-list-ul"></i> Data <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                <li><a href="{{route('admin.data.staff')}}"> <i class="fa fa-user-o"></i> Staff</a></li>
                <li><a href="{{route('admin.data.department')}}"> <i class="fa fa-building-o"></i> Department</a></li>
                <li><a href="{{route('admin.data.branch')}}"> <i class="fa fa-building"></i> Branch</a></li>
                <li><a href="{{route('admin.data.township')}}"> <i class="fa fa-map-marker"></i> Township</a></li>
                <li><a href="{{route('admin.data.division')}}"> <i class="fa fa-map-o"></i> City</a></li>
                </ul>
            </li>
            {{-- <li>
                <a><i class="fa fa-bar-chart-o"></i> Reports </a>
            </li> --}}
            <li>
                <a
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                ><i class="fa fa-sign-out"></i> Logout <span class="fa"></span></a>
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
       <div>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <span class="nav-custom-title">
                {{ $navTitle ?? 'Dashboard'}}
            </span>
       </div>

        <nav class="nav navbar-nav">
            <ul class="navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    @auth
                        <img src="{{ URL('images/auth/profile.png') }}" alt=""> {{ Auth::user()->name }}
                    @endauth
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="javascript:;"> Profile</a>
                    <a class="dropdown-item"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    ><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
