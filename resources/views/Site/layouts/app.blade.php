<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pra Viajar') }}</title>

    <!-- Scripts -->
    <script>
        window.Laravel = { csrf_token: '<?= csrf_token() ?>' };
    </script>
    <script type="text/javascript" src="{!! asset('/Painel/js/lib/jquery/jquery-2.1.1.min.js')  !!}"></script>
    <script type="text/javascript" src="{!! asset('/Site/js/Client.js')  !!}"></script>
    <script type="text/javascript" src="{!! asset('/Painel/js/script.js')  !!}"></script>
    @if(\Illuminate\Support\Facades\Auth::check())
        <script type="text/javascript" src="{!! asset('/js/Admin.js')  !!}"></script>
    @endif
    <link rel="stylesheet" type="text/css" href="{!! asset('/Site/css/default_single.css') !!}">
    @if( isset($json_meta) )
        <meta name="screen-json" content="{{ $json_meta }}">
    @endif
    @yield('adminScript')
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
