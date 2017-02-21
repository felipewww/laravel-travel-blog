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
    <style>
        form[name="getheadlines"] div.container {
            padding: 20px;
            padding-top: 0px;
        }
        form[name="getheadlines"] div.container div.searchBox label {
            font-family: 'ubuntu';
            font-size: 13px;
            margin-bottom: 10px;
            display: block;
        }
        form[name="getheadlines"] div.container div.searchBox div.searchBtn {
            margin: 0px;
            margin-top: 15px;
            border-radius: 3px;
            text-transform: lowercase;
            font-size: 11px;
            font-family: 'ubuntu';
            padding: 10px 25px;
            float: right;
            background-color: rgba(0, 0, 0, 0);
            border: 1px solid rgba(230, 255, 171, 0.21);
            cursor: pointer;
            transition: all 0.3s;
        }
        form[name="getheadlines"] div.container div.searchBox div.searchBtn:hover {
            box-shadow: 0px 0px 10px rgba(227, 251, 181, 0.17);
        }


        /*div#from_opts > span{*/
            /*display: block;*/
            /*box-sizing: border-box;*/
            /*padding: 10px 0;*/
            /*text-align: center;*/
            /*background-color: rgb(1, 132, 148);*/
            /*font-family: ubuntu;*/
            /*font-size: 11px;*/
        /*}*/

        div#from_opts > div:hover {
            background-color: rgba(0, 172, 193, 0.9);
        }
        /*div#from_opts > div {*/
            /*width: 50%;*/
            /*float: left;*/
            /*box-sizing: border-box;*/
            /*padding: 25px;*/
            /*text-align: center;*/
            /*background-color: #00acc1;*/
            /*font-family: 'ubuntu';*/
            /*font-size: 12px;*/
            /*transition: all 0.4s;*/
            /*cursor: pointer;*/
        /*}*/
        div#from_opts > div {
            width: 25%;
            float: left;
            box-sizing: border-box;
            padding: 10px;
            text-align: center;
            background-color: #00acc1;
            font-family: 'ubuntu';
            font-size: 12px;
            transition: all 0.4s;
            cursor: pointer;
        }
    </style>
    <div id="banner">
        aqui vem o fullbanner
    </div>

    @if($isAdmin)
        <div id="adminActions">
            <div id="edit" class="flaticon-settings"></div>
            <div id="save" class="flaticon-checked"></div>
        </div>

        <div id="cfgbox">

            <div id="from_opts">
                {{--<span>Buscar chamadas de:</span>--}}
                <div>Posts</div>
                <div>Países</div>
                <div>Cidades</div>
                <div>Explore</div>
            </div>
            <div class="cleaner"></div>

            <div class="arrow closed flaticon-keyboard-right-arrow-button"></div>
            <form name="getheadlines">

                <div class="container">
                    <div class="searchBox">
                        <label for="posts">Posts</label>
                        <select id="posts" name="posts">
                            @foreach($posts as $post)
                                <option value="{{$post->id}}">{{$post->title}}</option>
                            @endforeach
                        </select>
                        <div class="searchBtn">pesquisar</div>
                    </div>

                    <div class="searchBox">
                        <label for="countries">Paises</label>
                        <select id="countries" name="countries">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                        <div class="searchBtn">pesquisar</div>
                    </div>

                    <div class="searchBox">
                        <label for="cities">Cidades</label>
                        <select id="cities" name="cities">
                            @foreach($cities as $city)
                                <option value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                        <div class="searchBtn">pesquisar</div>
                    </div>

                    <div class="searchBox">
                        <label for="place">Explore</label>
                        <select id="place" name="place">
                            @foreach($places as $place)
                                <option value="{{$place->id}}">{{$place->title}}</option>
                            @endforeach
                        </select>
                        <div class="searchBtn">pesquisar</div>
                    </div>
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