<!-- ============================================================== -->
<!-- Topbar header -->
<!-- ============================================================== -->
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="/admin" style="color: #FFF;">
                <!-- Logo icon --><b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <!-- <img src="/assets/admin/images/logo.png" alt="homepage" class="dark-logo"/> -->
                    <!-- Light Logo icon -->
                    <!-- <i class="fas fa-cogs"></i> -->
                    <img width="40px" height="40px" src="{{asset('/assets/admin/images/raw_logo.png')}}" alt="homepage"
                         class="light-logo"/>
                </b>
                <!--End Logo icon -->
                <!-- Logo text --><span style="color: white; margin-right: 20px;">
                         <!-- dark Logo text -->
                         <!-- <img src="/assets/admin/images/logo-text.png" alt="homepage" class="dark-logo"/> -->
                    <!-- Light Logo text -->
                         <!-- <img width="108px" height="25px" src="/assets/admin/images/logo-light-text.png" class="light-logo"
                              alt="homepage"/> -->

                              <img width="110px" height="40px" src="{{asset('/assets/admin/images/logo_splash.png')}}" alt="homepage" class="light-logo"/>
                </span> </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"><a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark"
                                        href="javascript:void(0)"><i class="ti-menu"></i></a></li>
                <li class="nav-item"><a class="nav-link sidebartoggler hidden-sm-down waves-effect waves-dark"
                                        href="javascript:void(0)"><i class="ti-menu"></i></a></li>
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                
                <!-- ============================================================== -->
                <!-- Messages -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- End Messages -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false"><img src="{{asset('/assets/admin/images/users/1.jpg')}}" alt="user"
                                                                       class="profile-pic"/></a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="{{asset('/assets/admin/images/users/1.jpg')}}" alt="user"></div>
                                    <div class="u-text">
                                        <h4>{{ Auth::user()->name }}</h4>
                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <a data-logout href="javascript:void(0)"><i class="fa fa-power-off"></i> Logout</a>
                                <form action="/logout" method="post">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->		