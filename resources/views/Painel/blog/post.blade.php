@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{!! asset('Painel/js/pages/estrutura/country.js') !!}"></script>
@endsection

@section('content')
    <section class="block">
        <header>
            <div class="title">
                <span>Info do POST</span>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            Aqui vem as configurações do post [Nome do autor, views, comentários, SEO e SEARCH tags...]
        </section>
    </section>

@endsection
