<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topheader" id="top">
    <div class="fix-width">
        <nav class="navbar navbar-expand-md navbar-light p-l-0">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
            <!-- Logo will be here -->
            <a style="font-weight: bold;" class="navbar-brand" href="index.html"><!-- <img src="{{asset('/assets/homepage/images/logo-icon.png')}}" alt="logo" /> --> <img height="70px" width="70px" src="{{asset('/assets/admin/images/raw_logo.png')}}" alt="logo" /><b>Truck</b><b style="color: #f28f15">Up</b></a>

            <!-- This is the navigation menu -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto stylish-nav">
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Services</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#" target="_blank">Supplier Account</a>
                            <a class="dropdown-item" href="#" target="_blank">Private Trucks</a>
                            <a class="dropdown-item" href="#demos" target="_blank">Download Android</a>
                            <a class="dropdown-item" href="#" target="_blank">Download IOS</a>
                        </div>
                    </li>
                    <!-- <li class="nav-item"> <a class="nav-link" href="" target="_blank">Documentation</a> </li> -->
                    <li class="nav-item"> <a class="m-t-5 btn font-13" href="{{asset('/admin')}}" style="width:120px; background-color: #f28f15; color: #fff;">LOG IN</a> </li>
                </ul>
            </div>
        </nav>
    </div>
</header>