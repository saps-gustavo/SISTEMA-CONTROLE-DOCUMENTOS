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
			<form name="busca_demanda" action="{{route('sedh.termo_administrativo')}}" method="GET">
				<div class="row">
					{{--descricao--}}

					<div class="col s12 m12 l6">

						<label for="busca_desc_tipo_termo_adm">Pesquisar por Tipo de Documento</label>

						<select id="cod_tipo_termo_adm" name="cod_tipo_termo_adm" tabindex="1">

						<option value="" selected>Selecione</option>
							@foreach($tipo_termo_adm as $tipoTermo)
							<option value="{{$tipoTermo->cod_tipo_termo_adm}}"> {{$tipoTermo->desc_resumida_ato_adm}}</option>
	
							</option>
							@endforeach

						</select>

					</div>

					<div class="col s12 m6 l3">

						<label for="busca_desc_data">Pesquisar por Data</label>
						<input type="text" name="busca_desc_data" id="busca_desc_data" value="{{ Request::get('busca_desc_data') }}" autofocus>

					</div>

					<div class="col s12 m6 l3">
						<label for="busca_desc_num_proc">Pesquisar por Número do Processo</label>
						<input type="text" name="busca_desc_num_proc" id="busca_desc_num_proc" value="{{ Request::get('busca_desc_num_proc') }}" autofocus>

					</div>

					<div class="input-field col s12 m12 l12 right-align">
						<button class="btn btn-default waves-effect waves-light" type="submit">Buscar</button>
						<a id="btnLimparBusca" class="btn teal lighten-4 waves-effect waves-light" href="{{route('sedh.termo_administrativo')}}">Limpar</a>

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
					@can('termo_administrativo_adicionar')
						<a title="Adicionar" class="waves-effect waves-light btn-small" href="{{route('sedh.termo_administrativo.formulario')}}"><i class="material-icons left">add</i>Adicionar</a>
					@endcan
				</div> &nbsp;&nbsp;&nbsp;

				<div class="card-content">
					<table class="highlight" id="tb_tipo_termo_ato_adm">
						<thead>
							<tr>
								<th data-field="termos_administrativos">Tipo do Documento</th>
								<th data-field="termos_administrativos">Data do Documento</th>
								<th data-field="termos_administrativos">Número Próximo</th>
								<th data-field="termos_administrativos">Quantidade de Aditivos</th>
								<th data-field="termos_administrativos">Editar&nbsp;Aditivo&nbsp;Listar</th>

							</tr>
						</thead>
						<tbody>
							@foreach($lista as $termos_administrativos)
								<tr>
									<td>{{ $termos_administrativos->cod_ato_adm }} - {{ $termos_administrativos->desc_resumida_ato_adm   }}</td>
									<td>{{ $termos_administrativos->dt_documento }}</td>
									<td>{{ $termos_administrativos->num_proximo }}</td>
									<td>{{ $termos_administrativos->quantidade}}</td>


									<td>
										@can('termo_administrativo_editar')
											<a class="waves-effect waves-light btn btn-edit orange tooltipped" data-position="top" data-tooltip="Editar" href="{{ route('sedh.termo_administrativo.formulario', [ $termos_administrativos->id_termo_adm, $termos_administrativos->uniqid ]) }}"><i class="material-icons">mode_edit</i></a>
										@endcan
										@can('termo_administrativo_editar')
											<a class="waves-effect waves-light btn-small" href="{{ route('sedh.termo_administrativo_aditivo.formulario', [  0, 0, $termos_administrativos->cod_tipo_termo_adm, $termos_administrativos->dt_documento, $termos_administrativos->num_proximo, $termos_administrativos->id_termo_adm ]) }}"><i class="material-icons">add</i></a>

										@endcan
										@can('termo_administrativo_editar')

											<a title="Listar Aditivos" class="waves-effect waves-light btn btn-edit blue tooltipped" data-position="top" data-tooltip="Listar Aditivos" href="{{ route('sedh.termo_administrativo_aditivo') }}?busca_desc_cod_tipo_termo_adm={{$termos_administrativos->cod_tipo_termo_adm}}&busca_desc_data={{$termos_administrativos->dt_documento}}&busca_desc_num_proximo={{$termos_administrativos->num_proximo}}"><i class="material-icons">done_all</i></a>

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
					@can('termo_administrativo_adicionar')
					<a title="Adicionar" class="waves-effect waves-light btn-small" href="{{route('sedh.termo_administrativo.formulario')}}"><i class="material-icons left">add</i>Adicionar</a>
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
	@include('sedh.termo_administrativo.scripts.excluir')
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
