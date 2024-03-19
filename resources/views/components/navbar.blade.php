@php
    $logo = DB::table('systemsettings')->where('type', 'logo')->first();
    $title = DB::table('systemsettings')->where('type', 'title')->first();
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top navbarinit" id="main-navbar">
    <div class="container-fluid  ">
        <i class="fa-solid fa-bars fa-lg" id="sidebartrigger" style="cursor: pointer;"></i>

        <img id="navbarlogosub" src="{{ $logo->input }}" alt="logo" style="max-height: 95px;">
        <div class="btn-group shadow-0 d-none d-lg-block">
            <a href="#" style="text-decoration: none; color: black">
                <i class="fa-solid fa-bell me-3"></i>
            </a>
            <a href="#" style="text-decoration: none; color: black">
                <i class="fa-solid fa-message me-3"></i>
            </a>
            <a href="/settings" style="text-decoration: none; color: black">
                <i class="fa-solid fa-gear me-3"></i>
            </a>
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
