<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pra Viajar') }}</title>

    <link rel="stylesheet" type="text/css" href="/Site/css/default.css">
    <script type="text/javascript" src="{!! asset('/Painel/js/lib/jquery/jquery-2.1.1.min.js')  !!}"></script>
    @if($isAdmin)
        <script type="text/javascript" src="/Painel/js/lib/jquery/jquery-ui/jquery-ui.min.js"></script>
        <script>window.Laravel = JSON.parse('<?php echo json_encode(['csrfToken' => csrf_token()]); ?>');</script>
        <link rel="stylesheet" type="text/css" href="/Painel/css/icons/font/flaticon.css">
    @endif

    <!-- sweet alert -->
    <link rel="stylesheet" href="/Painel/js/lib/sweetalert-master/dist/sweetalert.css">
    <script type="text/javascript" src="/Painel/js/lib/sweetalert-master/dist/sweetalert.min.js"></script>
    <!-- sweet alert -->

    <!-- Scripts -->
    <script type="text/javascript" src="/Painel/js/lib/jquery/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="{!! asset('/Site/js/Client.js')  !!}"></script>
    <script type="text/javascript" src="{!! asset('/Painel/js/script.js')  !!}"></script>
    @if(\Illuminate\Support\Facades\Auth::check())
        <script type="text/javascript" src="{!! asset('/js/Admin.js')  !!}"></script>
    @endif
    @if( isset($json_meta) )
        <meta name="screen-json" content="{{ $json_meta }}">
    @endif
    @yield('adminScript')
    @yield('header')
</head>
<body>
    <nav id="menu">
        <ul>
            <li>home</li>
            <li>blog</li>
            <li>destinos</li>
            <li>fale conosco</li>
        </ul>
    </nav>
    @yield('content')
    <!-- Scripts -->
    {{--<script src="/js/app.js"></script>--}}
</body>
</html>
