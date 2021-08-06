 
<div class="navbar-wrapper">
    <div class="navbar-logo">
        <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
            <i class="ti-menu"></i>
        </a>
        <div class="mobile-search waves-effect waves-light">
            <div class="header-search">
                <div class="main-search morphsearch-search">
                    <div class="input-group">
                        <span class="input-group-prepend search-close"><i class="ti-close input-group-text"></i></span>
                        <input type="text" class="form-control" placeholder="Enter Keyword">
                        <span class="input-group-append search-btn"><i class="ti-search input-group-text"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <a href="index.html">
            <img class="img-fluid" src="assets/images/logo_aka.png" alt="Theme-Logo" style="height: 50px" />
        </a>
        <a class="mobile-options waves-effect waves-light">
            <i class="ti-more"></i>
        </a>
    </div>
    <div class="navbar-container container-fluid">
        <ul class="nav-left">
            <li>
                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
            </li>
            <li>
                <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                    <i class="ti-fullscreen"></i>
                </a>
            </li>
        </ul>
        <ul class="nav-right">
          
            <li class="user-profile header-notification">
                <a href="#!" class="waves-effect waves-light">
                    @if(Auth::user()->role_id == 1)
                    <img src="{{asset('uploads/foto_pengunjung/'.Auth::user()->photo)}}" class="img-radius" alt="User-Profile-Image">
                    @endif

                    @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 4) 
                    <img src="{{asset('uploads/foto_pengelola/'.Auth::user()->photo)}}" class="img-radius" alt="User-Profile-Image">
                    @endif

                    <span>{{Auth::user()->name}}</span>
                    <i class="ti-angle-down"></i>
                </a>
                <ul class="show-notification profile-notification">
                                   <!--  <li class="waves-effect waves-light">
                                        <a href="#!">
                                            <i class="ti-settings"></i> Settings
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a href="user-profile.html">
                                            <i class="ti-user"></i> Profile
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a href="email-inbox.html">
                                            <i class="ti-email"></i> My Messages
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a href="auth-lock-screen.html">
                                            <i class="ti-lock"></i> Lock Screen
                                        </a>
                                    </li> -->
                                    @if(Auth::user()->role_id == 1)
                                        
                                    <li class="waves-effect waves-light">
                                        <a href="{{ route('logout-pengunjung') }}">
                                            <i class="ti-layout-sidebar-left"></i> Logout
                                        </a>
                                    </li>
                                    @endif
                                    
                                    @if(Auth::user()->role_id == 2)
                                    <li class="waves-effect waves-light">
                                        <a href="{{ route('logout-admin') }}">
                                            <i class="ti-layout-sidebar-left"></i> Logout
                                        </a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->role_id == 3)
                                    <li class="waves-effect waves-light">
                                        <a href="{{ route('logout-guide') }}">
                                            <i class="ti-layout-sidebar-left"></i> Logout
                                        </a>
                                    </li>
                                    @endif
                                    @if(Auth::user()->role_id == 4)
                                    <li class="waves-effect waves-light">
                                        <a href="{{ route('logout-kepala_desa') }}">
                                            <i class="ti-layout-sidebar-left"></i> Logout
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                