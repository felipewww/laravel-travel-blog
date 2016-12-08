@extends('auth.layouts.app')

@section('content')
    <div id="LoginPage">
        <div class="content">
            <div class="logo"><img src="/Site/media/images/praviajar-logo.png"></div>
            <form role="form" method="POST" action="{{ url('auth/login') }}">
                {{ csrf_field() }}

                <input placeholder="Seu Login" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                <input placeholder="Sua Senha" id="password" type="password" class="form-control" name="password" required>
                <label class="remember">
                    <input type="checkbox" name="remember"> Manter Conectado
                </label>
                <button type="submit">
                    Login
                </button>

                <a class="btn btn-link" href="{{ url('/auth/reset') }}">
                    Forgot Your Password?
                </a>
            </form>
        </div>
    </div>
@endsection
