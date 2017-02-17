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
            <div class="actions">
                @if($reg->status == 'ativo')
                    <a href="#" onclick="document.forms['activeOrDeactive'].submit()" class="button light-red waves-effect">inativar</a>
                @else
                    <a href="#" onclick="document.forms['activeOrDeactive'].submit()" class="button font-black light-blue waves-effect">ativar</a>
                @endif
                    <a href="#" onclick="document.forms['author'].submit()" class="button font-black green waves-effect">Atualizar Autor</a>
                    <a href="{{  $reg->urlGoback }}" class="button purple waves-effect">Voltar para {{$reg->nameGoback}}</a>
                    <a href="{{ $reg->siteUrl }}" class="button font-black light-blue waves-effect">Editar Post</a>
                {{--{{dd($reg)}}--}}
                <form id="activeOrDeactive" class="hidden" method="post">
                    <input type="hidden" name="action" value="<?= ($reg->status == 'ativo') ? 'deactive' : 'active' ; ?>">
                    <input type="hidden" name="id" value="{{$reg->id}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            <form name="author" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="action" value="updateAuthor">
                <div class="w-30">
                    <label>
                        <span>Nome:</span>
                        {{--<input required="required" type="text" name="name" placeholder="Nome do interesse">--}}
                        <select required="required" name="author">
                            <option value="">Sem Autor</option>
                            @foreach($authors as $at)
                                {{--{{ dd($at)  }}--}}
                                <?php $selected = ( $at->id == $reg->author_id ) ? 'selected="selected"' : '' ; ?>
                                <option {{$selected}} value="{{$at->id}}">{{$at->user->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="w-70">
                    <div class="cleaner"></div>
                    <div>PAÍS [{{$reg->polyinfo->breadcrumb['country']}}] <?= ( isset($reg->polyinfo->breadcrumb['city']) ) ? 'CIDADE ['.$reg->polyinfo->breadcrumb['city'].']' : '' ; ?></div>
                    {{--<div>Título: {{ dd($reg) }}</div>--}}
                    <div>Título: {{ $reg->managed_regions['article_title']['content'] }}</div>
                    <div>Criado em: {{ $reg->created_at }}</div>
                    <div>Atualizad em: {{ $reg->updated_at }}</div>
                </div>
                <div class="cleaner"></div>
            </form>

        </section>
    </section>

    @include('Painel.shared.searchtags_form')

    @include('Painel.shared.headline_form')

@endsection
