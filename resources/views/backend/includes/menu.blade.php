<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">User</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('dashboard') }}" aria-expanded="false">
                        <i class="mdi mdi-av-timer"></i>
                        <span class="hide-menu">Dashboard </span>
{{--                        <span class="badge rounded-pill bg-info ms-auto mr-3">3</span>--}}
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-crop-square"></i>
                        <span class="hide-menu">User Management </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('districts.index') }}" class="sidebar-link">
                                <i class="mdi mdi-format-align-left"></i>
                                <span class="hide-menu"> Districts </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('areas.index') }}" class="sidebar-link">
                                <i class="mdi mdi-format-align-right"></i>
                                <span class="hide-menu"> Areas </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('users.index') }}" class="sidebar-link">
                                <i class="mdi mdi-format-align-right"></i>
                                <span class="hide-menu"> Users </span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-crop-square"></i>
                        <span class="hide-menu">Products Management </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('categories.index') }}" class="sidebar-link">
                                <i class="mdi mdi-format-align-left"></i>
                                <span class="hide-menu"> Category Management </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('products.index') }}" class="sidebar-link">
                                <i class="mdi mdi-format-align-right"></i>
                                <span class="hide-menu"> Product Management </span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Apps</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('sms-offers.index') }}" aria-expanded="false"><i class="mdi mdi-comment-processing-outline"></i><span class="hide-menu">Send Offers</span></a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('orders.index') }}" aria-expanded="false"><i class="mdi mdi-comment-processing-outline"></i><span class="hide-menu">Orders</span></a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('basic-settings.create') }}" aria-expanded="false"><i class="mdi mdi-comment-processing-outline"></i><span class="hide-menu">Settings</span></a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="" ONCLICK="event.preventDefault();document.getElementById('logoutForm').submit()" aria-expanded="false">
                        <i class="mdi mdi-directions"></i>
                        <span class="hide-menu">Log Out</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
