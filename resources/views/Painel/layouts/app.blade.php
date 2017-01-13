<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pra Viajar') }}</title>

    <!-- Main Styles - DO NOT MOVE IT!!! -->
    <link rel="stylesheet" type="text/css" href="/Painel/css/default.css">
    <link rel="stylesheet" type="text/css" href="/Painel/css/icons/font/flaticon.css">

    <!-- DefaultLibs -->
        <!-- JQuery -->
        <script type="text/javascript" src="/Painel/js/lib/jquery/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="/Painel/js/lib/jquery/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="/Painel/js/lib/jquery/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="/Painel/js/lib/jquery/jquery-mask/jquery.mask.min.js"></script>
        <script type="text/javascript" src="/Painel/js/lib/jquery/jquery.maskMoney.min.js"></script>
        <script type="text/javascript" src="/Painel/js/lib/jquery/jquery-scrollbar/jquery.scrollbar.min.js"></script>
        <!-- JQuery -->

        <!-- JQuery DATATABLES -->
        {{--<link rel="stylesheet" type="text/css" href="/Painel/js/lib/jquery/datatables/DataTables-1.10.13/css/jquery.dataTables.css"/>--}}
        <link rel="stylesheet" type="text/css" href="/Painel/js/lib/jquery/datatables/AutoFill-2.1.3/css/autoFill.dataTables.min.css"/>
        <link rel="stylesheet" type="text/css" href="/Painel/js/lib/jquery/datatables/Buttons-1.2.4/css/buttons.dataTables.css"/>
        <link rel="stylesheet" type="text/css" href="/Painel/js/lib/jquery/datatables/KeyTable-2.2.0/css/keyTable.dataTables.css"/>
        <link rel="stylesheet" type="text/css" href="/Painel/js/lib/jquery/datatables/RowReorder-1.2.0/css/rowReorder.dataTables.css"/>
        <link rel="stylesheet" type="text/css" href="/Painel/js/lib/jquery/datatables/Select-1.2.0/css/select.dataTables.css"/>

        <script type="text/javascript" src="/Painel/js/lib/jquery/datatables/DataTables-1.10.13/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="/Painel/js/lib/jquery/datatables/AutoFill-2.1.3/js/dataTables.autoFill.js"></script>
        <script type="text/javascript" src="/Painel/js/lib/jquery/datatables/Buttons-1.2.4/js/dataTables.buttons.js"></script>
        <script type="text/javascript" src="/Painel/js/lib/jquery/datatables/KeyTable-2.2.0/js/dataTables.keyTable.js"></script>
        <script type="text/javascript" src="/Painel/js/lib/jquery/datatables/RowReorder-1.2.0/js/dataTables.rowReorder.js"></script>
        <script type="text/javascript" src="/Painel/js/lib/jquery/datatables/Select-1.2.0/js/dataTables.select.js"></script>
        <!-- JQuery DATATABLES -->

        <!-- sweet alert -->
        <link rel="stylesheet" href="/Painel/js/lib/sweetalert-master/dist/sweetalert.css">
        <script type="text/javascript" src="/Painel/js/lib/sweetalert-master/dist/sweetalert.min.js"></script>
        <!-- sweet alert -->

        <!-- materialize/waves -->
        <link rel="stylesheet" href="/Painel/js/lib/materialize/css/waves.css">
        <script type="text/javascript" src="/Painel/js/lib/materialize/js/materialize.min.js"></script>
        <!-- materialize/waves -->

        <!-- choosen -->
        <script type="text/javascript" src="/Painel/js/lib/jquery/chosen/chosen.jquery.js"></script>
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>--}}
        <link rel="stylesheet" href="/Painel/js/lib/jquery/chosen/chosen.css">
        <link rel="stylesheet" href="/Painel/js/lib/jquery/chosen/praviajar-ajustes.css">
        <!-- choosen -->
    <!-- ./DefaultLibs -->

    <!-- Client -->
    <link rel="stylesheet" href="/Painel/js/client/multaction.css">
    <script type="text/javascript" src="/Painel/js/client/Multaction.js"></script>

    <script type="text/javascript" src="/Painel/js/client/Tooltip.js"></script>
    <script type="text/javascript" src="/Painel/js/client/_Menu.js"></script>
    <script type="text/javascript" src="/Painel/js/client/_Forms.js"></script>
    <script type="text/javascript" src="/Painel/js/client/DataTablesExtensions.js"></script>
    <script type="text/javascript" src="/Painel/js/client/client.js"></script>
    <script type="text/javascript" src="/Painel/js/script.js"></script>
    <script>
        window.Laravel = '<?php echo json_encode(['csrfToken' => csrf_token()]); ?>';
    </script>

    @yield('header')
</head>
<body>
    <!-- JS tootlip -->
    <div id="tooltip">
        <div class="arrow"></div>
        <div class="tooltip-content"></div>
    </div>

    @include('Painel.shared.menu')

    <section id="content">

        <!-- Barra do topo -->
        <div id="top">
            <div class="title">
                <span class="modulo">@if( isset($modulo) ) {{$modulo}} @endif</span>
                <span class="description">@if( isset($pageDesc) ) {{$pageDesc}} @endif</span>
            </div>
            <div id="top-actions">
                <div class="actions">
                    <span class="button light-red"><a href="#">cancelar</a></span>
                    <span class="button light-blue"><a href="#">editar</a></span>
                </div>
            </div>
        </div>
        <!-- ./ Barra do topo -->

        <div id="page">
            @yield('content')
        </div>
    </section>

    <div class="cleaner"></div>
    <div id="loading">
        <div>
            <span>Aguarde. Registrando informações...</span>
            <!--        <img src="media/images/preload.gif">-->
        </div>
    </div>

    <!-- Scripts -->
    {{--<script src="/Painel/js/app.js"></script>--}}
</body>
</html>
