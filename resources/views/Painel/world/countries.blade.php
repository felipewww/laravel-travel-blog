@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{!! asset('Painel/js/pages/estrutura/country.js') !!}"></script>
@endsection

@section('content')
    <section class="block" data-closed="true">
        <header>
            <div class="title">
                <span>Países Ativos</span>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            <table class="setDataTables" id="active_cities">
                <tbody>
                {{--The HTML into this TR represents the setup info where JS get and configure this datatables.--}}
                <tr>
                    <td class="columns">{!! json_encode($activeCountries['data_cols']) !!}</td>
                    <td class="info">{!! json_encode($activeCountries['data_info']) !!}</td>
                </tr>
                </tbody>
            </table>
        </section>
    </section>

    <section class="block" data-closed="true">
        <header>
            <div class="title">
                <span>Cidades Ativas</span>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            <table class="setDataTables" id="active_cities">
                <tbody>
                {{--The HTML into this TR represents the setup info where JS get and configure this datatables.--}}
                <tr>
                    <td class="columns">{!! json_encode($activeCities['data_cols']) !!}</td>
                    <td class="info">{!! json_encode($activeCities['data_info']) !!}</td>
                </tr>
                </tbody>
            </table>
        </section>
    </section>

    <section class="block" data-closed="true">
        <header>
            <div class="title">
                <span>Todos os Países</span>
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
