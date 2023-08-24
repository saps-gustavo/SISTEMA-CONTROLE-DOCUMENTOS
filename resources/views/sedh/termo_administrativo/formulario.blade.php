{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')

{{-- Conteúdo da página --}}
@section('conteudo')

{{-- Breadcrumb --}}
@section('breadcrumb')
    <a href="{{url('/')}}" class="breadcrumb">Principal</a>
    <a href="{{url('/sedh/termo_administrativo')}}" class="breadcrumb">{{ $titulo }}</a>
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
                        <form class="col s12" action="{{ route('sedh.termo_administrativo.salvar') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="id_termo_adm" id="id_termo_adm" value="{{old('id_termo_adm') ?? $registro->id_termo_adm}}">
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


                            <div class="input-field col s12 m3 l3">

                            <select id="cod_tipo_termo_adm" name="cod_tipo_termo_adm" tabindex="1">

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


                            <div class="input-field col s12 m3 l3">
                                    <input id="dt_documento" type="text" name="dt_documento" class="ano" value="{{ old('dt_documento') ?? $registro->dt_documento }}" tabindex="2" placeholder="Ex.:aaaa" data-mask="0000" autocomplete="off" autofocus>
                                    <label for="lblDt_documento" class="">Data do Documento (*)</label>

                            </div>

                            <div class="input-field col s12 m3 l3">
                                    <input id="num_proximo" type="text" name="num_proximo" class="num-proximo" value="{{ old('num_proximo') ?? $registro->num_proximo }}"  tabindex="3" autofocus>
                                    <label for="lblNumProximo" class="">Número Próximo (*)</label>
                                </div>

                            <div class="input-field col s12 m3 l3">

                            <select id="cod_tipo_servico" name="cod_tipo_servico" tabindex="4">

                                    <option value="0" selected>Selecione</option>
                                    @foreach($tipo_servico as $tipo)
                                    <option value="{{$tipo->cod_tipo_servico}}"
                                        @if(old('cod_tipo_servico') == $tipo->cod_tipo_servico || $registro['cod_tipo_servico'] == $tipo->cod_tipo_servico) 
                                            selected 
                                        @endif
                                        >{{ $tipo->desc_tipo_servico }} 
                                    
                                    </option>
                                    @endforeach
                            </select>

                                <label for="lblTipoServico" class="">Tipo Serviço (*)</label>
                            </div>

                            <div class="input-field col s12 m3 l3">

                            <select  id="cod_situacao" name="cod_situacao" tabindex="5">

                            <option value="" selected>Selecione</option>
                                    @foreach($situacao as $situacao)
                                    <option value="{{$situacao->cod_situacao}}"
                                        @if(old('cod_situacao') == $situacao->cod_situacao || $registro['cod_situacao'] == $situacao->cod_situacao) 
                                            selected 
                                        @endif
                                        >{{ $situacao->desc_situacao }} 
                                    
                                    </option>
                                    @endforeach

                            </select>

                                <label for="lblSituacao" class="">Situação (*)</label>
                            </div>

                                <div class="input-field col s12 m3 l3">

                                <select id="secretaria" name="secretaria" tabindex="6">
                                    <option value="" selected>Selecione</option>
                                    <option value="SEAPA" @if($registro->secretaria == 'SEAPA') selected @endif>SEAPA</option>
                                    <option value="SAS" @if($registro->secretaria == 'SAS') selected @endif>SAS</option>
                                    <option value="SECOM" @if($registro->secretaria == 'SECOM') selected @endif>SECOM </option>
                                    <option value="CGM" @if($registro->secretaria == 'CGM') selected @endif>CGM</option>
                                    <option value="SEDIC" @if($registro->secretaria == 'SEDIC') selected @endif>SEDIC</option>
                                    <option value="SE" @if($registro->secretaria == 'SE') selected @endif>SE</option>
                                    <option value="SEL" @if($registro->secretaria == 'SEL') selected @endif>SEL</option>
                                    <option value="SEDH" @if($registro->secretaria == 'SEDH') selected @endif>SEDH</option>
                                    <option value="SF" @if($registro->secretaria == 'SF') selected @endif>SF</option>
                                    <option value="SG" @if($registro->secretaria == 'SG') selected @endif>SG</option>
                                    <option value="SO" @if($registro->secretaria == 'SO') selected @endif>SO</option>
                                    <option value="SEPPOP" @if($registro->secretaria == 'SEPPOP') selected @endif>SEPPOP</option>
                                    <option value="SEPUR" @if($registro->secretaria == 'SEPUR') selected @endif>SEPUR</option>
                                    <option value="PGM" @if($registro->secretaria == 'PGM') selected @endif>PGM</option>
                                    <option value="SRH" @if($registro->secretaria == 'SRH') selected @endif>SRH</option>
                                    <option value="SS" @if($registro->secretaria == 'SS') selected @endif>SS</option>
                                    <option value="SESUS" @if($registro->secretaria == 'SESUS') selected @endif>SESUS</option>
                                    <option value="SESMAUR" @if($registro->secretaria == 'SESMAUR') selected @endif>SESMAUR</option>
                                    <option value="STDA" @if($registro->secretaria == 'STDA') selected @endif>STDA</option>
                                    <option value="SETTUR" @if($registro->secretaria == 'SETTUR') selected @endif>SETTUR</option>
                                    <option value="SMU" @if($registro->secretaria == 'SMU') selected @endif>SMU</option>


                                </select>
                                    <label for="secretaria" class="">Secretaria (*)</label>

                                </div>

                                <div class="input-field col s12 m12 l12">
                                    <input id="empresa" type="text" name="empresa" value="{{ old('empresa') ?? $registro->empresa }}"  tabindex="7" autofocus>
                                    <label for="lblEmpresa" class="">Empresa (*)</label>
                                </div>

                                <div class="input-field col s12 m12 l12">
                                    <input id="objeto" type="text" name="objeto" value="{{ old('objeto') ?? $registro->objeto }}" tabindex="8" autofocus>
                                    <label for="lblObjeto" class="">Objeto (*)</label>
                                </div>
                                
                                <div class="input-field col s12 m3 l3">
                                    <input id="num_processo" type="text" name="num_processo" class="num-processo" value="{{ old('num_processo') ?? $registro->num_processo }}" tabindex="9"  autofocus>
                                    <label for="lblNum_processo" class="">Número do Processo (*)</label>
                                </div>
                                <div class="input-field col s12 m3 l3">
                                    <input id="valor" type="text" name="valor" class="money_br" value="{{ old('valor') ?? number_format($registro->valor, 2, ',', '.') }}" tabindex="10" autofocus>
                                    <label for="lblValor" class="">Valor (*)</label>

                                </div>

                                <div class="input-field col s12 m3 l3">

                                <select id="tipo_valor" name="tipo_valor" tabindex="11">
                                        <option value="" selected>Selecione</option>
                                        <option value="Mensal" @if($registro->tipo_valor == 'Mensal') selected @endif>Mensal</option>
                                        <option value="Global" @if($registro->tipo_valor == 'Global') selected @endif>Global</option>
                                        <option value="Outros" @if($registro->tipo_valor == 'Outros') selected @endif>Outros</option>
                                
                                </select>
                                    <label for="tipo_valor" class="">Tipo Valor</label>

                                </div>

                                <div class="input-field col s12 m3 l3">
                                    <input id="dt_inicio" type="text" name="dt_inicio" class="data" value="{{ old('dt_inicio') ?? implode('/', array_reverse(explode('-', substr($registro->dt_inicio,0,10)))) }}" tabindex="12" placeholder="Ex.: dd/mm/aaaa" data-mask="00/00/0000" autocomplete="off" autofocus>
                                    <label for="lblDt_inicio" class="">Data Inicio (*)</label>

                                </div>

                                <div class="input-field col s12 m3 l3">
                                    <input id="dt_termino" type="text" name="dt_termino" class="data" value="{{ old('dt_termino') ?? implode('/', array_reverse(explode('-', substr($registro->dt_termino,0,10)))) }}" tabindex="13" placeholder="Ex.: dd/mm/aaaa" data-mask="00/00/0000" autocomplete="off" autofocus>
                                    <label for="lblDt_termino" class="">Data Término (*)</label>

                                </div>

                                <div class="input-field col s2 m2 l2">
                                    <input id="livro" type="text" name="livro" value="{{ old('livro') ?? $registro->livro }}" size="4" tabindex="14" autofocus>
                                    <label for="lblLivro" class="">Livro</label>
                                </div>

                                <div class="input-field col s2 m2 l2">
                                    <input id="folha" type="text" name="folha" value="{{ old('folha') ?? $registro->folha }}" size="6" tabindex="15" autofocus>
                                    <label for="lblFolha" class="">Folha</label>
                                </div>

                                <div class="input-field col s12 m3 l3">
                                    <input id="inscr_cpf_cadastrador" type="text" name="inscr_cpf_cadastrador" class="cpf" placeholder="Ex.: 000.000.000-00" value="{{ old('inscr_cpf_cadastrador') ?? $registro->inscr_cpf_cadastrador }}" tabindex="16" autofocus>
                                    <label for="lblInscr_cpf_cadastrador" class="">CPF Do Cadastrador</label>
                                </div>

                                <div class="input-field col s7 m7 l7">
                                    <p>
                                        <label>
                                        <input type="checkbox" id="encerrado" name="encerrado" class="filled-in" @if($registro->encerrado == 'S') checked @endif tabindex="14" />
                                            <span>Estado do documento: Encerrado?</span>
                                        </label>

                                    </p>
                                </div>
                              
                            </div>
                            <div class="row">
                                <div class="col s12 m8 l8">
                                    @if($registro->id_termo_adm)
                                        <font color="gray">
                                        Criado em: {{ $registro->created_at }} / Alterado em: {{ $registro->updated_at }}
                                        </font>
                                    @endif
                                </div>
                            <div class="row">
                           
                                <div class="col s12 m4 l4">
                                    <a class="btn grey waves-effect waves-green right" href="{{ route('sedh.termo_administrativo') }}" tabindex="17">Cancelar</a>

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
