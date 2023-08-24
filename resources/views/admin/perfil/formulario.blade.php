{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')

{{-- Conteúdo da página --}}
@section('conteudo')

{{-- Breadcrumb --}}
@section('breadcrumb')
<a href="{{url('/')}}" class="breadcrumb">Principal</a>
<a href="{{url('/admin/perfil')}}" class="breadcrumb">{{ $titulo }}</a>
<a class="breadcrumb">{{ $subtitulo }}</a>
@include('layouts._includes.home.notificacoes')
@endsection
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card hoverable">
            <div class="card-content">
                <div id="cadastro-perfil">
                  @if($perfil->id)
                    <h5>Editar Perfil</h5>
                  @else
                    <h5>Cadastro de Perfil</h5>
                  @endif
                    <hr style="height: 12px; border: 0; box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);">
                    <div class="row">
                        <form class="col s12" action="{{ route('admin.perfil.salvar') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id" value="{{old('id') ?? $perfil->id}}">
                            <!-- ERROS -->
                            <div class="row">
                                <div class="input-field col m6">
                                    @if ($errors->any())
                                    <div class="card-panel small red lighten-2">
                                        <span class="card-title white-text">A gravação do registro apresentou os seguintes problemas:</span>
                                        @foreach ($errors->all() as $error)
                                            <span class=" white-text">{{ $error }}</span><br>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="name" type="text" name="name" value="{{ old('name') ?? $perfil->name }}" autofocus >
                                    <label for="name" class="">Nome (*)</label>

                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="title" type="text" name="title" value="{{ old('title') ?? $perfil->title }}">
                                    <label for="title" class="">Título </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <a class="btn grey waves-effect waves-green right" href="{{route('admin.perfil')}}" tabindex="4">Cancelar</a>
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
