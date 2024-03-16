<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top navbarinit" id="main-navbar">
    <div class="container-fluid  ">
        <i class="fa-solid fa-bars fa-lg" id="sidebartrigger" style="cursor: pointer;"></i>

        <img id="navbarlogosub" src="{{ asset('img/logo.png') }}" alt="logo">
        <div class="btn-group shadow-0 d-none d-lg-block">
            <i class="fas fa-table-columns fa-fw me-3"></i>
            <i class="fas fa-table-columns fa-fw me-3"></i>
            <i class="fas fa-table-columns fa-fw me-3"></i>
            <a class="dropdown-toggle hidden-arrow pe-3" id="dropdownMenuButton" data-mdb-toggle="dropdown" type="button">
                @include('components.imagename')
            </a>
            <ul class="dropdown-menu">
                @include('components.usermenu')
            </ul>
        </div>

        <button class="navbar-toggler" id="smallscreentoggler" type="button">
            <i class="fas fa-bars" style="colr:white"></i>
        </button>

    </div>
</nav>
