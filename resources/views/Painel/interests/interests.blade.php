@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{{ asset('Painel/js/pages/interesses/ints.js') }}"></script>
@endsection

@section('content')
    {{--{!! dd($data) !!}--}}
    <section class="block">
        <header>
            <div class="title">
                <span>Novo Interesse</span>
            </div>
            <div class="actions">
                <a href="#" class="button light-blue font-black waves-effect submitter">salvar</a>
                {{--<a href="#" class="button light-red waves-effect submitter">inativar post</a>--}}
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            <form>
                <div class="w-50">
                    <label>
                        <span>Nome:</span>
                        <input type="text" name="test" placeholder="Input de Teste">
                    </label>
                </div>

                <div class="w-50">
                    <label>
                        <span>Cor:</span>
                        <input type="text" name="test" placeholder="Input de Teste">
                    </label>
                </div>

                <div class="cleaner"></div>

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
