@extends('templates.mastertemplate')

@section('linkcss')
    <link href="{{ asset('css/azusidenavv2.css') }}?v=1" rel="stylesheet">
@endsection


@section('body')
    @include('components.sidemenuv2')
    @include('components.navbar')


    <div class="contentinit" id="mastercontent">
        @yield('content')
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const sidebartrigger = $('#sidebartrigger');
            const sidebar = $('#sidebar');
            const navbar = $('#main-navbar');

            function checkScreenSize() {
                if ($(window).width() < 768) {
                    sidebar.removeClass('hide');
                }
            }

            sidebartrigger.on('click', function() {
                sidebar.toggleClass('hide');
                navbar.toggleClass('navbarend');
                $('#mastercontent').toggleClass('contentend');
            });

            $('#productnav').on('click', function() {
                $('#productnav').toggleClass('active');
                $('#productnavsub').toggleClass('show');
            })

            $('#reportnav').on('click', function() {
                $('#reportnav').toggleClass('active');
                $('#reportnavsub').toggleClass('show');
            })

            $('#smallscreentoggler').on('click', function() {
                sidebar.toggleClass('togglersidenav');
            })

            $('#closesidenav').on('click', function() {
                sidebar.toggleClass('togglersidenav');
            })

            checkScreenSize();
        });
    </script>
@endpush
