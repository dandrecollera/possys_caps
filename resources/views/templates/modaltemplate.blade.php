@php
    $bgColor = 'rgb(255, 255, 255)'; // Set the desired background color
@endphp

@extends('templates.mastertemplate')

@section('body')
    <div class="p-3">
        @yield('content')
    </div>
@endsection
