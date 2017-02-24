@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{{ asset('Painel/js/pages/estrutura/country.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Painel/js/client/Headlines.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Painel/js/client/PainelPosts.js') }}"></script>
@endsection

@section('content')
{{--    {{dd($country)}}--}}
    <section class="block">
        <header>
            <div class="title">
                <span>Informações do País: {{ $country->name }}</span>
            </div>
            <div class="actions">
                @if($reg->status)
                    <a href="#" onclick="document.forms['activeOrDeactive'].submit()" class="button light-red waves-effect">inativar</a>
                @else
                    <a href="#" onclick="document.forms['activeOrDeactive'].submit()" class="button font-black light-blue waves-effect">ativar</a>
                @endif
                <a href="/painel/mundo/pais/single/{{ $country->id }}" target="_blank" class="button font-black light-blue waves-effect">Editar Página</a>
                <form id="activeOrDeactive" class="hidden" method="post">
                    <input type="hidden" name="action" value="<?= ($reg->status) ? 'deactive' : 'active' ; ?>">
                    <input type="hidden" name="id" value="{{$reg->id}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            @foreach ($country->getAttributes() as $key => $value)
                <div>key: {{ $key }} => {{ $value }}  </div>
            @endforeach
        </section>
    </section>

    {{--@include('Painel.shared.posts_block')--}}

    @include('Painel.shared.headline_form')

    <section class="block">
        <header>
            <div class="title">
                <span>Estados</span>
            </div>
            <div class="actions">
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
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content" id="dynamic_table">
            Selecione um estado acima para carregar as cidades.
        </section>
    </section>
@endsection
