@extends('Painel.layouts.app')

@section('header')
    {{--<script type="text/javascript" src="{{ asset('Painel/js/pages/estrutura/city.js') }}"></script>--}}
@endsection

@section('content')
    <style>

    </style>
    <section class="block">
        <header>
            <div class="title">
                <span>Informações da Home: 1</span>
            </div>
            <div class="actions">
                {{--<a href="#" class="button light-blue font-black waves-effect submitter">post</a>--}}
                {{--<a href="#" class="button light-red waves-effect submitter">inativar post</a>--}}
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            content....
        </section>
    </section>

    <section class="block">
        <header>
            <div class="title">
                <span>Headlines</span>
            </div>
            <div class="actions">
                {{--<a href="#" class="button light-blue font-black waves-effect submitter">post</a>--}}
                {{--<a href="#" class="button light-red waves-effect submitter">inativar post</a>--}}
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
{{--            {{dd($headlines)}}--}}
            @foreach($headlines as $hl)
                <div>{{$hl['content']}}</div>
            @endforeach
        </section>
    </section>

    <section class="block">
        <header>
            <div class="title">
                <span>Headlines</span>
            </div>
            <div class="actions">
                {{--<a href="#" class="button light-blue font-black waves-effect submitter">post</a>--}}
                {{--<a href="#" class="button light-red waves-effect submitter">inativar post</a>--}}
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            {{--            {{dd($headlines)}}--}}
            @foreach($headlines as $hl)
                <div>{{$hl['content']}}</div>
            @endforeach
        </section>
    </section>
@endsection
