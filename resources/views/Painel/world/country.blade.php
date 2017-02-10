@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{{ asset('Painel/js/pages/estrutura/country.js') }}"></script>
@endsection

@section('content')
{{--    {{dd($country)}}--}}
    <section class="block">
        <header>
            <div class="title">
                {{--<span>Informações do País: {{ $country['name'] }}</span>--}}
                <span>Informações do País: {{ $country->name }}</span>
            </div>
            <div class="actions">
                {{--<a href="#" class="button purple waves-effect submitter">deletar</a>--}}
                {{--<a href="#" class="button purple waves-effect submitter">editar</a>--}}
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            @foreach ($country as $key => $value)
{{--                <div>key: {{ $key  }} => {{ $value }} </div>--}}
{{--                <div>key: {{ $key }} => {{ $country->$$key  }} </div>--}}
                <div>key: {{ $key }} =>  </div>
            @endforeach
        </section>
    </section>

    <section class="block">
        <header>
            <div class="title">
                <span>Estados</span>
            </div>
            <div class="actions">
                {{--<a href="#" class="button purple waves-effect submitter">deletar</a>--}}
                {{--<a href="#" class="button purple waves-effect submitter">editar</a>--}}
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

    <section class="block" id="cidades">
        <header>
            <div class="title">
                <span>Cidades</span>
            </div>
            <div class="actions">
                {{--<a href="#" class="button purple waves-effect submitter">deletar</a>--}}
                {{--<a href="#" class="button purple waves-effect submitter">editar</a>--}}
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content" id="dynamic_table">
            Selecione um estado acima para carregar as cidades.
        </section>
    </section>
@endsection
