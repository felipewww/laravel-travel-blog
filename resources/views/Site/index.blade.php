@extends('Site.layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/Site/css/home.css">
    <script type="text/javascript" src="{{ asset('Site/js/modules/paginas/home.js') }}"></script>

    @if($isAdmin)
        <script type="text/javascript" src="/Painel/js/lib/jquery/chosen/chosen.jquery.js"></script>
        <script type="text/javascript" src="{{ asset('Painel/js/pages/paginas/home.js') }}"></script>
        <link rel="stylesheet" href="/Painel/js/lib/jquery/chosen/chosen.css">
    @endif

@endsection

@section('content')
    <div id="banner">
        aqui vem o fullbanner
    </div>

    @if($isAdmin)
        <div id="adminActions">
            <div id="edit" class="flaticon-settings"></div>
            <div id="save" class="flaticon-checked"></div>
        </div>

        <div id="cfgbox">
            <div class="arrow closed flaticon-keyboard-right-arrow-button"></div>
            <form name="getheadlines">

                <div class="searchBox">
                    <label for="posts">Posts</label>
                    <select id="posts" name="posts">
                        @foreach($posts as $post)
                            <option value="{{$post->id}}">{{$post->title}}</option>
                        @endforeach
                    </select>
                    <div class="searchBtn">filtrar</div>
                </div>

                <div class="searchBox">
                    <label for="countries">Paises</label>
                    <select id="countries" name="countries">
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                    <div class="searchBtn">filtrar</div>
                </div>

                <div class="searchBox">
                    <label for="cities">Cidades</label>
                    <select id="cities" name="cities">
                        @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                    <div class="searchBtn">filtrar</div>
                </div>
            </form>

            <div id="searchResults">
                {{--Conteúdo dinâmico de pesquisa dos headlines.--}}
            </div>
        </div>
    @endif

    <div id="content">

        <div id="region_1">
            <h1>Mundo</h1>

            @foreach($regions[1] as $hl)
            <div class="container-50 sortable {{ $hl->divClass ?: '' }}" id="{{ $hl->final_id }}">
                <div class="region">
                    <div class="img" style="background-image: url('{{ $hl->src }}')"></div>
                    <div class="title">{{ $hl->title }}</div>
                    <div class="content"> {{ $hl->content }} </div>
                </div>
            </div>
            @endforeach
        </div>

        <div id="region_2">
            <h1>Gastronomia</h1>

            @foreach($regions[2] as $hl)
                <div class="container-50 sortable {{ $hl->divClass ?: '' }}" id="{{ $hl->final_id }}">
                    <div class="region">
                        <div class="img" style="background-image: url({{ $hl->src }})"></div>
                        <div class="title">{{ $hl->title }}</div>
                        <div class="content"> {{ $hl->content }} </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="region_2">
            <h1>Dicas</h1>

            @foreach($regions[3] as $hl)
                <div class="container-50 sortable {{ $hl->divClass ?: '' }}" id="{{ $hl->final_id }}">
                    <div class="region">
                        <div class="img" style="background-image: url({{ $hl->src }})"></div>
                        <div class="title">{{ $hl->title }}</div>
                        <div class="content"> {{ $hl->content }} </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop