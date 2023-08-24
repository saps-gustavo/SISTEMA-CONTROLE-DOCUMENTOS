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
    
	@if($qtd_registros > 0)
	<div class="card hoverable">
		<div class="card-content">
			<form name="busca_demanda" action="{{route('sedh.tipo_servico')}}" method="GET">
				<div class="row">
					{{--descricao--}}
					<div class="col s12 m6 l12">
						<label for="busca_desc">Nome</label>
						<input type="text" name="busca_desc" id="busca_desc" value="{{ Request::get('busca_desc') }}" autofocus>
					</div>
					<div class="input-field col s12 m6 l12 right-align">
						<button class="btn btn-default waves-effect waves-light" type="submit">Buscar</button>
						<a id="btnLimparBusca" class="btn teal lighten-4 waves-effect waves-light" href="{{route('sedh.tipo_servico')}}">Limpar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	@endif

	@if(count($lista)>0)
		<div class="col s12 m12 l12">
			<div class="card hoverable">
				<div class="col s12 m12 l12 left">
					@can('tipo_servico_adicionar')
						<a title="Adicionar" class="waves-effect waves-light btn-small" href="{{route('sedh.tipo_servico.formulario')}}"><i class="material-icons left">add</i>Adicionar</a>
					@endcan
				</div>
				<div class="card-content">
					<table class="highlight" id="tb_tipo_servico">
						<thead>
							<tr>
								<th data-field="tipo_servico">Código Tipo Serviço</th>
								<th data-field="tipo_servico">Descrição tipo serviço</th>
								<th data-field="tipo_servico">Editar</th>

							</tr>
						</thead>
						<tbody>
							@foreach($lista as $tipo_servico)
								<tr>
									<td>{{$tipo_servico->cod_tipo_servico }}</td>
									<td>{{ $tipo_servico->desc_tipo_servico }}</td>

									<td>
											@can('tipo_servico_editar')
												<a class="waves-effect waves-light btn btn-edit orange tooltipped" data-position="top" data-tooltip="Editar" href="{{ route('sedh.tipo_servico.formulario', [ $tipo_servico->cod_tipo_servico, $tipo_servico->uniqid ]) }}"><i class="material-icons">mode_edit</i></a>
											@endcan
									</td>
								</tr>

							@endforeach
						</tbody>
					</table>
					{{-- Linha de paginação --}}
					<div class="row">
						{{ $lista->links() }}
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="container">
			<div class="row">
				<div class="col s12 m12 l12">
					@can('tipo_servico_adicionar')
					<a title="Adicionar" class="waves-effect waves-light btn-small" href="{{route('sedh.tipo_servico.formulario')}}"><i class="material-icons left">add</i>Adicionar</a>
					@endcan
					<br>
					<h5 class="breadcrumbs-title center">Nenhum registro encontrado!</h5>
					<p class="center">Utilize o botão adicionar para cadastrar um novo registro.</p>
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
	@include('sedh.tipo_servico.scripts.excluir')
	@include('scripts.inicializa_modal')
	@include('scripts.jquery-confirm')
	@include('scripts.basicTable')
	@include('scripts.material_select')
	<script>
	$(document).ready(function () {
		$('.highlight').basictable({breakpoint: 574, contentWrap: true});
	});
	</script>
@endsection
