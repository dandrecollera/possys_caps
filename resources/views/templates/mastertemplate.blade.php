<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>{{ env('WEB_TITLE', 'Fetch Error ENV') }}</title>

    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/azustyle.css') }}" rel="stylesheet">

    <script src="https://kit.fontawesome.com/55faa7e024.js" crossorigin="anonymous"></script>


    @yield('linkcss')
</head>

<body>

    @yield('body')



    <script src="{{ asset('js/mdb.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
