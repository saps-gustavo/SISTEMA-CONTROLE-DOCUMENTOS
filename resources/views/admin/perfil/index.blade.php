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
@if($qtd_perfis > 0)
<div class="card hoverable">
	<div class="card-content">
		<form name="busca_demanda" action="{{route('admin.perfil')}}" method="GET">
			<div class="row">
				{{--Nome--}}
				<div class="col s12 m12 l6">
					<label for="busca_nome">Nome</label>
					<input type="text" name="busca_nome" id="busca_nome" value="{{ Request::get('busca_nome') }}" autofocus>
				</div>
				{{--Título--}}
				<div class="col s12 m12 l6">
					<label for="busca_setor">Título</label>
					<input type="text" name="busca_titulo" id="busca_titulo" value="{{ Request::get('busca_titulo') }}">
				</div>
				<div class="input-field col col s12 m12 l12 right-align">
					<button class="btn btn-default waves-effect waves-light" type="submit">Buscar</button>
					<a id="btnLimparBusca" class="btn teal lighten-4 waves-effect waves-light" href="{{route('admin.perfil')}}">Limpar</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endif

@if(count($perfis)>0)
<div class="col s12 m12 l12">
	<div class="card hoverable">
		@can('perfil_adicionar')
			<div class="col s12 left">
				<a title="Adicionar Novo Perfil" class="waves-effect waves-light btn-small" href="{{route('admin.perfil.formulario')}}"><i class="material-icons left">add</i>Adicionar Novo Perfil</a>
			</div>
		@endcan
		<div class="card-content">
			<table class="highlight">
				<thead>
					<tr>
						<th data-field="perfil">Perfil</th>
						<th data-field="descricao_permissao">Título</th>
						<th data-field="acao">Ação</th>
					</tr>
				</thead>
				<tbody>
					@foreach($perfis as $perfil)
					<tr>
						<td>{{ $perfil->name }}</td>
						<td>{{ $perfil->title }}</td>
						<td>
							@if ($usuario_admin)
								@can('perfil_editar')
									<a title="Editar Perfil" class="waves-effect waves-light btn btn-edit orange tooltipped" data-position="top" data-tooltip="Editar {{ $perfil->name}}" href="{{route('admin.perfil.formulario', $perfil->id)}}"><i class="material-icons">mode_edit</i></a>
								@endcan
								@can('perfil_excluir')
									@if(getenv('ID_PERFIL_SAPS') != $perfil->id)
									<a title="Remover Perfil" class="waves-effect waves-light btn modal-trigger red tooltipped" data-position="top" data-tooltip="Remover {{ $perfil->name}}" href="#modalRemover{{$perfil->id}}"><i class="material-icons">delete_forever</i></a>
									@endif
								@endcan
								@can('perfil_editar')
									<a title="Associar Habilidades" class="waves-effect waves-light btn btn-edit blue tooltipped" data-position="top" data-tooltip="Habilidades {{ $perfil->name}}" href="{{route('admin.perfil.habilidade', $perfil->id)}}"><i class="material-icons">done_all</i></a>
								@endcan
								{{-- Modal para remover perfil --}}
								<div id="modalRemover{{$perfil->id}}" class="modal">
									<div class="modal-content">
										<a class="btn-floating waves-effect waves-light grey right modal-action modal-close"><i class="material-icons">clear</i></a>
										<h5>Remover Perfil: <strong>{{$perfil->name}}</strong></h5>
										<br>
										<div class="row center">
											<h5>Tem certeza que deseja remover o registro selecionado?</h5>
										</div>
									</div>
									<div class="row" style="margin: 0 0 15px 0">
										<div class="modal-footer">
											<div class="col s12">
												<a class="btn btn-default waves-effect modal-action modal-close btn-excluir" data-id="{{$perfil->id}}">Remover</a>
												<a class="btn grey waves-effect waves-light modal-action modal-close" data-dismiss="modal">Cancelar</a>
											</div>
										</div>
									</div>
								</div>
							@else
								<font color='red'>PERFIL ADMINISTRADOR</font>
							@endif
							{{-- Fim do modal para remover permissão--}}
							{{-- Chama o formulário de cadastro em janela modal--}}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			{{-- Linha de paginação --}}
			<div class="row">
				{{ $perfis->links() }}
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
			<p class="center">Utilize o botão adicionar para cadastrar uma nova perfil.</p>
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
@include('admin.perfil.scripts.excluirPerfil')
@include('scripts.inicializa_modal')
@include('scripts.jquery-confirm')
@endsection
