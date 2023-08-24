@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row">
        <div class="card hoverable">
            <div class="card-content">
                <div class="col-md-8 col-md-offset-2 center">
                    <div class="panel panel-default">
                        <img src="/assets/imagens/logo.png" class="responsive-img" />
                        <h5><p align="center">Resetar Senha</center></h5>
                        <br>
                        <p>
                            Informe o e-mail cadastrado para a recuperação de senha.
                        </p>
                        <br><br>
                        <div class="panel-body">
                            @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                            @endif
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col m12 sl2 l2 control-label">E-Mail (*)</label>
                                    <div class="col m12 s12 l12">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif

                                        @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-alert">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col m12 s12 l12">
                                        <button class="btn btn-primary g-recaptcha" 
                                        data-sitekey="6LcC3pQjAAAAADbpUse46XxnXMpfQor-JAq2Q9wp"
                                        data-callback="onSubmit"
                                        >
                                        Enviar
                                        </button>
                                        <a href="/login" class="btn grey waves-effect waves-green">Voltar</a>
                                        <br><br>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_css')
	
@endsection

@section('scripts_login')
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <script> 
    
        //submete o formulário manualmente / requisito do recaptcha
        function onSubmit(token)
        {
            $('button').prop('disabled','disabled');
            $('form').submit();
        }      
        
        
    </script>
@endsection
