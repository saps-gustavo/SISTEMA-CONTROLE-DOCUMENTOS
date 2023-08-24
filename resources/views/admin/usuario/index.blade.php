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
	@if($qtd_usuarios > 0)
		<div class="card hoverable">
			<div class="card-content">
				<form name="busca_demanda" action="{{route('admin.usuario')}}" method="GET">
					<div class="row">
						{{--Nome--}}
						<div class="col s12 m12 l6">
							<label for="busca_nome">Nome</label>
							<input type="text" name="busca_nome" id="busca_nome" value="{{ Request::get('busca_nome') }}" autofocus>
						</div>
						{{--Email--}}
						<div class="col s12 m12 l6">
							<label for="busca_email">Email</label>
							<input type="text" name="busca_email" id="busca_email" value="{{ Request::get('busca_email') }}">
						</div>
						<div class="input-field col s12 m12 l12 right-align">
							<button class="btn btn-default waves-effect waves-light" type="submit">Buscar</button>
							<a id="btnLimparBusca" class="btn teal lighten-4 waves-effect waves-light" href="{{route('admin.usuario')}}">Limpar</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	@endif

	@if(count($usuarios)>0)
		<div class="col s12 m12 l12">
			<div class="card hoverable">
				<div class="col s12 left">
					@can('usuario_adicionar')
						<a title="Adicionar Novo Usuário" class="waves-effect waves-light btn-small" href="{{route('admin.usuario.formulario')}}"><i class="material-icons left">person_add</i>Adicionar Novo Usuário</a>
					@endcan
				</div>
				<div class="card-content">
					<table class="highlight" id="tb_usuario">
						<thead>
							<tr>
								<th data-field="usuario">Nome</th>
								<th data-field="email">Email</th>
								<th> Ativo </th>
								<th data-field="acao">Ação</th>
							</tr>
						</thead>
						<tbody>
							@foreach($usuarios as $usuario)
								<tr>
									<td>{{ $usuario->nome_usuario }}</td>
									<td>{{ $usuario->email }}</td>
									<td>
										@if($usuario->status == 1)
											Sim
										@else
											Não
										@endif
									</td>
									<td>
										@can('usuario_editar')
											@if($usuario->id_usuario <> env('ID_USUARIO_SAPS'))
											<a class="waves-effect waves-light btn btn-edit orange tooltipped" data-position="top" data-tooltip="Editar {{ $usuario->getPrimeiroNome()}}" href="{{route('admin.usuario.formulario', $usuario->id_usuario)}}"><i class="material-icons">mode_edit</i></a>
											@endif
										@endcan
										@can('usuario_excluir')
											@if($usuario->id_usuario <> env('ID_USUARIO_SAPS'))
											<a class="waves-effect waves-light btn modal-trigger red tooltipped" data-position="top" data-tooltip="Remover {{ $usuario->getPrimeiroNome()}}" href="#modalRemover{{ $usuario->id_usuario }}"><i class="material-icons">delete_forever</i></a>
											{{-- Modal para remover usuario --}}
											<div id="modalRemover{{ $usuario->id_usuario }}" class="modal">
												<div class="modal-content">
													<a class="btn-floating waves-effect waves-light grey right modal-action modal-close"><i class="material-icons">clear</i></a>
													<h5>Remover Perfil: <strong>{{$usuario->nome_usuario}}</strong></h5>
													<br>
													<div class="row center">
														<h5>Tem certeza que deseja remover o registro selecionado?</h5>
													</div>
												</div>
												<div class="row" style="margin: 0 0 15px 0">
													<div class="modal-footer">
														<div class="col s12">
															<a class="btn btn-default waves-effect modal-action modal-close btn-excluir" data-id="{{ $usuario->id_usuario }}">Remover</a>
															<a class="btn grey waves-effect waves-light modal-action modal-close" data-dismiss="modal">Cancelar</a>
														</div>
													</div>
												</div>
											</div>
											{{-- Fim do modal para remover usuario--}}
											@endif
										@endcan
										@can('usuario_editar')
											@if ($usuario->id_usuario = 0)
												<a class="waves-effect waves-light btn btn-edit blue tooltipped" data-position="top" data-tooltip="Habilitar {{ $usuario->getPrimeiroNome()}}" href="{{route('admin.usuario.habilidade', $usuario->id_usuario)}}"><i class="material-icons">done_all</i></a>
											@endif
										@endcan
									</td>
								</tr>

							@endforeach
						</tbody>
					</table>
					{{-- Linha de paginação --}}
					<div class="row">
						{{ $usuarios->links() }}
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
					<p class="center">Utilize o botão adicionar para cadastrar uma nova usuario.</p>
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
	{{-- @include('admin.usuario.scripts.permissao') --}}
	@include('admin.usuario.scripts.excluirUsuario')
	@include('scripts.inicializa_modal')
	@include('scripts.jquery-confirm')
	@include('scripts.basicTable')
	<script>
	$(document).ready(function () {
		$('.highlight').basictable({breakpoint: 574, contentWrap: true});
	});
	</script>
@endsection
