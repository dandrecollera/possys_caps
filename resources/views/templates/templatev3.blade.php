@php
    $bgColor = 'rgb(248, 248, 248)'; // Set the desired background color
@endphp

@extends('templates.mastertemplate')

@section('linkcss')
    <link href="{{ asset('css/azusidenavv2.css') }}?v=3" rel="stylesheet">
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

            checkScreenSize();

            sidebartrigger.on('click', function() {
                sidebar.toggleClass('hide');
                navbar.toggleClass('navbarend');
                $('#mastercontent').toggleClass('contentend');

                if (sidebar.hasClass('hide')) {
                    if ($('#reportnav').hasClass('active')) {
                        $('#reportnav').toggleClass('active');
                        $('#reportnavsub').toggleClass('show');
                    }
                    if ($('#productnav').hasClass('active')) {
                        $('#productnav').toggleClass('active');
                        $('#productnavsub').toggleClass('show');
                    }
                }
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


            sidebar.on('mouseleave', function() {
                if (sidebar.hasClass('hide')) {
                    if ($('#reportnav').hasClass('active')) {
                        $('#reportnav').toggleClass('active');
                        $('#reportnavsub').toggleClass('show');
                    }
                    if ($('#productnav').hasClass('active')) {
                        $('#productnav').toggleClass('active');
                        $('#productnavsub').toggleClass('show');
                    }
                }
            })

        });
    </script>
@endpush
