{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')

{{-- Conteúdo da página --}}
@section('conteudo')
	@section('breadcrumb')
		<h5 class="breadcrumbs-title">{{ $titulo }}</h5>
		<ol class="breadcrumb">
			<li><a href="{{ url('/') }}">{{ $subtitulo }}</a></li>
			<li class="active">Calendário</li>
		</ol>
	@endsection
	<div class="container">
		<div class="section">
			<p class="caption">Acompanhe seus eventos pelo calendário abaixo. Você pode arrastar os eventos da lista e soltar no dia que deseja cadastrar o(s) evento(s).</p>
			<div class="divider"></div>
			<div id="full-calendar">
				<div class="row">
					<div class="col s12 m4 l3">
						<div id='external-events'>
							<h4 class="header">Arraste os eventos</h4>
							<div class='fc-event cyan'>Reunião com Stakeholders</div>
							<div class='fc-event teal'>Elaborar cenário de negócios</div>
							<div class='fc-event cyan darken-1'>Reunião para validação de BPMN's</div>
							<div class='fc-event cyan accent-4'>Aprovar validação</div>
							<div class='fc-event teal accent-4'>Reunião com equipe de desenvolvimento</div>
							<div class='fc-event light-blue accent-3'>Especificar requisitos do sistema</div>
							<div class='fc-event light-blue accent-4'>Projetar Banco de Dados</div>
							<p>
								<input type='checkbox' id='drop-remove' />
								<label for='drop-remove'>remover após soltar</label>
							</p>
						</div>
					</div>
					<div class="col s12 m8 l9">
						<div id='calendar'></div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection


