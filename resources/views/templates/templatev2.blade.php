@extends('templates.mastertemplate')

@section('linkcss')
    <link href="{{ asset('css/azusidenav.css') }}" rel="stylesheet">
@endsection


@section('body')
    @include('components.sidemenuv2')
@endsection

@push('scripts')
@endpush
