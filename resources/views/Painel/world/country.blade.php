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
            <div class="actions">
                <a href="#" class="button purple waves-effect submitter">deletar</a>
                <a href="#" class="button purple waves-effect submitter">editar</a>
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

    <section class="block">
        <header>
            <div class="title">
                <span>Cadastro e edição de Países</span>
            </div>
            <div class="actions">
                <a href="#" class="button purple waves-effect submitter" data-submitter="pais">criar</a>
            </div>
            <div class="cleaner"></div>
        </header>

        {{-- registro criado --}}
        @if( @isset($status) && $status )
            <div class="success">
            Legal, registro criado com sucesso!
            </div>
        @endif

        <section class="content">
            <form method="post" name="pais">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="w-50">
                    <label>
                        <span>continente:</span>
                        <select name="continents_id" data-placeholder="teste">
                            @foreach($continents as $cont)
                                <option value="{{ $cont->id }}">{{ $cont->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="w-50">
                    <label>
                        <span>Teste:</span>
                        <input name="teste" type="text">
                    </label>
                </div>

                <div class="cleaner"></div>

                <input type="hidden" name="action" value="store">

            </form>

            <form method="post" action="/painel/mundo/pais/info">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit">send</button>
            </form>
        </section>
    </section>

@endsection
