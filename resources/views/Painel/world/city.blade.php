@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{{ asset('Painel/js/pages/estrutura/country.js') }}"></script>
@endsection

@section('content')
    <section class="block">
        <header>
            <div class="title">
                <span>Informações da Cidade: {{ $city['name'] }}</span>
            </div>
            <div class="actions">
                <a href="#" class="button light-blue font-black waves-effect submitter">post</a>
                <a href="#" class="button light-red waves-effect submitter">inativar post</a>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            @foreach ($city as $key => $value)
                <div>key: {{ $key  }} => {{ $value }} </div>
            @endforeach
        </section>
    </section>

    <section class="block" data-closed="true" id="cidades">
        <header>
            <div class="title">
                <span>SEO e Pesquisa</span>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content" id="dynamic_table">
            Carregar Interesses
        </section>
    </section>

    <section class="block" data-closed="true" id="cidades">
        <header>
            <div class="title">
                <span>Interesses</span>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content" id="dynamic_table">
            Carregar Interesses
        </section>
    </section>

    <section class="block" id="cidades">
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

        <section class="content" id="dynamic_table">
            <div id="map" style="height: 350px;"></div>
            <script>
                function initMap() {
                    var myLatLng = {lat: {{ $city['lat'] }}, lng: {{ $city['lng'] }} };

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
