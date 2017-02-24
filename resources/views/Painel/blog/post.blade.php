@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{{ asset('Painel/js/client/Headlines.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Painel/js/client/PhotoGallery.js') }}"></script>
@endsection

@section('content')
    <section class="block">
        <header>
            <div class="title">
                <span>Info do POST</span>
            </div>
            <div class="actions">
                <a href="{{  $reg->urlGoback }}" class="button purple waves-effect">Voltar para {{$reg->nameGoback}}</a>
                <a href="{{ $reg->siteUrl }}" class="button font-black light-blue waves-effect">Editar Post</a>
                <a href="#" onclick="document.forms['author'].submit()" class="button font-black green waves-effect">SALVAR</a>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            <form name="author" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="action" value="updateAuthor">
                <div class="w-33">
                    <label>
                        <span>Nome:</span>
                        {{--<input required="required" type="text" name="name" placeholder="Nome do interesse">--}}
                        <select required="required" name="author_id">
                            <option value="0">Sem Autor</option>
                            @foreach($authors as $at)
                                {{--{{ dd($at)  }}--}}
                                <?php $selected = ( $at->id == $reg->author_id ) ? 'selected="selected"' : '' ; ?>
                                <option {{$selected}} value="{{$at->id}}">{{$at->user->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="w-33">
                    <label>
                        <span>Tipo:</span>
                        {{--<input required="required" type="text" name="name" placeholder="Nome do interesse">--}}
                        <select required="required" name="post_type_id">
                            <option value="" disabled>Selecione o Tipo</option>
{{--                                {{ dd($postTypes)  }}--}}
                            @foreach($postTypes as $type)
                                <?php $selected = ( $type->id == $reg->post_type_id ) ? 'selected="selected"' : '' ; ?>
                                <option {{$selected}} value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="w-33">
                    <label>
                        <span>Status:</span>
                        <select required="required" name="status">
                            <option value="1">Ativo</option>
                            <option <?= (!$reg->getOriginal('status')) ? 'selected="selected"' : ''; ?> value="0">Inativo</option>
                        </select>
                    </label>
                </div>

                <div class="w-33">
                    <div class="cleaner"></div>
                    <div>PAÍS [{{$reg->polyinfo->breadcrumb['country']}}] <?= ( isset($reg->polyinfo->breadcrumb['city']) ) ? 'CIDADE ['.$reg->polyinfo->breadcrumb['city'].']' : '' ; ?></div>
                    {{--<div>Título: {{ dd($reg) }}</div>--}}
                    <div>Título: {{ $reg->managed_regions['article_title']['content'] }}</div>
                    <div>Criado em: {{ $reg->created_at }}</div>
                    <div>Atualizad em: {{ $reg->updated_at }}</div>
                </div>
                <div class="cleaner"></div>

                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="{{$reg->id}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>

        </section>
    </section>

    @include('Painel.shared.photogallery_form')

    @include('Painel.shared.searchtags_form')

    @include('Painel.shared.headline_form')

@endsection
