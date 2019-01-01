<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-small-cap">Control Web App Content</li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="mdi  mdi-account-multiple-plus"></i>
                        <span class="hide-menu">
                        Users </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ action('Admin\UserController@index', 'users') }}">All </a></li>
                        <li><a href="{{ action('Admin\UserController@admins', 'admins') }}">Users </a></li>
                        <li><a href="{{ action('Admin\UserController@customers', 'customers') }}">Customers</a></li>
                        <li><a href="{{ action('Admin\UserController@suppliers', 'suppliers') }}">Suppliers(users)</a></li>

                    </ul>
                </li>


                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="mdi mdi-arrange-bring-forward"></i>
                        <span class="hide-menu">
                        Suppliers </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ action('Admin\SupplierController@index', 'suppliers') }}">All </a></li>

                    </ul>
                </li>

                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fas fa-truck-monster"></i>
                        <span class="hide-menu">
                        Truck </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ action('Admin\TruckController@online', 'onlineTrucks') }}">Online Trucks</a></li>

                        <li><a href="{{ action('Admin\TruckController@index', 'trucks') }}">All </a></li>
                        <!--                 <li><a href="{{ action('Admin\TruckController@create', 'truck') }}">New</a></li> -->
                    </ul>
                </li>

                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fas fa-user-shield"></i>
                        <span class="hide-menu">
                        Roles </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ action('Admin\RoleController@index', 'roles') }}">all </a></li>
                        <li><a href="{{ action('Admin\RoleController@create', 'role') }}">New</a></li>
                    </ul>
                </li>

                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span class="hide-menu">
                        Renew Account </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ action('Admin\BillController@index', 'bills') }}">All </a></li>

                    </ul>
                </li>

                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fas fa-tasks"></i>       
                        <span class="hide-menu">
                        Orders </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ action('Admin\OrderController@index', 'orders') }}">All </a></li>

                    </ul>
                </li>

                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fas fa-star"></i>       
                        <span class="hide-menu">
                        Rating </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ url('admin/ratings/1') }}">Orders Rating </a></li>

                    </ul>
                </li>


            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
