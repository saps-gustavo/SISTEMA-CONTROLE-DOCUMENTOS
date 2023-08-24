
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
		<form name="busca_demanda" action="{{route('sedh.termo_administrativo_aditivo')}}" method="GET">
				<div class="row">
					{{--descricao--}}

					<div class="col s12 m6 l6">
						<label for="busca_desc_tipo_termo_adm">Pesquisar por Tipo de Documento</label>

						<select id="busca_desc_cod_tipo_termo_adm" name="busca_desc_cod_tipo_termo_adm" tabindex="1">

						<option value="" selected>Selecione</option>
							@foreach($tipo_termo_adm as $tipoTermo)

							<option value="{{ trim($tipoTermo->cod_tipo_termo_adm) }}"
                                @if(old('busca_desc_cod_tipo_termo_adm') == trim($tipoTermo->cod_tipo_termo_adm) || Request::get('busca_desc_cod_tipo_termo_adm') == trim($tipoTermo->cod_tipo_termo_adm))
								
                                    selected
                                @endif
                                ->{{ $tipoTermo->desc_resumida_ato_adm }}
							
							@endforeach

							</option>


						</select>


					</div>

					<div class="col s12 m6 l6">
						<label for="busca_desc_data">Pesquisar por Data</label>
						<input type="text" name="busca_desc_data" id="busca_desc_data" value="{{ Request::get('busca_desc_data') }}" autofocus>

					</div>

					<div class="col s12 m6 l6">
						<label for="busca_desc_num_proc">Pesquisar por Número do Processo</label>
						<input type="text" name="busca_desc_num_proximo" id="busca_desc_num_proximo" value="{{ Request::get('busca_desc_num_proximo') }}" autofocus>

					</div>
				

					<div class="col s12 m6 l6">
						<label for="busca_desc_num_aditivo">Pesquisar por Número do Aditivo</label>
						<input type="text" name="busca_desc_num_aditivo" id="busca_desc_num_aditivo" value="{{ Request::get('busca_desc_num_aditivo') }}" autofocus>

					</div>

					<div class="input-field col s12 m12 l12 right-align">
						<button class="btn btn-default waves-effect waves-light" type="submit">Buscar</button>
						<a id="btnLimparBusca" class="btn teal lighten-4 waves-effect waves-light" href="{{route('sedh.termo_administrativo_aditivo')}}">Limpar</a>

						<div class="col s1 m1 l1">
						<a class="btn teal lighten-4 waves-effect waves-light" href="{{ route('sedh.termo_administrativo') }}" tabindex="17">Voltar</a>

					</div>
					</div>
				</div>


			</form>
		</div>
	</div>
	@endif

	@if(count($lista)>0)
		<div class="col s12 m12 l12">
			<div class="card hoverable">
				
				<div class="card-content">
				<table class="highlight" id="tb_tipo_termo_ato_adm">
						<thead>
							<tr>
								<th data-field="termo_administrativo_aditivo">Termo Administrativo</th>
								<th data-field="termo_administrativo_aditivo">Data do Documento</th>
								<th data-field="termo_administrativo_aditivo">Número Próximo</th>
								<th data-field="termo_administrativo_aditivo">Número do Aditivo</th>
								<th data-field="termo_administrativo_aditivo">Editar</th>

							</tr>
						</thead>
						<tbody>
						@foreach($lista as $termo_administrativo_aditivo)
								<tr>

									<td>{{ $termo_administrativo_aditivo->desc_resumida_ato_adm }}</td>
									<td>{{ $termo_administrativo_aditivo->dt_documento }}</td>
									<td>{{ $termo_administrativo_aditivo->num_proximo }}</td>
									<td>{{ $termo_administrativo_aditivo->num_aditivo }}</td>

									<td>
									@can('termo_administrativo_aditivo_editar')
											<a class="waves-effect waves-light btn btn-edit orange tooltipped" data-position="top" data-tooltip="Editar" 
											 href="{{ route('sedh.termo_administrativo_aditivo.formulario', [$termo_administrativo_aditivo->id_termo_adm_aditivo, $termo_administrativo_aditivo->uniqid, $termo_administrativo_aditivo->cod_tipo_termo_adm, $termo_administrativo_aditivo->dt_documento, $termo_administrativo_aditivo->num_proximo, $termo_administrativo_aditivo->id_termo_adm, $termo_administrativo_aditivo->num_aditivo]) }}"><i class="material-icons">mode_edit</i></a>
											
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
					@can('tipo_termo_administrativo_adicionar')
					<a title="Adicionar" class="waves-effect waves-light btn-small" href="{{route('sedh.termo_administrativo_aditivo.formulario')}}"><i class="material-icons left">add</i>Adicionar</a>
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
	@include('sedh.termo_administrativo_aditivo.scripts.excluir')
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



