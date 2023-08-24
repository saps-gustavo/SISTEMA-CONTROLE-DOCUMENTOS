{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')

{{-- Conteúdo da página --}}
@section('conteudo')

@section('breadcrumb')
<a href="{{url('/')}}" class="breadcrumb">{{ $subtitulo }}</a>
<a class="breadcrumb">{{ $titulo }}</a>
@include('layouts._includes.home.notificacoes')
@endsection

@if($qtd_registros>0)
<div class="row">
	<div class="col s12 m12">
		<div class="card hoverable">
			<div class="card-content">
				<form name="busca_demanda" action="{{route('admin.log')}}" method="GET">
					<div class="row">
						{{--Dt.Início--}}
						<div class="col s12 m6 l3">
							<label for="datainicio" class="">Data Inicial (*)</label>
							<input id="datainicio" type="text" class="datepicker" name="datainicio" value="{{ implode('/',array_reverse(explode('-', $parametros['datainicio']))) }}" tabindex="1" autofocus>
						</div>
						{{--Dt.Fim--}}
						<div class="col s12 m6 l3">
							<label for="datafim" class="">Data Final (*)</label>
							<input id="datafim" type="text" class="datepicker" name="datafim" value="{{ implode('/',array_reverse(explode('-', $parametros['datafim']))) }}" tabindex="1" autofocus>
						</div>
						{{--Ação--}}
						<div class="col s12 m12 l6">
							<label>
								Ação
								<select id="acao" name="acao">
									<option value="" selected>Filtro por Ação</option>
									<option value="Atribuição" @if($parametros['acao'] == 'Atribuição') selected @endif>Atribuição</option>
									<option value="Atualização" @if($parametros['acao'] == 'Atualização') selected @endif>Atualização</option>
									<option value="Criação" @if($parametros['acao'] == 'Criação') selected @endif>Criação</option>
									<option value="Exclusão" @if($parametros['acao'] == 'Exclusão') selected @endif>Exclusão</option>
									<option value="Login" @if($parametros['acao'] == 'Login') selected @endif>Login</option>
									<option value="Relação" @if($parametros['acao'] == 'Relação') selected @endif>Relação</option>
								</select>
							</label>
						</div>
						{{--Usuário--}}
						<div class="col s12 m12 l12">
							<label>
								Usuários
								<select id="usuario" name="usuario">
									<option value="" selected>Filtro por Usuário</option>
									@foreach($usuarios as $item)
										<option value="{{$item->id_usuario}}"
											@if($parametros['usuario'] == $item->id_usuario)
											selected
											@endif
											>{{$item->nome_usuario}}
										</option>
									@endforeach
								</select>
							</label>
						</div>
						<div class="input-field col s12 m12 l12 right-align">
							<button class="btn btn-default waves-effect waves-light" type="submit">Buscar</button>
							<a id="btnLimparBusca" class="btn teal lighten-4 waves-effect waves-light" href="{{route('admin.log')}}">Limpar</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12 m12">
		<div class="card hoverable">
			<div class="card-content">
				<div style="overflow-x:auto;">
				<table class="highlight" id="tabela_log">
					<thead>
						<tr>
							<th data-field="no">No</th>
							<th data-field="usuario">Usuário</th>
							<th data-field="acao">Ação</th>
							<th data-field="url">URL</th>
							<th data-field="metodo">Método</th>
							<th data-field="ip">IP</th>
							<th data-field="fonte" class="table-responsive-hide-tablet">Fonte de Acesso</th>
							<th data-field="data" class="table-responsive-hide-desktop">Data</th>
							<th data-field="dados">Detalhe </th> 
						</tr>
					</thead>
					<tbody>
						@if($logs->count())
						@foreach($logs as $key => $registro)
						<tr>
							<td>{{ ++$key }}</td>
							<td>{{ $registro->usuario->nome_usuario }}</td>
							<td>{{ $registro->acao }}</td>
							<td>{{ $registro->url }}</td>
							<td>{{ $registro->metodo }}</td>
							<td>{{ $registro->ip }}</td>
							<td class="table-responsive-hide-tablet">{{ str_limit($registro->fonte, $limit = 60, $end = '...') }}</td>
							<td class="table-responsive-hide-desktop">{{ Carbon\Carbon::parse($registro->created_at)->format('d/m/Y H:i') }}</td>
							<td> <a href="{{route('admin.log.detalhe', $registro->id_log_atividade)}}">Detalhes </a></td>
						</tr>

						@endforeach
						@endif
					</tbody>
				</table>
			</div>
				{{-- Linha de paginação --}}
				<div class="row">
					{{ $logs->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
@else
<div class="container">
	<div class="row">
		<div class="col s12 m12 l12">
			<br>
			<h5 class="breadcrumbs-title center">Nenhum registro de Log encontrado para os filtros aplicados!</h5>
			<p class="center"><a class="btn btn-default waves-effect waves-light" href="{{route('admin.log')}}">Voltar</a></p>
		</div>
	</div>
</div>
@endif

@endsection

@section('script')
@include('scripts.responsiveTable')
@include('scripts.material_select')
@include('scripts.mascaras')
@include('scripts.material_datepicker')
@include('admin.log.scripts.listarMeses', ['nomeCampo'=>'mes'])
{{-- <script type="text/javascript" src="/assets/js/stacktable.js"></script> --}}

<script> 
	$(document).ready(function() {
			//chamada do plugin responsive Table						
			$('#tabela_log').responsiveTable
			({
				changeOrientation: 720,
				targets:
				[	
					{
						hideColumnsMin: 721,
						hideColumnsMax: 1000,
						hideColumnsClassSelector: 'table-responsive-hide-tablet',
						selectors: ['th', 'td'],
            			action: 'hide'
					},
					{
						hideColumnsMin: 1001,
						hideColumnsMax: 1235,
						hideColumnsClassSelector: 'table-responsive-hide-desktop',
						selectors: ['th', 'td'],
            			action: 'hide'
					}				
				],
            	
        	});

			//chama de novo se houver redimensionamento da tela
			$(window).resize(function() {
				$('#tabela_log').responsiveTable
				({
					changeOrientation: 720,
					targets:
					[	
						{
							hideColumnsMin: 721,
							hideColumnsMax: 1000,
							hideColumnsClassSelector: 'table-responsive-hide-tablet',
							selectors: ['th', 'td'],
            				action: 'hide'
						},
						{
							hideColumnsMin: 1001,
							hideColumnsMax: 1235,
							hideColumnsClassSelector: 'table-responsive-hide-desktop',
							selectors: ['th', 'td'],
            				action: 'hide'
						}				
					]
	            	
	        	});
			});
		});




	</script>
	@endsection

	@section('custom_css')
	{{-- <link rel="stylesheet" href="/assets/css/stacktable.css"> --}}
	
	<style>
		table {font-size: 0.8em;}
		 
</style>
@endsection

