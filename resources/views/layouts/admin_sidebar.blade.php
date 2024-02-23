            <!-- START SIDEBAR-->
            <nav class="page-sidebar" id="sidebar">
                <div id="sidebar-collapse">
                    <div class="admin-block d-flex">
                        <div>
                            <img src="{{asset('assets/img/admin-avatar.png')}}" width="45px" />
                        </div>
                        <div class="admin-info">
                            <div class="font-strong">{{ Auth::user()->name }}</div><small>Admin</small></div>
                    </div>
                    <ul class="side-menu metismenu">
                        <li>
                            <a class="active" href="{{ route('admin.dashboard')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                                <span class="nav-label">Dashboard</span>
                            </a>
                        </li>
                        <li class="heading">Mange Invoice</li>
                        <li>
                            <a href="{{ route('admin.bills.index')}}"><i class="sidebar-item-icon fa fa-money"></i>
                                <span class="nav-label">Bill List</span>
                            </a>
                        </li>
                        <li class="heading">Mange Customer</li>
                        <li>
                            <a href="{{ route('admin.users.index')}}"><i class="sidebar-item-icon fa fa-users"></i>
                                <span class="nav-label">Customer List</span>
                            </a>
                        </li>
                        <li class="heading">Setup</li>
                        <li>
                            <a href="{{ route('admin.services.index')}}"><i class="sidebar-item-icon fa fa-cog"></i>
                                <span class="nav-label">Service List</span>
                            </a>
                            <li>
                            <a href="{{ url('admin/bill-search')}}"><i class="sidebar-item-icon fa fa-money"></i>
                                <span class="nav-label">Bill Report</span>
                            </a>
                            
                        </li>
                        </li>

                    </ul>
                </div>
            </nav>
            <!-- END SIDEBAR-->
