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
	<div class="card hoverable">
		<div class="card-content">
			<div class="row">
				{{--Dt.Início--}}
				<div class="col s12 m6 l3">
					<label for="datainicio" class="">Data Inicial</label>
					<input id="datainicio" type="text" class="datepicker" id="datainicio" name="datainicio" value="" tabindex="1" autofocus>
				</div>
				{{--Dt.Fim--}}
				<div class="col s12 m6 l3">
					<label for="datafim" class="">Data Final</label>
					<input id="datafim" type="text" class="datepicker" name="datafim" value="" tabindex="1" autofocus>
				</div>
				{{--Tipo--}}
				<div class="select-field col s12 m12 l6">
					<label for="tipo_relatorio" class=""> 
						Tipo Relatório (*)
						<select id="tipo_relatorio" tabindex="1" autofocus>
							<option value="0" selected>Doações</option>
							<option value="1">Famílias</option>
							<option value="2">Lançamentos</option>
							<option value="3">Produtos</option>
						</select>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12 m12 l12 right-align">
					<button class="btn btn-default waves-light" type="button" onclick="RelatorioDoacao();">Buscar</button>
					<a id="btnLimparBusca" class="btn teal lighten-4 waves-light" href="{{route('relatorio')}}">Limpar</a>
				</div>
			</div>
		</div>
	</div>
	
@endsection

<div id="container-editar"></div>

@section('custom_css')
	@include('css.jquery-confirm')
@endsection

@section('script')
	@include('relatorio.scripts.funcoes')
	@include('scripts.inicializa_modal')
	@include('scripts.jquery-confirm')
	@include('scripts.basicTable')
	@include('scripts.material_select')
	@include('scripts.material_datepicker')
	@include('scripts.autocomplete')
	<script>
	$(document).ready(function () {
		$('.highlight').basictable({breakpoint: 574, contentWrap: true});
	});
	</script>
@endsection
