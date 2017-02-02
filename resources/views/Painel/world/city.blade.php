@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{{ asset('Painel/js/pages/estrutura/city.js') }}"></script>
@endsection

@section('content')
    <style>
        form[name="interests"] > div {
            float: left;
            width: 30%;
            margin-bottom: 10px;
            cursor: pointer;
            margin-right: 3%;
            box-sizing: border-box;
            transition: all 0.4s;
        }

        form[name="interests"] > div:hover {
            background: rgba(0, 0, 0, 0.2);
        }
        form[name="interests"] > div input {
            float: right;
        }
        form[name="interests"] > div label {
            float: left;
            padding: 0;
            width: 80%;
            border: none;
            border-radius: 0;
        }
    </style>
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
                {{--<div>key: {{ $key  }} => {{ $value }} </div>--}}
                <div>{{ $key  }} </div>
            @endforeach
        </section>
    </section>

    <section class="block" id="cidades">
        <header>
            <div class="title">
                <span>Posts</span>
            </div>
            <div class="actions">
                {{--<a href="javascript:city.painel.tags();" class="button light-blue font-black waves-effect">salvar</a>--}}
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            @foreach($posts as $post)
                <div class="w-50 inside">
                    <form>
                        <div class="w-50">Título: {{ $post->managed_regions['article_title']['content'] }}</div>
                        <div class="w-50">status: {{ $post->status }}</div>
                        <div class="w-50">Por: <strong>{!! $post->author['name'] !!}</strong></div>

                        <div class="w-100 ">
                            <ul class="multaction">
                                <li data-tooltip-str="Editar" class="hasTooltip flaticon-fountain-pen">
                                    <a target="_blank" href="/painel/blog/post/cidade/{{$post->id}}"></a>
                                </li>

                                @if($post->status == 'ativo')
                                    <li data-tooltip-str="Inativar" class="hasTooltip flaticon-warning" onclick="home.teste(137)"><!-- inactive --></li>
                                @else
                                    <li data-tooltip-str="Ativar" class="hasTooltip flaticon-checked" onclick="city.verifyAuthorAndActive('{{$post->id}}', '{{$post->author_id}}')"><!-- active --></li>
                                @endif
                                {{--<li data-tooltip-str="Excluir" class="hasTooltip flaticon-rubbish-bin"><!-- delete --></li>--}}
                                <li data-tooltip-str="Configurações" class="hasTooltip flaticon-expand">
                                    <a href="/painel/blog/post/{{$post->id}}"></a>
                                </li>
                            </ul>
                        </div>

                        <input type="hidden" name="id" value="1033">
                        <div class="cleaner"></div>
                    </form>
                </div>
            @endforeach
            <div class="cleaner"></div>
        </section>
    </section>

    <section class="block" data-closed="true" id="cidades">
        <header>
            <div class="title">
                <span>Tags de Pesquisa</span>
            </div>
            <div class="actions">
                <a href="javascript:city.painel.tags();" class="button light-blue font-black waves-effect">salvar</a>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            <form name="tags" method="post" action="/painel/api/mundo/cidade/{{$city['id']}}">
                <div class="w-50">
                    <label>
                        <span>Site</span>
                        <input maxlength="255" type="text" name="system" placeholder="Tags para pesquisa no site" value="{{ $city['search_tags']  }}">
                    </label>
                </div>

                <div class="w-50">
                    <label>
                        <span>SEO</span>
                        <input maxlength="255" type="text" name="seo" placeholder="Tags para SEO" value="{{ $city['seo_tags']  }}">
                    </label>
                </div>
                <div class="cleaner"></div>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

            </form>
        </section>
    </section>

    <section class="block" id="cidades">
        <header>
            <div class="title">
                <span>Interesses</span>
            </div>
            <div class="actions">
                <a href="javascript:city.painel.interest();" class="button light-blue font-black waves-effect">salvar</a>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            <form name="interests" method="post" action="/painel/api/mundo/cidade/{{$city['id']}}">
                @foreach($allInterests as $int)
                    <div>
                        <label data-notconfigure="true" for="int_{{ $int->id }}" data-color="{{ $int->color }}">{{ $int->name }}
                        </label>
                        <input {{ $int->checked  }} id="int_{{ $int->id }}" type="checkbox" name="ints[]" value="{{ $int->id }}">
                    </div>
                @endforeach
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
            <div class="cleaner"></div>
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

        <section class="content">
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
