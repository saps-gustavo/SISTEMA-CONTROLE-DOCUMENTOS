{{-- Breadcrumb --}}
@section('breadcrumb')
<a class="breadcrumb">Página Inicial</a>
@include('layouts._includes.home.notificacoes')
@endsection

<section id="content">
	<div class="container">

		<div class="row">
			<div class="col s12 m12 l12">
				<h4>Bem-vindo(a) ao {{ config('app.name') }} {{ config('app.surname') }}!</h4>
			</div>
		</div>
		
		{{-- Botão Ajuda --}}
		<div class="fixed-action-btn animated fadeInDown" style="right: 100px;">
			<a class="btn-floating btn-large waves-effect waves-light orange darken-2 modal-trigger" href="#ajuda"><i class="large material-icons">help</i></a>
		</div>

	</div>
</section>

{{-- Modal para ajuda --}}
<div id="ajuda" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="input-field col s12 left">
				<center>
					<h4>Sobre o {{ config('app.name') }} {{ config('app.surname') }}</h4>
				</center>
				<p>
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
				</p>
				<strong>Desenvolvido por:</strong>
				<p>
					Secretaria de Transformação Digital e Administrativa - STDA
				</p>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-teal btn btn-default" style="margin: 10px;">Fechar</a>
	</div>
</div>
@section('custom_css')
	<style>
		.modal {
			overflow-y: unset;
		}
	</style>
@endsection

@section('script')
	@include('scripts.inicializa_modal')
@endsection
