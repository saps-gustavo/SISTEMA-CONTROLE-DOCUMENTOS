{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')

{{-- Conteúdo da página --}}
@section('conteudo')

{{-- Breadcrumb --}}
@section('breadcrumb')
    <a href="{{url('/')}}" class="breadcrumb">Principal</a>
    <a href="{{url('/sedh/termo_administrativo_aditivo')}}" class="breadcrumb">{{ $titulo }}</a>
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
                        <form class="col s12" action="{{ route('sedh.termo_administrativo_aditivo.salvar') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="id_termo_adm_aditivo" id="id_termo_adm_aditivo" value="{{old('id_termo_adm_aditivo') ?? $registro->id_termo_adm_aditivo}}">
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


                            <div class="input-field col s4 m4 l4">

                            <select id="cod_tipo_termo_adm" name="cod_tipo_termo_adm" disabled tabindex="1">

                            <option value="" selected>Selecione</option>
                                @foreach($tipo_termo_adm as $tipoTermo)
                                <option value="{{$tipoTermo->cod_tipo_termo_adm}}"
                                    @if(old('cod_tipo_termo_adm') == $tipoTermo->cod_tipo_termo_adm || $registro['cod_tipo_termo_adm'] == $tipoTermo->cod_tipo_termo_adm) 
                                        selected 
                                    @endif
                                    >{{ $tipoTermo->desc_resumida_ato_adm }} 
                                
                                </option>
                                @endforeach

                            </select>

                            <label for="lblTipoServico" class="">Tipo Termo Administrativo (*)</label>
                            </div>


                            <div class="input-field col s12 m2 l2">
                                    <input id="dt_documento" type="text" name="dt_documento" class="ano" readonly value="{{ old('dt_documento') ?? $registro->dt_documento }}" tabindex="1" placeholder="Ex.:aaaa" data-mask="0000" autocomplete="off" autofocus>
                                    <label for="lblDt_documento" class="">Data do Documento (*)</label>

                            </div>


                            <div class="input-field col s2 m2 l2">
                                    <input id="num_proximo" type="text" name="num_proximo" class="num-proximo" readonly value="{{ old('num_proximo') ?? $registro->num_proximo }}"  tabindex="2" autofocus>
                                    <label for="lblNumProximo" class="">Número Próximo (*)</label>
                                </div>

                                

                                <div class="input-field col s2 m2 l2">
                                    <input id="num_aditivo" type="text" name="num_aditivo" class="num-proximo"  value="{{ old('num_aditivo') ?? $registro->num_aditivo }}"  tabindex="3" autofocus>
                                    <label for="lblNumAditivo" class="">Número Aditivo (*)</label>
                                </div>

                                <input type="hidden" name="id_termo_adm" value="{{$registro->id_termo_adm}}" readonly>

                            </div>
                                <div class="input-field col s2 m2 l2">
                                    <input id="dt_inicio_aditivo" type="text" class="data" name="dt_inicio_aditivo" value="{{ old('dt_inicio_aditivo') ?? implode('/', array_reverse(explode('-', substr($registro->dt_inicio_aditivo,0,10)))) }}" tabindex="4" autofocus>
                                    <label for="lblDt_inicio_aditivo" class="">Data Inicio Aditivo</label>
                                </div>
                                <div class="input-field col s2 m2 l2">
                                    <input id="dt_termino_aditivo" type="text" class="data" name="dt_termino_aditivo" value="{{ old('dt_termino_aditivo') ?? implode('/', array_reverse(explode('-', substr($registro->dt_termino_aditivo,0,10)))) }}" tabindex="5"  autofocus>
                                    <label for="lblDt_termino_aditivo" class="">Data Término Aditivo</label>

                                </div>
                                <div class="input-field col s2 m2 l2">
                                    <input id="vlr_reajuste" type="text" name="vlr_reajuste" class="money_br" value="{{ old('vlr_reajuste') ?? number_format($registro->vlr_reajuste, 2, ',', '.') }}" tabindex="6" autofocus>

                                    <label for="lblVlr_reajuste" class="">Valor do Reajuste</label>
                                </div>
                                
                                <div class="input-field col s2 m2 l2">
                                    <input id="livro" type="text" name="livro" value="{{ old('livro') ?? $registro->livro }}" tabindex="7"  autofocus>
                                    <label for="lblLivro" class="">Livro</label>
                                </div>
                                <div class="input-field col s2 m2 l2">
                                    <input id="folha" type="text" name="folha" value="{{ old('folha') ?? $registro->folha }}" tabindex="8" autofocus>
                                    <label for="lblFolha" class="">Folha</label>
                                </div>

                                <div class="input-field col s12 m12 l12">
                                    <input id="objeto" type="text" name="objeto" value="{{ old('objeto') ?? $registro->objeto }}" tabindex="9" autofocus>
                                    <label for="lblObjeto" class="">Objeto</label>
                                </div>

                                <div class="input-field col s12 m12 l12">
                                    <input id="observacao" type="text" name="observacao" value="{{ old('observacao') ?? $registro->observacao }}" tabindex="10" autofocus>
                                    <label for="lblObservacao" class="">Observação</label>
                                </div>
                            <div class="row">
                                <div class="col s12 m8 l8">
                                    @if($registro->id_termo_adm_aditivo)
                                        <font color="gray">
                                        Criado em: {{ $registro->created_at }} / Alterado em: {{ $registro->updated_at }}
                                        </font>
                                    @endif
                                </div>
                                <div class="col s12 m4 l4">
                                    <a class="btn grey waves-effect waves-green right" href="{{ URL::previous() }}" tabindex="4">Cancelar</a>
                                    
                                    <button class="btn btn-default waves-effect waves-light right form-edit-button dispara-loading" type="submit" name="action" style="margin-right: 10px;" tabindex="3">Salvar</button>&nbsp;&nbsp;

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



