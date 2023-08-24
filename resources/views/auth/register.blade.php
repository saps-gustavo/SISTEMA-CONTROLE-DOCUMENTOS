@extends('layouts.login')

@section('content')
<div class="container">

    @include('layouts._includes.loading')

    <div class="row alinha-center">
        <div class="card hoverable">
            <div class="card-content">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <img src="/assets/imagens/cadastro-doador-logo-pjf.png" class="responsive-img" />
                        @if(isset($_GET['sucesso']))
                            <h5><p align="center">Parabéns!</center></h5>
                        @else
                            <h5><p align="center">Cadastro de Doador(a)</center></h5>
                        @endif
                        <br>
                        <div class="panel-body">
                            @if(isset($_GET['sucesso']))
                            <div class="row">
                                <div class="input-field col s12 m12 l12">
                                    Seu cadastro foi realizado com sucesso!
                                    <br><br>
                                    Acesse o link enviado por e-mail para liberar o acesso.
                                    <br><br>
                                    Caso não receba o e-mail ou tenha qualquer outro problema, entre em contato conosco:
                                    <br><br>
                                    <li>E-mail: <b>sedh@pjf.mg.gov.br</b></li>
                                    <li>Telefone: <b>(32) 3690-7331</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-4 center">
                                    <a href="/login" class="btn btn-primary">Ir para Login</a>
                                </div>
                            </div>
                            @else
                            <form class="form-horizontal" id="form-cadastro" role="form" method="POST" action="{{ route('cadastrar') }}">
                                {{ csrf_field() }}
                                <!-- ERROS -->
                                @if ($errors->any())
                                    <div class="row">
                                        <div class="input-field col m12 l12 s12">
                                            <div class="card-panel red lighten-2">
                                                <span class="card-title white-text">A gravação do registro apresentou os seguintes problemas:</span>
                                                @foreach ($errors->all() as $error)
                                                    <span class=" white-text">{{ $error }}</span><br>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="input-field col s12 m9 l8">
                                        <input id="desc_entidade" type="text" name="desc_entidade" value="{{ old('desc_entidade') }}" tabindex="1" maxlength="50" autofocus>
                                        <label for="desc_entidade" class="" id="label-descricao-nome">Descrição (*)</label>
                                    </div>
                                    <div class="select-field col s12 m3 l4">
                                        <label for="id_tipo_pessoa" class="">
                                            Pessoa (*) 
                                            <select id="id_tipo_pessoa" name="id_tipo_pessoa" tabindex="1" autofocus>
                                                <option value="" selected>Selecione uma Opção</option>
                                                @foreach(App\Models\TipoPessoa::all() as $item)
                                                    <option value="{{ $item->id_tipo_pessoa }}" 
                                                        @if(old('id_tipo_pessoa') == $item->id_tipo_pessoa)
                                                            selected
                                                        @endif
                                                    >{{$item->desc_tipo_pessoa}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m6 l4" id="html_cpf_cnpj">
                                        <input id="cpf_cnpj" type="text" name="cpf_cnpj" value="{{ old('cpf_cnpj') }}" tabindex="1" maxlength="18" autofocus>
                                        <label for="cpf_cnpj" id="label_cpf_cnpj">CPF/CNPJ (*)</label>
                                    </div>
                                    <div class="input-field col s12 m6 l8" id="div-profissao">
                                        <input id="profissao" type="text" name="profissao" value="{{ old('profissao') }}" tabindex="1" maxlength="50" autofocus>
                                        <label for="profissao" class="">Profissão</label>
                                    </div>
                                    <div class="input-field col s12 m6 l8" id="div-responsavel">
                                        <input id="responsavel" type="text" name="responsavel" value="{{ old('responsavel') }}" tabindex="1" maxlength="50" autofocus>
                                        <label for="responsavel" class="">Responsável (*)</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m8 l8">
                                        <input id="email" type="text" name="email" value="{{ old('email') }}" tabindex="1" maxlength="50" autofocus>
                                        <label for="email" class="">E-mail (*)</label>
                                    </div>
                                    <div class="input-field col s12 m4 l4">
                                        <input id="celular" class="celular-dd-num" type="text" name="celular" value="{{ old('celular') }}" tabindex="1" maxlength="14" autofocus>
                                        <label for="celular" class="">Celular</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m3 l3">
                                        <input id="cep" class="cep" type="text" name="cep" onblur="BuscaCEP();" value="{{ old('cep') }}" tabindex="1" maxlength="9" autofocus>
                                        <label for="cep" class="">CEP</label>
                                    </div>
                                    <div class="input-field col s12 m9 l9">
                                        <input id="rua" type="text" name="rua" value="{{ old('rua') }}" tabindex="1" maxlength="50" autofocus>
                                        <label for="rua" class="">Rua</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m3 l3">
                                        <input id="numero" type="text" name="numero" value="{{ old('numero') }}" tabindex="1" maxlength="10" autofocus>
                                        <label for="numero" class="">Número</label>
                                    </div>
                                    <div class="input-field col s12 m3 l3">
                                        <input id="complemento" type="text" name="complemento" value="{{ old('complemento') }}" tabindex="1" maxlength="15" autofocus>
                                        <label for="complemento" class="">Complemento</label>
                                    </div>
                                    <div class="select-field col s12 m6 l6">
                                        <label for="id_bairro" class="">
                                            Bairro (*) 
                                            <select id="id_bairro" name="id_bairro" tabindex="1" autofocus>
                                                <option value="" selected>Selecione uma Opção</option>
                                                @foreach(App\Models\Bairro::all() as $item)
                                                    <option value="{{ $item->id_bairro }}" 
                                                        @if(old('id_bairro') == $item->id_bairro)
                                                            selected
                                                        @endif
                                                    >{{$item->desc_bairro}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="select-field col s12 m12 l12">
                                        <label for="id_tipo_entidade" class="">
                                            Tipo (*) 
                                            <select id="id_tipo_entidade" name="id_tipo_entidade" tabindex="1" autofocus>
                                                <option value="" selected>Selecione uma Opção</option>
                                                @foreach(App\Models\TipoEntidade::where('id_tipo_entidade_utilizacao', 2)->get() as $item)
                                                    <option value="{{ $item->id_tipo_entidade }}" 
                                                        @if(old('id_tipo_entidade') == $item->id_tipo_entidade)
                                                            selected
                                                        @endif
                                                    >{{$item->desc_tipo_entidade}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="select-field col s12 m6 l6">
                                        <label for="senha">Senha</label>
                                        <input id="senha" type="password" class="form-control" name="senha" maxlength="10" required>
                                    </div>
                                    <div class="select-field col s12 m6 l6">
                                        <label for="senha_confirmacao">Confirmar Senha</label>
                                        <input id="senha_confirmacao" type="password" class="form-control" name="senha_confirmacao" maxlength="10" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 m12 l12">
                                        <p>
                                            <label>
                                                <input type="checkbox" id="notificacao" name="notificacao" class="filled-in" value="1" />
                                                <span>Deseja receber notificações por e-mail sobre necessidades de doações em sua região?</span>
                                            </label>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-4 center">
                                        <button type="submit" class="btn btn-primary">
                                            Cadastrar
                                        </button>
                                        <a href="/login" class="btn grey waves-effect waves-green">Voltar</a>
                                    </div>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_css')
	@include('css.jquery-confirm')
    <style>
        html {
            display: block;
            margin: auto;
        }
        body {
            display: block;
        }
        .card {
            max-width: 600px;
        }
        .alinha-center{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
@endsection

@section('scripts_login')

    @include('sedh.doador.scripts.funcoes')
    @include('scripts.jquery-confirm')
    @include('scripts.material_select')
    @include('scripts.mascaras')
    @include('scripts.inicializa_modal')

    <script>
        $("#div-loading-body").hide();
    </script>
    <script>
		$(document).ready(function() {
			$('#form-cadastro').submit(function() {
				$("#div-loading-body").show();
			});
		});
	</script>
@endsection
