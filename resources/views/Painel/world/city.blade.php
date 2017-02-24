@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{{ asset('Painel/js/client/Headlines.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Painel/js/client/PainelPosts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Painel/js/pages/estrutura/city.js') }}"></script>
@endsection

@section('content')
    <section class="block">
        <header>
            <div class="title">
                <span>Informações da Cidade: {{ $reg['name'] }}</span>
            </div>
            <div class="actions">
                <a href="/painel/mundo/pais/{{$reg->estate->country->id}}" class="button purple waves-effect">voltar para {{ $reg->estate->country->name }}</a>
                <a target="_blank" href="/painel/mundo/cidade/single/{{$reg->id}}" class="button font-black light-blue waves-effect">Editar página da cidade</a>
                @if($reg->status)
                    <a href="#" onclick="document.forms['activeOrDeactive'].submit()" class="button light-red waves-effect">inativar</a>
                @else
                    <a href="#" onclick="document.forms['activeOrDeactive'].submit()" class="button font-black light-blue waves-effect">ativar</a>
                @endif
                <form id="activeOrDeactive" class="hidden" method="get">
                    <input type="hidden" name="action" value="<?= ($reg->status) ? 'deactive' : 'active' ; ?>">
                    <input type="hidden" name="id" value="{{$reg->id}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            @foreach ($reg->getAttributes() as $key => $value)
{{--                {{ dd($reg->estate->country->name)  }}--}}
                <div>key: {{ $key  }} => {{ $value }} </div>
                {{--<div>{{ $key  }} </div>--}}
            @endforeach
        </section>
    </section>

    @include('Painel.shared.posts_block')

    @include('Painel.shared.searchtags_form')

    @include('Painel.shared.interests_form')

    <section class="block" id="places">
        <header>
            <div class="title">
                <span>Lugares/Explore</span>
            </div>
            <div class="actions">
                <a target="_blank" href="/painel/servicos/servico/cidade/{{$reg->id}}" class="button green font-black waves-effect">criar lugar</a>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            @foreach($places as $place)
                <div class="w-33">
                    <a target="_blank" href="/painel/servicos/servico/{{$place->id}}">Editar</a>
                    <img src="/{{$place->main_photo}}">
                    <div>
                        <span>Título</span>
                        <span>{{$place->title}}</span>
                    </div>
                </div>
            @endforeach
            <div class="cleaner"></div>
        </section>
    </section>

    @include('Painel.shared.headline_form')

    <section class="block">
        <header>
            <div class="title">
                <span>Mapa</span>
            </div>
            <div class="actions">
                {{--<a href="#" class="button purple waves-effect submitter">deletar</a>--}}
                {{--<a href="#" class="button purple waves-effect submitter">editar</a>--}}
            </div>
            {{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZv5NhWhIUfc6EvvgzNqQAehqCMzV3UVw" async defer></script>--}}
            <div class="cleaner"></div>
        </header>

        <section class="content">
            <div id="map" style="height: 350px;"></div>
            <script>
                function initMap() {
                    var myLatLng = {lat: {{ $reg['lat'] }}, lng: {{ $reg['lng'] }} };

                    // Create a map object and specify the DOM element for display.
                    var map = new google.maps.Map(document.getElementById('map'), {
                        center: myLatLng,
                        scrollwheel: false,
                        zoom: 13
                    });

                    // Create a marker and set its position.
                    var marker = new google.maps.Marker({
                        map: map,
                        position: myLatLng,
                        title: 'Hello World!'
                    });
                }

            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZv5NhWhIUfc6EvvgzNqQAehqCMzV3UVw&callback=initMap" async defer></script>
        </section>
    </section>
@endsection
