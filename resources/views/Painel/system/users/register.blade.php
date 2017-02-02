@extends('Painel.layouts.app')

@section('header')
<script type="text/javascript" src="{{ asset('Painel/js/pages/system/users.js') }}"></script>
@endsection

@section('content')

    <style>
        .photo-table {
            width: 40px;
            height: 40px;
            background-size: 100%;
            background-position: 50%;
            border-radius: 25px;
        }

        a.is_autor {
            color: #8dbaff;
        }
    </style>
    @if( isset($created) )
{{--        {{ dd($created) }}--}}
        @endif
<section class="block">
    <header>
        <div class="title">
            <span>Cadastro de usuário</span>
        </div>
        <div class="actions">
            <a href="javascript:document.forms['user'].submit();" class="button light-blue font-black waves-effect">salvar</a>
        </div>
        <div class="cleaner"></div>
    </header>

    <section class="content">
        <form name="user" method="post">

            <div class="w-25">
                <label>
                    <span>Nome</span>
                    <input maxlength="255" type="text" name="name" placeholder="Nome e sobrenome">
                </label>
            </div>

            <div class="w-25">
                <label>
                    <span>E-mail</span>
                    <input maxlength="255" type="text" name="email" placeholder="{{'email@dominio.com'}}">
                </label>
            </div>

            <div class="w-25">
                <label>
                    <span>Senha</span>
                    <input maxlength="255" type="text" name="password" placeholder="Senha">
                </label>
            </div>

            <div class="w-25">
                <label>
                    <span>Tipo</span>
                    <select name="type">
                        <option value="admin">admin</option>
                        <option value="system" selected="selected">usuário</option>
                        <option value="author">autor</option>
                    </select>
                </label>
            </div>
            <div class="cleaner"></div>

            <input type="hidden" name="id">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </section>
</section>

<section class="block">
    <header>
        <div class="title">
            <span>Cadastro de usuário</span>
        </div>
        <div class="cleaner"></div>
    </header>

    <section class="content">
        <table class="setDataTables" id="countries">
            <tbody>
                <tr>
                    <td class="columns">{!! $dataTables_columns !!}</td>
                    <td class="info">{!! $dataTables_info !!}</td>
                </tr>
            </tbody>
        </table>
    </section>
</section>

{{--<div class="container">--}}
    {{--<div class="row">--}}
        {{--<div class="col-md-8 col-md-offset-2">--}}
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading">Register</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<form class="form-horizontal" role="form" method="POST" action="{{ url('/painel/register') }}">--}}
                        {{--{{ csrf_field() }}--}}

                        {{--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">--}}
                            {{--<label for="name" class="col-md-4 control-label">Name</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>--}}

                                {{--@if ($errors->has('name'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('name') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
                            {{--<label for="email" class="col-md-4 control-label">E-Mail Address</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>--}}

                                {{--@if ($errors->has('email'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">--}}
                            {{--<label for="password" class="col-md-4 control-label">Password</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="password" type="password" class="form-control" name="password" required>--}}

                                {{--@if ($errors->has('password'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<div class="col-md-6 col-md-offset-4">--}}
                                {{--<button type="submit" class="btn btn-primary">--}}
                                    {{--Register--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
@endsection
