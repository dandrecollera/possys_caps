@extends('templates.mastertemplate')

@section('body')
    <header>
        <nav class="collapse d-lg-block sidebar list-group-item" id="sideBarMenu">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    @include('components.sidemenu')

                    <div class="dropdown py-2 mx-2 mt-2 d-block d-lg-none">
                        <i class="fas fa-table-columns fa-fw me-3"></i>
                        <i class="fas fa-table-columns fa-fw me-3"></i>
                        <i class="fas fa-table-columns fa-fw me-3"></i>
                        <a class="nav-link dropdown-toggle hidden-arrow text-white text-small d-flex align-items-center" data-mdb-toggle="dropdown" href="#">
                            @include('components.imagename')
                        </a>
                        <ul class="dropdown-menu text-small shadow dropdown-menu-start">
                            @include('components.usermenu')
                        </ul>
                    </div>
                </div>
            </div>
        </nav>


        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top" id="main-navbar">
            <div class="container-fluid">
                <a class="navbar-brand fw-bolder ps-2 text-black" href="/">
                    <img alt="logo" height="95" src="{{ asset('img/logo.png') }}"><span class="logo-text">Sales and Inventory<br>Management System</span>
                </a>

                <div class="btn-group shadow-0 d-none d-lg-block">
                    <i class="fas fa-table-columns fa-fw me-3"></i>
                    <i class="fas fa-table-columns fa-fw me-3"></i>
                    <i class="fas fa-table-columns fa-fw me-3"></i>
                    <a class="dropdown-toggle hidden-arrow pe-3" data-mdb-toggle="dropdown" id="dropdownMenuButton" type="button">
                        @include('components.imagename')
                    </a>
                    <ul class="dropdown-menu">
                        @include('components.usermenu')
                    </ul>
                </div>

                <button class="navbar-toggler" data-mdb-target="#sideBarMenu" data-mdb-toggle="collapse" type="button">
                    <i class="fas fa-bars" style="colr:white"></i>
                </button>

            </div>
        </nav>

    </header>

    <main class="content-container">
        <div class="container pt-2 pt-lg-4">
            @yield('content')
        </div>
    </main>
@endsection
