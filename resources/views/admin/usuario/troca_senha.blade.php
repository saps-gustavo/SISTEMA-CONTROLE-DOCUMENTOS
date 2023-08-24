
@extends('layouts.app')

@section('conteudo')

	{{-- Breadcrumb --}}
	@section('breadcrumb')
	    <a class="breadcrumb" href="{{url('/')}}">{{ $titulo }}</a>
	    <a class="breadcrumb">{{ $subtitulo }}</a>
        @include('layouts._includes.home.notificacoes')
	@endsection

    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card hoverable">
                <div class="card-content">
                    <div class="row">
						<div class="col s12">
					        <span class="card-title grey-text text-darken-3">Alterar Senha</span>
                			<hr class="linha-cinza">
                        </div>
                    </div>
                    <div class="row">
                        <form class="col s12" action="{{ route('admin.usuario.trocarSenha') }}" method="post">
                        {{ csrf_field() }}
                            <div class="row">
                                <div class="col s12">
                                    <span id="topform-error" class="help-alert"></span>
                                </div>
                            </div>
                            <input type="hidden" value="{{$registro->id_usuario}}" name="id_hidden">

                             <div class="row">
                                <div class="input-field col m12">
                                    <input type="password" name="password_old" class="validade">
                                    <label>Senha Antiga(*)</label>
                                </div>
                                @if($errors->has('password_old'))
                                    <span class="help-alert"> {{$errors->first('password_old')}}
                                    </span>
                                @endif
                                @if($errors->has('senha_antiga_errada'))
                                    <span class="help-alert"> {{$errors->first('senha_antiga_errada')}}
                                    </span>
                                @endif
                            </div>

                            <div class="row">
                                <div class="input-field col m12">
                                    <input type="password" name="password_new" class="validade">
                                    <label>Senha Nova (*)</label>
                                </div>
                                @if($errors->has('password_new'))
                                    <span class="help-alert"> {{$errors->first('password_new')}}
                                    </span>
                                @endif
                            </div>

                            <div class="row">
                                <div class="input-field col m12">
                                    <input type="password" name="password_new_confirmation">
                                    <label>Confirmar Senha Nova (*)</label>
                                </div>
                                @if($errors->has('password_confirmation'))
                                    <span class="help-alert"> {{$errors->first('password_confirmation')}}
                                    </span>
                                @endif
                            </div>

                            <div class="modal-footer">
                                <div class="input-field col s12">
                                    <button class="btn btn-default waves-effect waves-light right form-edit-button dispara-loading" type="submit" name="action" style="margin-left: 10px;">Trocar Senha
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
