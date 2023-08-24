{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')
{{-- Conteúdo da página --}}
@section('conteudo')
{{-- Breadcrumb --}}
@section('breadcrumb')
<a href="{{url('/')}}" class="breadcrumb">Principal</a>
<a href="{{url('/admin/usuario')}}" class="breadcrumb">{{ $titulo }}</a>
<a class="breadcrumb">{{ $subtitulo }}</a>
@include('layouts._includes.home.notificacoes')
@endsection
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card hoverable">
            <div class="card-content">
                <div id="cadastro-usuario">
                  @if($usuario->id_usuario)
                    <h5>Editar Usuário</h5>
                  @else
                    <h5>Cadastro de Usuário</h5>
                  @endif
                    <div class="row">
                        <form class="col s12" action="{{ route('admin.usuario.salvar') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="id_usuario" id="id_usuario" value="{{old('id_usuario') ?? $usuario->id_usuario}}">
                            <!-- ERROS -->
                            @if ($errors->any())
                            <div class="row">
                                <div class="input-field col m6">
                                    <div class="card-panel small red lighten-2">
                                        <span class="card-title white-text">A gravação do registro apresentou os seguintes problemas:</span>
                                        @foreach ($errors->all() as $error)
                                        <span class=" white-text">{{ $error }}</span><br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="input-field col s12">
                                    <p>
                                        <label>
                                            <input type="checkbox" id="status" name="status" class="filled-in" value="1" {{(old('status') ?? $usuario->status) == true? 'checked' : ''}}/>
                                            <span>Ativo</span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="nome_usuario" class="validade" value="{{ old('nome_usuario') ?? $usuario->nome_usuario}}" autofocus>
                                    <label>Nome (*)</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="email" class="validade" value="{{ old('email')?? $usuario->email}}">
                                    <label>E-mail (*)</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="password" name="password" class="validade">
                                    <label>Senha (*)</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="password" name="password_confirmation">
                                    <label>Confirmação de Senha (*)</label>
                                </div>
                            </div>
                            {{--Perfis--}}
                            <div class="row">
                                <div class="input-field col s12">
                                    <select id="id_perfil" name="id_perfil[]" class="" multiple>
                                        <option value="" disabled>Selecione os perfis</option>
                                        @foreach($perfis as $perfil)
                                        <option value="{{$perfil->id}}"
                                            @if((old('id_perfil')!=null && in_array($perfil->id, old('id_perfil'))) || $usuario->roles()->get()->contains('id', $perfil->id))
                                            selected
                                            @endif
                                            >{{$perfil->title}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="id_perfil">Perfis</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <a class="btn grey waves-effect waves-green right" href="{{route('admin.usuario')}}" tabindex="4">Cancelar</a>
                                    <button class="btn btn-default waves-effect waves-light right form-edit-button dispara-loading" type="submit" name="action" style="margin-right: 10px;" tabindex="3">Salvar</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@include('scripts.material_select')
@endsection
