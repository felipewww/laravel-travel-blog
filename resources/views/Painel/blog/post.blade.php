@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{{ asset('Painel/js/client/Headlines.js') }}"></script>
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

    <section class="block" id="headlines_box">
        <header>
            <div class="title">
                <span>Headlines</span>
            </div>
            <div class="actions">
                <a onclick="Script._dynclick(this, 'submit_headlines')" class="button light-blue font-black waves-effect">salvar</a>
                <a href="javascript:headlines.addHeadLine();" class="button light-blue font-black waves-effect">novo</a>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            {{--<form id="headlines" name="headlines" method="post" enctype="multipart/form-data" action="/painel/mundo/cidade/{{$city['id']}}">--}}
            <form id="headlines" name="headlines_form" method="post" enctype="multipart/form-data" action="#headlines_box">


                <input type="hidden" name="createHeadlines">

                @foreach($headlines as $hl)
                    <div id="headline_{{$hl->id}}" class="w-50">
                        <div class="actions">
                            <span onclick="headlines.deleteHeadline({{$hl->id}})">excluir</span>
                        </div>

                        <div class="headline_img" style="background-image: url(/{{$hl->src}});">
                            {{--<img src="/{{$hl->src}}">--}}
                        </div>
                        <label>
                            <span>Headline img</span>
                            <input type="file" name="hl[{{$hl->id}}][img]">
                        </label>
                        <label>
                            <span>Headline Title</span>
                            <input type="text" name="hl[{{$hl->id}}][title]" placeholder="{{$hl->title}}">
                        </label>
                        <label>
                            <span>Headline text</span>
                            <input type="text" name="hl[{{$hl->id}}][text]" placeholder="{{$hl->content}}">
                        </label>
                    </div>
                @endforeach

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input id="submit_headlines" type="submit" value="enviar">
            </form>
            <div class="cleaner"></div>
        </section>
    </section>

@endsection
