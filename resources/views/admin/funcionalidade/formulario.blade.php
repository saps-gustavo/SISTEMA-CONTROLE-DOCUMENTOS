{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')

{{-- Conteúdo da página --}}
@section('conteudo')

{{-- Breadcrumb --}}
    @section('breadcrumb')
        <a href="{{url('/')}}" class="breadcrumb">Principal</a>
        <a href="{{url('/admin/funcionalidade')}}" class="breadcrumb">{{ $titulo }}</a>
        <a class="breadcrumb">{{ $subtitulo }}</a>
        @include('layouts._includes.home.notificacoes')
    @endsection
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card hoverable">
                <div class="reduz-margem card-content">
                    <div id="cadastro-funcionalidade">
                        <div class="row">
                            <div class="col s12">
                                @if($funcionalidade->id_funcionalidade)
                                  <span class="card-title grey-text text-darken-3">Editar Funcionalidade</span>
                                @else
                                  <span class="card-title grey-text text-darken-3">Cadastro Funcionalidade</span>
                                @endif
                                <hr class="linha-cinza">
                            </div>
                        </div>
                        <div class="row">
                            <form class="col s12" action="{{ route('admin.funcionalidade.salvar') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_funcionalidade" id="id_funcionalidade" value="{{old('id_funcionalidade') ?? $funcionalidade->id_funcionalidade}}">

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
                                        <input id="nome_funcionalidade" type="text" name="nome_funcionalidade" value="{{ old('nome_funcionalidade') ?? $funcionalidade->nome_funcionalidade }}" autofocus>
                                        <label for="nome_funcionalidade" class="">Nome (*)</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="desc_funcionalidade" type="text" name="desc_funcionalidade" class="materialize-textarea">{{ old('desc_funcionalidade') ?? $funcionalidade->desc_funcionalidade }}</textarea>
                                        <label for="desc_funcionalidade" class="">Descrição (*)</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="apelido" type="text" name="apelido" value="{{ old('apelido') ?? $funcionalidade->apelido }}" placeholder="Não use espaços e caracteres especiais neste campo">
                                        <label for="apelido" class="">Apelido (*)</label>
                                    </div>

                                    <div class="input-field col s6">
                                        <input id="model" type="text" name="model" value="{{ old('model') ?? $funcionalidade->model }}">
                                        <label for="model" class="">Model </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s12">
                                        <a class="btn grey waves-effect waves-green right" href="{{route('admin.funcionalidade')}}" tabindex="4">Cancelar</a>
                                        <button class="btn btn-default waves-effect waves-light right form-edit-button dispara-loading" type="submit" name="action" style="margin-right: 10px;" tabindex="3">Salvar</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($funcionalidade->id_funcionalidade))
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card hoverable">
                    <div class="card-content">

                        <div class="row">
                            <div class="col s12">
                                <span class="card-title grey-text text-darken-3">Associar Habilidade - Funcionalidade {{$funcionalidade->nome_funcionalidade}}</span>
                                <hr class="linha-cinza">
                            </div>
                        </div>
                        <div class="row">
                            <form class="col s12" action="{{route('admin.funcionalidade.associaHabilidade')}}" method="post">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col s12">
                                        <span id="topform-error" class="help-alert"></span>
                                    </div>
                                </div>

                                <input type="hidden" id="id_funcionalidade_habilidade" name="id_funcionalidade_habilidade" value="{{$funcionalidade->id_funcionalidade}}"></input>

                                <div class="row">
                                    <div class="input-field col s6">
                                        <select id="id_habilidade" name="id_habilidade">
                                            @foreach($habilidades as $hab)
                                                <option value="{{$hab->id}}">{{$hab->name}}  -  {{$hab->nome_funcionalidade ?? 'Sem funcionalidade'}}</option>
                                            @endforeach
                                        </select>
                                        <label> Habilidade </label>
                                    </div>

                                    <div class="col s6">
                                        <a class="waves-effect waves-light btn-small associa-habilidade"><i class="material-icons left">arrow_downward</i>Associar</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s4">
                                        @can('habilidade_adicionar')
                                            <!-- Modal Trigger -->
                                            <a class="waves-effect waves-light btn modal-trigger" href="#modalHabilidade">Incluir Nova Habilidade</a>
                                        @endcan
                                    </div>
                                </div>
                                <div id="tabela_habilidade">
                                    @include('admin.funcionalidade._includes.habilidadesPorFuncionalidade',['habilidades'=>$funcionalidade->habilidades])
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('admin.funcionalidade._includes.modalHabilidade')

    @endif
@endsection

@section('custom_css')
    @include('css.jquery-confirm')
@endsection

@section('script')
    @include('scripts.material_select')
    @include('admin.funcionalidade.scripts.associaHabilidade')
    @include('admin.funcionalidade.scripts.desassociaHabilidade')
    @include('admin.funcionalidade.scripts.salvaHabilidade')
    @include('scripts.ajax_loading')


    @include('scripts.jquery-confirm')
    <script>
    //funcoes com escopo global quer podem ser chamadas dentro de qualquer outro escopo
    function carregaTabelaHabilidades(id_funcionalidade)
    {
        $.ajax({
            url: "{{route('admin.funcionalidade.carregaTabelaHabilidades')}}",
            data: {
                "id_funcionalidade": id_funcionalidade,
            },
            type: "GET",
            success: function (data) {
                $('#tabela_habilidade').html(data);
            },
            error: function (data) {
                alert('Erro no carregamento');
            }

        });
    }

    function carregaSelectHabilidades(id)
    {
        $.ajax({
            url: "{{ route('admin.habilidade.ajaxSelectHabilidade')}}",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(json)
            {
                //limpa o select servico
                $("#id_habilidade").html('');

                var opcao = new Option('Selecione', '');
                //transforma o objeto DOM em jquery através do $() para poder usar os métodos do jquery
                $(opcao).html('Selecione');

                $("#id_habilidade").append(opcao);

                $.each(json, function(i, value)
                {
                    if(value.nome_funcionalidade != null)
                    var nome_funcionalidade = value.nome_funcionalidade;
                    else
                    var nome_funcionalidade = 'Sem funcionalidade';

                    var opcao = new Option(value.name+' - '+nome_funcionalidade, value.id);
                    //transforma o objeto DOM em jquery através do $() para poder usar os métodos do jquery
                    $(opcao).html(value.name+' - '+nome_funcionalidade);
                    $("#id_habilidade").append(opcao);
                });
                //seta habilidade recem cadastrada no select
                $('#id_habilidade').val(id);


                $('#id_habilidade').formSelect();

            },
            error: function(json){
                alert(json.mensagem);
            }

        });
    }

    var limpaCampos = function ()
    {
        $('#name').val('');
        $('#title').val('');
        $('#topform-error-modal').html('');
        // var error_top = document.getElementById('topform-error');
        // error_top.innerHTML = '';
    }

    //$(document).ready(function(){
    document.addEventListener('DOMContentLoaded', function() {
        var options = {"onOpenStart": limpaCampos};
        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems, options);
    });
    //});
    </script>
@endsection
