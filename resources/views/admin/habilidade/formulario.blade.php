{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')

{{-- Conteúdo da página --}}
@section('conteudo')

{{-- Breadcrumb --}}
@section('breadcrumb')
<a href="{{url('/')}}" class="breadcrumb">Principal</a>
<a href="{{url('/admin/habilidade')}}" class="breadcrumb">{{ $titulo }}</a>
<a class="breadcrumb">{{ $subtitulo }}</a>
@include('layouts._includes.home.notificacoes')
@endsection
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card hoverable">
            <div class="card-content">
                <div id="cadastro-habilidade">
                  @if($habilidade->id)
                      <h5>Editar Habilidade</h5>
                  @else
                      <h5>Cadastro de Habilidade</h5>
                  @endif
                    <div class="row">
                        <form class="col s12" action="{{ route('admin.habilidade.salvar') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id" value="{{old('id') ?? $habilidade->id}}">
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
                                <div class="input-field col m12">
                                    <input id="name" type="text" name="name" value="{{ old('name') ?? $habilidade->name }}" placeholder="Formato Sugerido: model_habilidade" autofocus>
                                    <label for="name" class="">Nome (*)</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col m12">
                                    <input id="title" type="text" name="title" value="{{ old('title') ?? $habilidade->title }}" placeholder="Descreva a Habilidade">
                                    <label for="title" class="">Título </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <a class="btn grey waves-effect waves-green right" href="{{route('admin.habilidade')}}" tabindex="4">Cancelar</a>
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
