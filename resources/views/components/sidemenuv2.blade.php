<section class="hide" id="sidebar">
    <div id="closesidenav" style="position: absolute; right: 20px; top: 20px; font-size: 30px">
        <i class="fa-solid fa-xmark"></i>
    </div>

    @php
        $logo = DB::table('systemsettings')->where('type', 'logo')->first();
        $title = DB::table('systemsettings')->where('type', 'title')->first();
        $path = request()->path();
    @endphp

    <a class="logo" href="#">
        <img src="{{ $logo->input }}" alt="logo">
        <h4 style="width: 200px">{{ $title->input }}</h4>
    </a>


    <div class="w-100 py-3 d-block d-lg-none">
        <center>
            <div class="btn-group shadow-0 d-block d-lg-block">
                @include('components.submenu')
                <a class="dropdown-toggle hidden-arrow pe-3" id="dropdownMenuButton" data-mdb-toggle="dropdown" type="button">
                    @include('components.imagename')
                </a>
                <ul class="dropdown-menu">
                    @include('components.usermenu')
                </ul>
            </div>

        </center>
    </div>


    <ul class="side-menu">
        <li class="divider n1" data-text="home">HOME</li>
        <li><a class="{{ $path == 'dashboard' ? 'active-selected' : '' }}" href="dashboard"><i class="fa-solid fa-border-all icon"></i>
                <div class="sideMenuText">Dashboard</div>
            </a></li>
        <li class="divider n2" data-text="main">Main</li>
        <li><a href="#"><i class="fa-solid fa-shop icon"></i>
                <div class="sideMenuText">Take Orders</div>
            </a></li>
        <li><a href="#"><i class="fa-solid fa-boxes-packing icon"></i>
                <div class="sideMenuText">Order History</div>
            </a></li>
        <li><a href="#"><i class="fa-solid fa-face-smile-beam icon"></i>
                <div class="sideMenuText">Customer</div>
            </a></li>
        <li><a href="#"><i class="fa-solid fa-truck icon"></i>
                <div class="sideMenuText">Supplier</div>
            </a></li>
        <li><a href="#"><i class="fa-solid fa-cart-shopping icon"></i>
                <div class="sideMenuText">Purchased Orders</div>
            </a></li>
        <li><a class="" id="productnav" href="#"><i class="fa-solid fa-clipboard-list icon"></i>
                <div class="sideMenuText">Products</div><i class="fa-solid fa-angle-right icon-right "></i>
            </a>
            <ul class="side-dropdown" id="productnavsub">
                <li><a class="" href="#">
                        <div class="sideMenuText">Unit Management</div>
                    </a></li>
                <li><a href="#">
                        <div class="sideMenuText">Product List</div>
                    </a></li>
                <li><a class="" href="#">
                        <div class="sideMenuText">Category</div>
                    </a></li>
            </ul>
        </li>
        <li><a href="#"><i class="fa-solid fa-box-archive icon"></i>
                <div class="sideMenuText">Stock Management</div>
            </a></li>
        <li><a href="#"><i class='fa-solid fa-peso-sign icon'></i>
                <div class="sideMenuText">Price Management</div>
            </a></li>
        <li class="divider n3" data-text="reports">REPORTS</li>
        <li>
            <a class="" id="reportnav"><i class="fa-solid fa-chart-line icon"></i>
                <div class="sideMenuText">Report</div><i class="fa-solid fa-angle-right icon-right"></i>
            </a>
            </a>
            <ul class="side-dropdown" id="reportnavsub">
                <li><a href="#">
                        <div class="sideMenuText">Overall Inventory</div>
                    </a></li>
            </ul>
        </li>
        <li class="divider n4" data-text="users">USERS</li>
        <li><a class="{{ $path == 'accounts' ? 'active-selected' : '' }}" href="accounts"><i class="fa-solid fa-users icon "></i>
                <div class="sideMenuText ">Accounts</div>
            </a></li>
    </ul>


</section>
