@extends('Painel.layouts.app')

@section('header')
    <script type="text/javascript" src="{{ asset('Painel/js/client/PhotoGallery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Painel/js/client/Headlines.js') }}"></script>
@endsection

@section('content')
    <style>
        #main_photo {
            height: 137px;
            margin: 0 auto;
            display: block;
            margin-bottom: 20px;
        }
    </style>
    <section class="block">
        <header>
            <div class="title">
                <span>
                @if($reg->id)
                    Informações do Serviço: {{$reg->title}}
                @else
                    Novo serviço
                @endif
                </span>
            </div>
            <div class="actions">
                {{--<a href="#" class="button light-blue font-black waves-effect submitter">post</a>--}}
                @if($reg->id)
                <a href="/painel/mundo/cidade/{{  $reg->City->id }}" class="button purple waves-effect">voltar para {{$reg->City->name}}</a>
                @endif
                <a onclick="document.getElementById('place_submit').click()" class="button font-black green waves-effect">salvar</a>
            </div>
            <div class="cleaner"></div>
        </header>

        <section class="content">
            <form name="place" method="post" enctype="multipart/form-data">
                <div class="w-25">
                    <label>
                        <span>Nome do Serviço</span>
                        <input required="required" maxlength="255" type="text" name="title" placeholder="Titulo" value="{{$reg->title}}">
                    </label>
                </div>

                <div class="w-25">
                    <label>
                        <span>Editoria/Explore</span>
                        <select required="required" name="editorials_id">
                            <option value="">Selecione uma Editoria</option>
                            @foreach($editorials as $ed)
                                <?php $selected = ($reg->editorials_id == $ed->id) ? 'selected="selected"' : ''; ?>
                                <option {{$selected}} value="{{$ed->id}}">{{$ed->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="w-25">
                    <label>
                        <span>Cidade</span>
                        <select <?php if( isset($disableSelectCity) ){ echo 'disabled="disabled"'; }; ?> required="required" name="cities_id">
                            <option value="">Selecione uma Cidade</option>
                            @foreach($cities as $city)
                                <?php $selected = ($reg->cities_id == $city->id) ? 'selected="selected"' : ''; ?>
                                <option {{$selected}} value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="w-25">
                    <label>
                        <span>Status</span>
                        <select <?php if( isset($disableSelectCity) ){ echo 'disabled="disabled"'; }; ?> required="required" name="status">
                            <option value="1">Ativo</option>
                            <option <?= (!$reg->status) ? 'selected="selected"': ''; ?> value="0">Inativo</option>
                        </select>
                    </label>
                </div>

                <div class="cleaner"></div>
                <div class="w-30">
                    <label>
                        <span>Foto Principal</span>
                        <input type="file" name="main_photo">
                        <img id="main_photo" src="/{{$reg->main_photo}}">
                    </label>
                </div>

                <div class="w-70">
                    <label>
                        <span>Conteúdo</span>
                        <textarea required="required" name="content" rows="10">{{$reg->content}}</textarea>
                    </label>
                </div>
                <div class="cleaner"></div>
                <input type="submit" class="hidden" id="place_submit">
                <input type="hidden" name="action" value="{{ ($action) }}">
                <input type="hidden" name="id" value="{{ $reg->id }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </section>
    </section>

    @if($reg->id)
        @include('Painel.shared.photogallery_form')
        @include('Painel.shared.searchtags_form')
        @include('Painel.shared.interests_form')
        @include('Painel.shared.headline_form')
    @endif

@endsection
