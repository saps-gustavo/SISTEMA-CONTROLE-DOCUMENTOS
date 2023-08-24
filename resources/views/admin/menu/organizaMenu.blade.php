{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')
{{-- Conteúdo da página --}}
@section('conteudo')

@section('breadcrumb')
<a href="{{url('/')}}" class="breadcrumb">{{ $titulo }}</a>
<a class="breadcrumb">{{ $subtitulo }}</a>
@include('layouts._includes.home.notificacoes')
@endsection

@include('admin.menu.css.organizaMenu')

<div class="row">
	<div class="col s12 m12 l12">
		<div class="card hoverable" style="margin: 0px;">
			<div class="card-content grey lighten-5"  style="padding: 10px">
				<form action="{{route('admin.menu.organizaMenu.salvar')}}" method="post">
					{{csrf_field()}}
					<div class="cf nestable-lists">

						<div class="dd" id="nestable">
							{{-- <div class="grupo" style="display: flex; flex-direction: column"> --}}
							<ol class="dd-list">
								{{-- CARREGA O MENU DO BD --}}
								@foreach(App\Menu::arvoreMenu(null) as $menu)

								@if(isset($menu->filhos) && $menu->filhos->count() > 0 )
									<li class="dd-item" data-id="{{$menu->id_menu}}">
										<div class="dd-handle">
											{{$menu->label_menu}}
										</div>

										<div class="acoes">
											<a class="black-text link-js edita-menu" data-id="{{$menu->id_menu}}"> <i class="tiny material-icons">create</i></a>
											<span>&nbsp; &nbsp; &nbsp;</span>

											<a class="grey-text exclui-menu-disable" data-id="{{$menu->id_menu}}"> <i class="tiny material-icons" >delete_forever</i></a>
										</div>


										<ol class="dd-list">
											@include('admin.menu._includes.partialOrganizaMenu', ['menus' => $menu->filhos])
										</ol>
									</li>

									@else
									<li class="dd-item" data-id="{{$menu->id_menu}}">
										<div class="dd-handle">{{$menu->label_menu}}</div>
										<div class="acoes">
											<a class="black-text link-js edita-menu" data-id="{{$menu->id_menu}}"> <i class="tiny material-icons">create</i></a>
											<span>&nbsp; &nbsp; &nbsp;</span>

											<a class="red-text link-js exclui-menu" data-id="{{$menu->id_menu}}"> <i class="tiny material-icons" >delete_forever</i></a>
										</div>
									</li>
								@endif
								@endforeach
							</ol>
						</div>
					</div>

					<div class="row hide">
						<div class="col s12">
							<textarea id="nestable-output" name="nestable-output" readonly="readonly"></textarea>
						</div>
					</div>
					@can('menu_adicionar')
						<a class="waves-effect waves-light btn inclui-menu"><i class="material-icons left">add</i>Incluir Novo Menu</a>
					@endcan
						<a class="waves-effect waves-light btn btn-organiza-menu"><i class="material-icons left">menu</i>Salvar Ordem</a>


				</form>
			</div>
		</div>
	</div>
</div>

<div id="container_modal"></div>
<div id="container_modal_excluir"></div>

@endsection

@section('custom_css')
	@include('css.jquery-confirm')
@endsection

@section('script')
	@include('scripts.nestable')
	@include('scripts.jquery-confirm')
	@include('admin.menu.scripts.organizaMenu')
	@include('admin.menu.scripts.formularioModal')
	@include('admin.menu.scripts.excluirMenu')
@endsection
