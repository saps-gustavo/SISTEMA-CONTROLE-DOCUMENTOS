@extends('layouts.login')

@section('content')
            
    <div id="login-page" class="row">
        @if (env('AMBIENTE')=='TESTE')
            <div class="card-panel red">
                <span class="white-text">
                    <p align="center"><h4>AMBIENTE DE TESTE</h4></p>
                </span>
            </div>
        @endif
        <div class="card-panel" id="panel-login">
            <div class="row">
                <div class="input-field col s12 center">
                    <img src="/assets/imagens/logo.png" alt="" class="responsive-img">
                    <br><br>
                    <div class="center login-form-text">Bem-vindo(a) ao {{config('app.name') }} {{config('app.surname') }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <form class="login-form" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="row margin">
                        <div class="input-field col s12" id="div-tipo">
                            @if((int)old('email') == 0)
                                <i class="material-icons prefix">person</i>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                                <label for="email">E-mail</label>
                            @else
                                <i class="material-icons prefix">credit_card</i>
                                <input id="email" type="text" onkeypress="return isNumber(event)" name="email" value="{{ old('email') }}" required>
                                <label for="email">CPF</label>
                            @endif
                        </div>
                    </div>
                    <div class="row margin">
                        <div class="col s12 center">
                            @if ($errors->has('email'))
                            <span class="red-text">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row margin">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">lock</i>
                            <input id="password" type="password" name="password" autocomplete="off" required>
                            <label for="password">Senha</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            @if ($errors->has('password'))
                            <span class="red-text">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col s12 center">
                                <button type="submit" class="btn btn-primary">
                                    Entrar
                                </button>
                                <a href="/login" class="btn grey waves-effect waves-green">Limpar</a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="row center">
                <a class="teal-text" href="{{ route('auth.password.email') }}">Esqueci minha senha </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts_login')
    @include('scripts.inicializa_modal')
	@include('scripts.jquery-confirm')
    @include('scripts.material_select')
    @include('scripts.mascaras')

@endsection
