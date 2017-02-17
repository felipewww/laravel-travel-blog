@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{{ asset('Painel/js/pages/interesses/ints.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('Painel/js/lib/jquery/colorpicker/css/colorpicker.css') }}">
    <script type="text/javascript" src="{{ asset('Painel/js/lib/jquery/colorpicker/js/colorpicker.js') }}"></script>
@endsection

@section('content')
    {{--{!! dd($data) !!}--}}
    <section class="block">
        <header>
            <div class="title">
                <span id="tituloBloco">Novo Interesse</span>
            </div>
            <div class="actions">
                <a onclick="ints.form.submit()" class="button light-blue font-black waves-effect">salvar</a>
                <a onclick="ints.cancelEdit()" id="cancelEdit" class="button light-orange font-black waves-effect" style="display: none;">cancelar</a>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            <form method="post" name="createOrUpdate">
                <div class="w-50">
                    <label>
                        <span>Nome:</span>
                        <input required="required" type="text" name="name" placeholder="Nome do interesse">
                    </label>
                </div>

                <div class="w-50">
                    <label>
                        <span>Cor:</span>
                        <input maxlength="7" required="required" type="text" name="color" style="color: #fff;" placeholder="Cor do Interesse">
                    </label>
                </div>

                <div class="cleaner"></div>
                <input type="hidden" name="action" value="create">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>

            <form class="hidden" method="post" id="interest-delete-form">
                <input type="hidden" name="id" value="0">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>

        </section>
    </section>

    <section class="block">
        <header>
            <div class="title">
                <span>Interesses</span>
            </div>
            <div class="actions">
                {{--<a href="#" class="button light-blue font-black waves-effect submitter">post</a>--}}
                {{--<a href="#" class="button light-red waves-effect submitter">recarregar</a>--}}
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            <table class="setDataTables" id="countries">
                <tbody>
                {{--The HTML into this TR represents the setup info where JS get and configure this datatables.--}}
                <tr>
                    <td class="columns">{!! $dataTables_columns !!}</td>
                    <td class="info">{!! $dataTables_info !!}</td>
                </tr>
                </tbody>
            </table>
        </section>
    </section>
@endsection
