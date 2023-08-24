{{-- Importa o layout padrão do sistema --}}
@extends('layouts.app')

{{-- Conteúdo da página --}}
@section('conteudo')

{{-- Breadcrumb --}}
@section('breadcrumb')
<a href="{{url('/')}}" class="breadcrumb">Principal</a>
<a href="{{url('/admin/perfil')}}" class="breadcrumb">{{ $titulo }}</a>
<a class="breadcrumb">{{ $subtitulo }}</a>
@include('layouts._includes.home.notificacoes')
@endsection

<div class="row">
	<div class="col s12 m12 l12">
		<div class="card hoverable">
			<div class="card-content">
				<div id="habilidade-perfil"> 
					<h5>Associar Habilidades do Perfil {{$perfil->title}}</h5>
					<br>
					<div class="row">
						<form  class="col s12 form-habilidade"  action="{{route('admin.perfil.habilitar',$perfil->id)}}" method="post">
							{{ csrf_field() }}
							@foreach($funcionalidades as $funcionalidade)
							<div class="col l5 m12 s12 funcionalidade-section">
								<div class="row">
									<div class="col s12">
										<p>
											<label>
												<input class="funcionalidade-input" id="{{$funcionalidade->id_funcionalidade}}"  type="checkbox" {{ (in_array($funcionalidade->id_funcionalidade,$perfil->getAbilities()->pluck('id_funcionalidade')->toArray()) ) ? 'checked': ''}}/>
												<span>{{$funcionalidade->nome_funcionalidade}}</span>
											</label>
										</p>
									</div>
								</div>
								@foreach($funcionalidade->habilidades as $habilidade)
								<div class="row">
									<div class="col s12">
										<div class="col s10 m10 l10 offset-l1">
											<p>
												<label>
													<input name="habilidade[]" value="{{$habilidade->id}}" class="habilidade-input" id="{{$habilidade->id}}" type="checkbox" {{ (in_array($habilidade->id,$perfil->getAbilities()->pluck('id')->toArray()) ) ? 'checked': ''}} />
													<span>{{$habilidade->title}}</span>
												</label>
											</p>
										</div>
									</div>
								</div>
								@endforeach
							</div>
							@endforeach
							<div class="row">
								<div class="input-field col s12">
									<button class="btn btn-default waves-effect waves-light right form-edit-button dispara-loading" type="submit" name="action" style="margin-left: 10px;">Salvar
									</button>
									<a class="btn grey waves-effect waves-green right" href="{{route('admin.perfil')}}">Cancelar</a>
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
@include('admin.perfil.scripts.habilidade')
@endsection