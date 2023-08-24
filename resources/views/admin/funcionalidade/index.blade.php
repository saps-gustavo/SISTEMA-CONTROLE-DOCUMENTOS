{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')
{{-- Conteúdo da página --}}
@section('conteudo')
	@section('breadcrumb')
		<a href="{{url('/')}}" class="breadcrumb">{{ $titulo }}</a>
		<a class="breadcrumb">{{ $subtitulo }}</a>
		@include('layouts._includes.home.notificacoes')
	@endsection
	{{-- Filtros e Buscas --}}
	@if($qtd_funcionalidades > 0)
		<div class="card hoverable">
			<div class="card-content">
				<form name="busca_demanda" action="{{route('admin.funcionalidade')}}" method="GET">
					<div class="row">
						{{--Nome--}}
						<div class="col s12 m12 l12">
							<label for="busca_nome">Nome</label>
							<input type="text" name="busca_nome" id="busca_nome" value="{{ Request::get('busca_nome') }}" autofocus>
						</div>
						{{--Busca--}}
						<div class="input-field col s12 sm12 l12 right-align">
							<button class="btn btn-default waves-effect waves-light" type="submit">Buscar</button>
							<a id="btnLimparBusca" class="btn teal lighten-4 waves-effect waves-light" href="{{route('admin.funcionalidade')}}">Limpar</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	@endif

	@if(count($funcionalidades)>0)
		<div class="col s12 m12 l12">
			<div class="card hoverable">
				@can('funcionalidade_adicionar')
					<div class="col s12 left">
						<a title="Adicionar Nova Funcionalidade" class="waves-effect waves-light btn-small" href="{{route('admin.funcionalidade.formulario')}}"><i class="material-icons left">add</i>Adicionar Nova Funcionalidade</a>
					</div>
				@endcan
				<div class="card-content">
					<table class="highlight">
						<thead>
							<tr>
								<th data-field="nome">Nome</th>
								<th data-field="apelido"> Apelido </th>
								<th data-field="acao">Ação</th>
							</tr>
						</thead>
						<tbody>
							@foreach($funcionalidades as $funcionalidade)
								<tr>
									<td> {{ $funcionalidade->nome_funcionalidade }} </td>
									<td> {{$funcionalidade->apelido}} </td>
									<td>
										@can('funcionalidade_editar')
											<a title="Editar Funcionalidade" class="waves-effect waves-light btn btn-edit orange tooltipped" data-position="top" data-tooltip="Editar {{ $funcionalidade->nome_funcionalidade}}" href="{{route('admin.funcionalidade.formulario', $funcionalidade->id_funcionalidade)}}"><i class="material-icons">mode_edit</i></a>
										@endcan

										@can('funcionalidade_excluir')
											<a title="Remover Funcionalidade" class="waves-effect waves-light btn modal-trigger red tooltipped" data-position="top" data-tooltip="Editar {{ $funcionalidade->nome_funcionalidade}}" href="#modalRemover{{$funcionalidade->id_funcionalidade}}"><i class="material-icons">delete_forever</i></a>
										@endcan
										{{-- Modal para remover funcionalidade --}}
										<div id="modalRemover{{$funcionalidade->id_funcionalidade}}" class="modal">
											<div class="modal-content">
												<a class="btn-floating waves-effect waves-light grey right modal-action modal-close"><i class="material-icons">clear</i></a>
												<h5>Remover Funcionalidade: <strong>{{$funcionalidade->nome_funcionalidade}}</strong></h5>
												<br>
												<div class="row center">
													<h5>Tem certeza que deseja remover o registro selecionado?</h5>
												</div>
											</div>
											<div class="row" style="margin: 0 0 15px 0">
												<div class="modal-footer">
													<div class="col s12">
														<a class="btn btn-default waves-effect modal-action modal-close btn-excluir" data-id="{{$funcionalidade->id_funcionalidade}}">Remover</a>
														<a class="btn grey waves-effect waves-light modal-action modal-close" data-dismiss="modal">Cancelar</a>
													</div>
												</div>
											</div>
										</div>
										{{-- Fim do modal para remover permissão--}}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					{{-- Linha de paginação --}}
					<div class="row">
						{{ $funcionalidades->links() }}
					</div>
				</div>
			</div>
		</div>

	@else
		<div class="container">
			<div class="row">
				<div class="col s12 m12 l12">
					<br>
					<h5 class="breadcrumbs-title center">Nenhum registro encontrado!</h5>
					<p class="center">Utilize o botão adicionar para cadastrar uma nova funcionalidade.</p>
				</div>
			</div>
		</div>
	@endif

@endsection

<div id="container-editar"></div>

@section('custom_css')
	@include('css.jquery-confirm')
@endsection

@section('script')
	{{-- @include('admin.funcionalidade.scripts.permissao') --}}
	@include('admin.funcionalidade.scripts.excluirFuncionalidade')
	@include('scripts.inicializa_modal')
	@include('scripts.jquery-confirm')
@endsection
