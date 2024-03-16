<section class="hide" id="sidebar">
    <div id="closesidenav" style="position: absolute; right: 20px; top: 20px; font-size: 30px">
        <i class="fa-solid fa-xmark"></i>
    </div>
    <a class="logo" href="#">
        <img src="{{ asset('img/logo.png') }}" alt="logo">
        <h4>Sales and Inventory<br>Management System</h4>
    </a>


    <ul class="side-menu">
        <li class="divider n1" data-text="home">HOME</li>
        <li><a class="" href="#"><i class="fas fa-table-columns icon"></i>
                <div class="sideMenuText">Dashboard</div>
            </a></li>
        <li class="divider n2" data-text="main">Main</li>
        <li><a href="#"><i class="fas fa-table-columns icon"></i>
                <div class="sideMenuText">Take Orders</div>
            </a></li>
        <li><a href="#"><i class="fas fa-table-columns icon"></i>
                <div class="sideMenuText">Order History</div>
            </a></li>
        <li><a href="#"><i class="fas fa-table-columns icon"></i>
                <div class="sideMenuText">Customer</div>
            </a></li>
        <li><a href="#"><i class="fas fa-table-columns icon"></i>
                <div class="sideMenuText">Supplier</div>
            </a></li>
        <li><a href="#"><i class="fas fa-table-columns icon"></i>
                <div class="sideMenuText">Purchased Orders</div>
            </a></li>
        <li><a class="" id="productnav" href="#"><i class='fa-solid fa-peso-sign icon'></i>
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
        <li><a href="#"><i class="fas fa-table-columns icon"></i>
                <div class="sideMenuText">Stock Management</div>
            </a></li>
        <li><a href="#"><i class='fa-solid fa-peso-sign icon'></i>
                <div class="sideMenuText">Price Management</div>
            </a></li>
        <li class="divider n3" data-text="reports">REPORTS</li>
        <li>
            <a class="" id="reportnav"><i class='fa-solid fa-peso-sign icon'></i>
                <div class="sideMenuText">Report</div><i class="fa-solid fa-angle-right icon-right"></i>
            </a>
            </a>
            <ul class="side-dropdown" id="reportnavsub">
                <li><a href="#">
                        <div class="sideMenuText">Overall Inventory</div>
                    </a></li>
            </ul>
        </li>
    </ul>
</section>
