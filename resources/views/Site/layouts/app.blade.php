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
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script type="text/javascript" src="{!! asset('/Painel/js/lib/jquery/jquery-2.1.1.min.js')  !!}"></script>
    <script type="text/javascript" src="{!! asset('/Site/js/script.js')  !!}"></script>

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
