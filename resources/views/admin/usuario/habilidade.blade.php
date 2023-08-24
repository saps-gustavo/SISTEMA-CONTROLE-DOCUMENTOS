{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')

{{-- Conteúdo da página --}}
@section('conteudo')

{{-- Breadcrumb --}}
@section('breadcrumb')
<a href="{{url('/')}}" class="breadcrumb">Principal</a>
<a href="{{url('/admin/usuario')}}" class="breadcrumb">{{ $titulo }}</a>
<a class="breadcrumb">{{ $subtitulo }}</a>
@include('layouts._includes.home.notificacoes')
@endsection

<div class="row">
	<div class="col s12 m12 l12">
		<div class="card hoverable">
			<div class="card-content">
				<div id="habilidade-usuario">
					<h5>Alterar Habilidades do Usuário <b>{{$usuario->nome_usuario}}</b></h5>
					<br>
					<div class="row">
						<form  class="col s12 form-habilidade"  action="{{route('admin.usuario.habilitar',$usuario->id_usuario)}}" method="post">
							{{ csrf_field() }}
							@foreach($funcionalidades as $funcionalidade)
							<div class="col l5 m12 s12 funcionalidade-section">
								<div class="row">
									<p class="col s9 m9 l10">
										<label>
											<input class="funcionalidade-input" id="{{$funcionalidade->id_funcionalidade}}"  type="checkbox" {{ (in_array($funcionalidade->id_funcionalidade,$usuario->abilities()->pluck('id_funcionalidade')->toArray()) ) ? 'checked': ''}}/>
											<span>{{$funcionalidade->nome_funcionalidade}}</span>
										</label>
									</p>
									<p class="funcionalidade-negar-p col s1 m1 l1">
										<label>Negar</label>
									</p>
								</div>
								@foreach($funcionalidade->habilidades()->get() as $habilidade)
									@if(in_array($habilidade->id, Auth::user()->getAbilities()->pluck('id')->toArray()))
										<div class="row">
											<div class=" row ">
												<div class="col s10 m10 l11 offset-s1 offset-m1 offset-l1">
													<p class="habilidade-input-p col s10">
														<label>
															<input name="habilidade[]" value="{{$habilidade->id}}" class="habilidade-input" id="{{$habilidade->id}}" type="checkbox" {{ (in_array($habilidade->id,$usuario->abilities()->wherePivot('forbidden', false)->pluck('habilidade.id')->toArray()) ) ? 'checked': ''}} />
															<span class="titulo-habilidade {{ (in_array($habilidade->id,$usuario->abilities()->wherePivot('forbidden', true)->pluck('habilidade.id')->toArray()) ) ? 'habilidade-negada': ''}}">{{$habilidade->title}}</span>
														</label>
													</p>
													<p class="habilidade-negar-p col s1">
														<label>
															<input type="checkbox" name="habilidade-negada[]" value="{{$habilidade->id}}" class="habilidade-negar" {{ (in_array($habilidade->id,$usuario->abilities()->wherePivot('forbidden', true)->pluck('habilidade.id')->toArray()) ) ? 'checked': ''}}  />
															<span></span>
														</label>
													</p>
												</div>
											</div>
										</div>
									@endif
								@endforeach
							</div>
							@endforeach
							<div class="row">
								<div class="input-field col s12">
									<button class="btn btn-default waves-effect waves-light right form-edit-button" type="submit" name="action" style="margin-left: 10px;">Salvar
									</button>
									<a class="btn grey waves-effect waves-green right" href="{{route('admin.usuario')}}">Cancelar</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
@include('admin.usuario.scripts.habilidade')
@endsection
