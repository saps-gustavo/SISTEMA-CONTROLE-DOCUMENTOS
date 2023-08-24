{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')

{{-- Conteúdo da página --}}
@section('conteudo')

{{-- Breadcrumb --}}
@section('breadcrumb')
    <a href="{{url('/')}}" class="breadcrumb">Principal</a>
    <a href="{{url('/sedh/tipo_termos_administrativos')}}" class="breadcrumb">{{ $titulo }}</a>
    <a class="breadcrumb">{{ $subtitulo }}</a>
    @include('layouts._includes.home.notificacoes')
@endsection
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card hoverable">
            <div class="card-content">
                <div id="cadastro-arquivo">
                    <h5>{{ $subtitulo }} {{ $titulo }}</h5>
                    <hr style="height: 12px; border: 0; box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);">
                    <div class="row">
                        <form class="col s12" action="{{ route('sedh.tipo_termos_administrativos.salvar') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="cod_tipo_termo_adm" id="cod_tipo_termo_adm" value="{{old('cod_tipo_termo_adm') ?? $registro->cod_tipo_termo_adm}}">
                            <input type="hidden" name="uniqid" id="uniqid" value="{{ $registro->uniqid }}">
                            <!-- ERROS -->
                            <div class="row">
                                <div class="input-field col s12 m12 l12">
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
                                <div class="input-field col s3 m3 l3">
                                    <input id="cod_ato_adm" type="text" name="cod_ato_adm" size="3" class="somente_tipos_adm" value="{{ old('cod_ato_adm') ?? $registro->cod_ato_adm }}" tabindex="1" autofocus >
                                    <label for="lblCod_ato_adm" class="">Código Ato Administrativo (*)</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12 m12 l12">
                                    <input id="desc_resumida_ato_adm" type="text" name="desc_resumida_ato_adm" size="30" value="{{ old('desc_resumida_ato_adm') ?? $registro->desc_resumida_ato_adm }}" tabindex="2" autofocus>
                                    <label for="lblDesc_resumida_ato_adm" class="">Descrição Resumida do Ato Adminstrativo (*)</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m12 l12">
                                    <input id="desc_detalhada_ato_adm" type="text" name="desc_detalhada_ato_adm" size="70" value="{{ old('desc_detalhada_ato_adm') ?? $registro->desc_detalhada_ato_adm }}" tabindex="3" autofocus>
                                    <label for="lblDesc_detalhada_ato_adm" class="">Descrição Detalhada do Ato Administrativo (*)</label>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col s12 m8 l8">
                                    @if($registro->cod_tipo_termo_adm)
                                        <font color="gray">
                                        Criado em: {{ $registro->created_at }} / Alterado em: {{ $registro->updated_at }}
                                        </font>
                                    @endif
                                </div>
                                <div class="col s12 m4 l4">
                                    <a class="btn grey waves-effect waves-green right" href="{{route('sedh.tipo_termos_administrativos')}}" tabindex="4">Cancelar</a>
                                    <button class="btn btn-default waves-effect waves-light right form-edit-button dispara-loading" type="submit" name="action" style="margin-right: 10px;" tabindex="3">Salvar</button>
                                </div>
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
@include('scripts.mascaras')

@endsection
