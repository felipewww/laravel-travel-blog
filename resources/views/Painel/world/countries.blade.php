@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{!! asset('Painel/js/pages/estrutura/country.js') !!}"></script>
@endsection

@section('content')
    <section class="block">
        <header>
            <div class="title">
                <span>Listagem Países</span>
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
