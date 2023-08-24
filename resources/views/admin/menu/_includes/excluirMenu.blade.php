{{-- Modal para remover perfil --}}
<div id="modalRemover" class="modal">
	<div class="modal-content">
		<a class="btn-floating waves-effect waves-light grey right modal-action modal-close"><i class="material-icons">clear</i></a>
		<h5>Remover Menu: <strong>{{$menu->label_menu}}</strong></h5>
		<br>
		<div class="row center">
			<h5>Tem certeza que deseja remover o menu {{$menu->label_menu}}?</h5>
		</div>
	</div>
	<div class="row" style="margin: 0 0 15px 0">
		<div class="modal-footer">
			<div class="col s12">
				<a class="btn btn-default waves-effect modal-action modal-close btn-excluir" data-id="{{$menu->id_menu}}">Remover</a>
				<a class="btn grey waves-effect waves-light modal-action modal-close" data-dismiss="modal">Cancelar</a>
			</div>
		</div>
	</div>
</div>
