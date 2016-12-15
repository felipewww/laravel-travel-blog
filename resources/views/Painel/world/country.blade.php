@extends('Painel.layouts.app')

@section('content')
    <section class="block">
        <header>
            <div class="title">
                <span>Cadastro e edição de Países</span>
            </div>
            <div class="actions">
                <a href="#" class="button purple waves-effect">criar</a>
            </div>
            <div class="cleaner"></div>
        </header>


        <section class="content">
            <form method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="w-30">
                    <label>
                        <span>continente:</span>
                        <select name="continents_id" required="required" placeholder="teste">
                            @foreach($continents as $cont)
                                <option value="{{ $cont->id }}">{{ $cont->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="w-30">
                    <label>
                        <span>Test Input:</span>
                        <input type="text" name="name" placeholder="Nome do País">
                    </label>
                </div>

                <div class="w-20">
                    <label>
                        <span>Sigla do País:</span>
                        <input maxlength="2" type="text" name="sigla_2" placeholder="2 dígitos">
                    </label>
                </div>

                <div class="w-20">
                    <label>
                        <span>Sigla do País:</span>
                        <input maxlength="3" type="text" name="sigla_3" placeholder="3 dígitos">
                    </label>
                </div>
                <div class="cleaner"></div>

                <button type="submit">salvar</button>

            </form>
        </section>
    </section>

@endsection
