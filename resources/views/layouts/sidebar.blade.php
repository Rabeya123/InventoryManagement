    <!-- START SIDEBAR-->
    <nav class="page-sidebar" id="sidebar">
        <div id="sidebar-collapse">
            <div class="admin-block d-flex">
                <div>
                    <img src="{{asset('assets/img/admin-avatar.png')}}" width="45px" />
                </div>
                <div class="admin-info">
                    <div class="font-strong">{{ Auth::user()->name }}</div><small>
                        {{ Auth::user()->role->name }}
                        {{-- @switch(Auth::user()->role_id)
                            @case(1)
                                Super Admin
                                @break
                            @case(2)
                                Admin
                                @break
                            @case(3)
                                Admin
                                @break
                            @default
                                Employee --}}
                        {{-- @endswitch --}}
                    </small></div>
            </div>
            <ul class="side-menu metismenu">
                <li>
                    <a class="active" href="{{ route('user.dashboard')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>

                <li class="heading">Inventory</li>

                <li>
                    <a href="javascript:;"><i class="sidebar-item-icon fa fa-list-alt"></i>
                        <span class="nav-label">Manage</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="{{ route('inventories.create', ['type_id' => 1])}}"><i class="sidebar-item-icon fa fa-sign-in"></i>
                                <span class="nav-label">Add Product</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('inventories.create', ['type_id' => 2])}}"><i class="sidebar-item-icon fa fa-sign-out"></i>
                                <span class="nav-label">Product Out</span>
                            </a>
                        </li>--}}
                        <li> 
                            <a href="{{ route('inventories.create', ['type_id' => 3])}}"><i class="sidebar-item-icon fa fa-exchange"></i>
                                <span class="nav-label">Transfar</span>
                            </a>
                        </li>
                    </ul>
                </li>
     
                <li>
                    <a href="{{ route('inventories.index')}}"><i class="sidebar-item-icon fa fa-stack-exchange "></i>
                        <span class="nav-label">In House Stock</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user-products.index')}}"><i class="sidebar-item-icon fa fa-truck"></i>
                        <span class="nav-label">In Hand Stock</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('inventory-histories.index')}}"><i class="sidebar-item-icon fa fa-history "></i>
                        <span class="nav-label">History</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('product-batches.index')}}"><i class="sidebar-item-icon fa fa-object-group"></i>
                        <span class="nav-label">Batch</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('product-identifiers.index')}}"><i class="sidebar-item-icon fa fa-barcode"></i>
                        <span class="nav-label">Identifier</span>
                    </a>
                </li>

                <li class="heading">Others</li>
                
                <li>
                    <a href="{{ route('requisitions.index')}}"><i class="sidebar-item-icon fa fa-rocket"></i>
                        <span class="nav-label">Requisition</span>
                    </a>
                </li>

                
                <li>
                    <a href="javascript:;"><i class="sidebar-item-icon fa fa-retweet"></i>
                        <span class="nav-label">Purchase</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="{{ route('purchase-orders.index')}}"><i class="sidebar-item-icon fa fa-shopping-cart"></i>
                                <span class="nav-label">Purchase Order</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('companies.index')}}"><i class="sidebar-item-icon fa fa-paper-plane"></i>
                                <span class="nav-label">Suppliers</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;"><i class="sidebar-item-icon fa fa-cubes"></i>
                        <span class="nav-label">Product</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="{{ route('products.index')}}"><i class="sidebar-item-icon fa fa-microchip"></i>
                                <span class="nav-label">Products</span>
                            </a>
                        </li>
        
                        <li>
                            <a href="{{ route('categories.index')}}"><i class="sidebar-item-icon fa fa-list"></i>
                                <span class="nav-label">Categories</span>
                            </a>
                        </li>
        
                        <li>
                            <a href="{{ route('units.index')}}"><i class="sidebar-item-icon fa fa-puzzle-piece"></i>
                                <span class="nav-label">Units</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;"><i class="sidebar-item-icon fa fa-bars"></i>
                        <span class="nav-label">Others</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a href="{{ route('contacts.index')}}"><i class="sidebar-item-icon fa fa-id-card"></i>
                                <span class="nav-label">Contacts</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('locations.index')}}"><i class="sidebar-item-icon fa fa-archive"></i>
                                <span class="nav-label">Warehouse</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @if (auth()->user()->is_admin)
                    <li class="heading">User Access Control</li>
                    <li>
                        <a href="{{ route('users.index')}}"><i class="sidebar-item-icon fa fa-users"></i>
                            <span class="nav-label">Users</span> 
                        </a>
                    </li>  
                @endif 
            </ul>
        </div>
    </nav>
    <!-- END SIDEBAR-->
